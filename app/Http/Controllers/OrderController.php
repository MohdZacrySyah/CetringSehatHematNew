<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    // --- KONFIGURASI MIDTRANS ---
    protected function initMidtrans()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * 1. HALAMAN CHECKOUT (Input Alamat & Catatan)
     */
    public function checkoutPage()
    {
        $user = Auth::user();
        $carts = Cart::where('user_id', $user->id)->with('menu')->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Keranjang kosong!');
        }

        // Hitung total
        $subtotal = $carts->sum(fn($cart) => $cart->menu->price * $cart->quantity);
        $biayaPengiriman = 1000;
        $biayaAplikasi = 1000;
        $totalBayar = $subtotal + $biayaPengiriman + $biayaAplikasi;

        return view('order.checkout', compact('carts', 'subtotal', 'biayaPengiriman', 'biayaAplikasi', 'totalBayar', 'user'));
    }

    /**
     * 2. PROSES BUAT ORDER
     */
    public function processCheckout(Request $request)
    {
        $request->validate([
            'delivery_address' => 'required|string|max:500',
            'customer_notes' => 'nullable|string|max:255',
            'payment_method' => 'required|in:qris,gopay,va,cod', // Validasi metode pembayaran
        ]);

        $user = Auth::user();
        $carts = Cart::where('user_id', $user->id)->with('menu')->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart');
        }

        DB::beginTransaction();
        try {
            // Hitung Ulang Total
            $subtotal = $carts->sum(fn($c) => $c->menu->price * $c->quantity);
            $biayaPengiriman = 1000;
            $biayaAplikasi = 1000;
            $totalBayar = $subtotal + $biayaPengiriman + $biayaAplikasi;

            // Create Order
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'subtotal' => $subtotal,
                'biaya_pengiriman' => $biayaPengiriman,
                'biaya_aplikasi' => $biayaAplikasi,
                'total_bayar' => $totalBayar,
                'status' => 'pending',
                'delivery_address' => $request->delivery_address,
                'customer_notes' => $request->customer_notes,
                'payment_method' => $request->payment_method, // Simpan metode pembayaran pilihan user
                'payment_due_at' => Carbon::now()->addHours(24), // BATAS 24 JAM
            ]);

            // Pindahkan Item Keranjang ke OrderItems
            foreach ($carts as $cart) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $cart->menu_id,
                    'menu_name' => $cart->menu->name,
                    'menu_image' => $cart->menu->image,
                    'price' => $cart->menu->price,
                    'quantity' => $cart->quantity,
                    'subtotal' => $cart->menu->price * $cart->quantity,
                ]);
            }

            // Kosongkan Keranjang
            Cart::where('user_id', $user->id)->delete();

            DB::commit();

            // Redirect ke halaman pembayaran (showPayment)
            return redirect()->route('order.payment.show', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat pesanan: ' . $e->getMessage());
        }
    }

    /**
     * 3. TAMPILKAN HALAMAN BAYAR (LOGIC UPDATE)
     * - Jika COD: Langsung tampilkan instruksi (bypass Midtrans)
     * - Jika Online: Panggil Midtrans tapi BATASI metodenya sesuai pilihan user
     */
    public function showPayment($orderId)
    {
        $order = Order::with('user')->findOrFail($orderId);

        // Validasi pemilik order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Cek Expired (Khusus Non-COD, karena COD bayar nanti)
        if ($order->payment_method != 'cod' && $order->status == 'pending' && $order->payment_due_at && Carbon::now()->greaterThan($order->payment_due_at)) {
            $order->update(['status' => 'cancelled']);
            return redirect()->route('order.detail', $order->id)
                             ->with('error', 'Waktu pembayaran telah habis. Pesanan dibatalkan otomatis.');
        }

        // --- SKENARIO 1: COD (BAYAR DI TEMPAT) ---
        // Jika user pilih COD, kita tidak perlu memanggil Midtrans sama sekali.
        if ($order->payment_method == 'cod') {
            // Langsung tampilkan view (view akan menghandle tampilan khusus COD)
            return view('order.payment-show', compact('order'));
        }

        // --- SKENARIO 2: ONLINE PAYMENT (MIDTRANS) ---
        // Jika status sudah bukan pending (misal sudah paid), langsung ke sukses
        if ($order->status != 'pending') {
            return redirect()->route('order.success', $order->id);
        }

        $this->initMidtrans();

        // LOGIC KUNCI: Mapping Pilihan User ke 'enabled_payments' Midtrans
        // Ini memaksa Midtrans hanya menampilkan metode yang dipilih user
        $enabledPayments = [];
        if ($order->payment_method == 'qris') {
            $enabledPayments = ['qris']; 
        } elseif ($order->payment_method == 'gopay') {
            $enabledPayments = ['gopay'];
        } elseif ($order->payment_method == 'va') {
            // Izinkan semua Virtual Account populer
            $enabledPayments = ['bank_transfer', 'echannel', 'permata_va', 'bca_va', 'bni_va', 'bri_va', 'cimb_va'];
        } else {
            // Fallback default jika metode tidak dikenali (opsional)
            $enabledPayments = ['qris', 'gopay', 'bank_transfer'];
        }

        $params = [
            'transaction_details' => [
                'order_id' => $order->order_number, // Gunakan order_number agar unik
                'gross_amount' => (int) $order->total_bayar,
            ],
            'customer_details' => [
                'first_name' => $order->user->name,
                'email' => $order->user->email,
                'phone' => $order->user->phone ?? '08123456789',
                'billing_address' => [
                    'address' => $order->delivery_address 
                ]
            ],
            // Masukkan parameter enabled_payments disini
            'enabled_payments' => $enabledPayments,
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
        } catch (\Exception $e) {
            return back()->with('error', 'Error Midtrans: ' . $e->getMessage());
        }

        return view('order.payment-show', compact('order', 'snapToken'));
    }

    /**
     * 4. HALAMAN SUKSES (UPDATE STATUS DARI FRONTEND MIDTRANS)
     */
    public function success(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // AMBIL DATA DARI URL
        $paymentJson = $request->query('payment_data');

        // PERBAIKAN: Validasi JSON sebelum update
        if ($paymentJson) {
            $paymentData = json_decode($paymentJson, true);
            
            // Cek apakah JSON valid (tidak null)
            if (json_last_error() === JSON_ERROR_NONE && is_array($paymentData)) {
                $order->update([
                    'status' => 'paid',
                    'paid_at' => now(),
                    // Ambil payment_type, jika tidak ada default ke 'midtrans'
                    'payment_method' => $paymentData['payment_type'] ?? 'midtrans', 
                    'midtrans_transaction_id' => $paymentData['transaction_id'] ?? null,
                    'midtrans_order_id' => $paymentData['order_id'] ?? null,
                    'payment_response' => $paymentJson // Simpan JSON string asli yang valid
                ]);
            } else {
                // Jika JSON rusak, update status saja tanpa detail response yang bikin error
                $order->update([
                    'status' => 'paid',
                    'paid_at' => now(),
                    'payment_method' => 'midtrans_unknown'
                ]);
            }
        } 
        
        return view('order.success', compact('order'));
    }

    /**
     * 5. BATALKAN PESANAN (MANUAL OLEH USER)
     */
    public function cancelOrder($id)
    {
        $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Hanya bisa batal jika status masih pending
        if ($order->status == 'pending') {
            $order->update(['status' => 'cancelled']);
            return redirect()->route('order.detail', $id)->with('success', 'Pesanan berhasil dibatalkan.');
        }

        return back()->with('error', 'Pesanan tidak dapat dibatalkan karena sudah diproses/selesai.');
    }

    /**
     * 6. DETAIL PESANAN
     */
    public function detail($orderId)
    {
        $order = Order::with('items')->findOrFail($orderId);
        
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('order.detail', compact('order'));
    }

    /**
     * 7. CETAK STRUK (OPSIONAL)
     */
    public function struktur()
    {
        return redirect()->route('dashboard'); 
    }
}