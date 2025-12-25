<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    // --- KONFIGURASI MIDTRANS ---
    protected function initMidtrans() {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    // 1. TAMPILKAN HALAMAN BAYAR
    public function showPayment($orderId)
    {
        $order = Order::with('user')->findOrFail($orderId);

        // Validasi pemilik order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Jika status sudah bukan pending, langsung ke sukses
        if ($order->status != 'pending') {
            return redirect()->route('order.success', $order->id);
        }

        $this->initMidtrans();

        $params = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => (int) $order->total_bayar,
            ],
            'customer_details' => [
                'first_name' => $order->user->name,
                'email' => $order->user->email,
                'phone' => $order->user->phone ?? '08123456789',
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
        } catch (\Exception $e) {
            return back()->with('error', 'Error Midtrans: ' . $e->getMessage());
        }

        return view('order.payment-show', compact('order', 'snapToken'));
    }

    // 2. HALAMAN SUKSES (UPDATE STATUS & SIMPAN DATA)
    public function success(Request $request, Order $order)
    {
        // Validasi pemilik order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // AMBIL DATA DARI URL (Query String)
        $paymentJson = $request->query('payment_data');

        // Jika ada data pembayaran dari Midtrans, simpan!
        if ($paymentJson) {
            $paymentData = json_decode($paymentJson, true);
            
            $order->update([
                'status' => 'paid',
                'paid_at' => now(),
                'payment_method' => $paymentData['payment_type'] ?? 'midtrans',
                'midtrans_transaction_id' => $paymentData['transaction_id'] ?? null,
                'midtrans_order_id' => $paymentData['order_id'] ?? null,
                'payment_response' => $paymentJson 
            ]);
        } 
        
        return view('order.success', compact('order'));
    }

    // 3. DETAIL PESANAN (INI YANG SEBELUMNYA HILANG)
    public function detail($orderId)
    {
        // Load order beserta item-itemnya
        $order = Order::with('items')->findOrFail($orderId);
        
        // Validasi pemilik
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('order.detail', compact('order'));
    }

    // 4. CETAK STRUK (OPSIONAL)
    public function struktur()
    {
        return redirect()->route('dashboard'); 
    }
}