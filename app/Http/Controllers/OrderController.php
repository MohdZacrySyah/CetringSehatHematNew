<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Halaman pilih metode pembayaran (langsung dari cart)
    public function paymentMethod()
    {
        $user = Auth::user();
        $carts = Cart::where('user_id', $user->id)->with('menu')->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Keranjang kosong!');
        }

        $subtotal = $carts->sum(function ($cart) {
            return $cart->menu->price * $cart->quantity;
        });

        $biayaPengiriman = 1000;
        $biayaAplikasi = 1000;
        $totalBayar = $subtotal + $biayaPengiriman + $biayaAplikasi;

        return view('order.payment-method', compact('carts', 'subtotal', 'biayaPengiriman', 'biayaAplikasi', 'totalBayar'));
    }

    // Proses pilih metode pembayaran & create order
    public function selectPaymentMethod(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:dana,gopay,linkaja,ovo,qris,cod',
        ]);

        $user = Auth::user();
        $carts = Cart::where('user_id', $user->id)->with('menu')->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Keranjang kosong!');
        }

        DB::beginTransaction();
        try {
            $subtotal = $carts->sum(function ($cart) {
                return $cart->menu->price * $cart->quantity;
            });

            $biayaPengiriman = 1000;
            $biayaAplikasi = 1000;
            $totalBayar = $subtotal + $biayaPengiriman + $biayaAplikasi;

            // Create order
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => $user->id,
                'subtotal' => $subtotal,
                'biaya_pengiriman' => $biayaPengiriman,
                'biaya_aplikasi' => $biayaAplikasi,
                'total_bayar' => $totalBayar,
                'payment_method' => $request->payment_method,
                'custom_note' => $request->custom_note,
                'status' => 'pending',
            ]);

            // Create order items dengan menyimpan gambar
            foreach ($carts as $cart) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $cart->menu_id,
                    'menu_name' => $cart->menu->name,
                    'menu_image' => $cart->menu->image, // SIMPAN GAMBAR
                    'price' => $cart->menu->price,
                    'quantity' => $cart->quantity,
                    'subtotal' => $cart->menu->price * $cart->quantity,
                ]);
            }

            // Hapus cart setelah checkout
            Cart::where('user_id', $user->id)->delete();

            DB::commit();

            // Redirect ke halaman detail pembayaran
            return redirect()->route('order.payment.detail', $order->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal membuat pesanan: ' . $e->getMessage());
        }
    }

    // Halaman detail pembayaran (penerima & nomor)
    public function paymentDetail($orderId)
    {
        $order = Order::with('items')->findOrFail($orderId);
        
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('order.payment-detail', compact('order'));
    }

    // Halaman QR Code
    public function showQRCode($orderId)
    {
        $order = Order::with('items')->findOrFail($orderId);
        
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('order.payment-qr', compact('order'));
    }

    // Halaman loading
    public function loading($orderId)
    {
        $order = Order::findOrFail($orderId);
        
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Update status order menjadi paid
        $order->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        return view('order.loading', compact('order'));
    }

    // Halaman sukses
    public function success($orderId)
    {
        $order = Order::with('items')->findOrFail($orderId);
        
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('order.success', compact('order'));
    }

    // Halaman detail pesanan
    public function detail($orderId)
    {
        $order = Order::with('items')->findOrFail($orderId);
        
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('order.detail', compact('order'));
    }
}
