<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderNotification;

class AdminOrderController extends Controller
{
    // 1. LIHAT SEMUA PESANAN MASUK
    public function index()
    {
        $orders = Order::with(['user', 'items'])->latest()->paginate(10); 
        return view('admin.orders.index', compact('orders'));
    }

    // 2. LIHAT DETAIL PESANAN
    public function show($id)
    {
        $order = Order::with(['user', 'items'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    // 3. UPDATE STATUS PESANAN (+ NOTIFIKASI KHUSUS)
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,paid,processing,completed,cancelled'
        ]);

        // Update Status
        $order->update([
            'status' => $request->status
        ]);

        // --- LOGIKA NOTIFIKASI KHUSUS ---
        $title = 'Status Pesanan Berubah'; // Default Title
        $pesan = '';

        if($request->status == 'processing') {
            $title = 'Pesanan Sedang Dimasak 🍳';
            $pesan = 'Hore! Pesanan #' . $order->order_number . ' sedang disiapkan oleh dapur kami. Mohon ditunggu ya!';
        
        } elseif($request->status == 'completed') {
            $title = 'Pesanan Selesai & Diantar 🚀';
            $pesan = 'Pesanan #' . $order->order_number . ' sudah selesai. Selamat menikmati! Jangan lupa berikan ulasan bintang 5 ya ⭐';
        
        } elseif($request->status == 'cancelled') {
            $title = 'Pesanan Dibatalkan ❌';
            $pesan = 'Mohon maaf, pesanan #' . $order->order_number . ' dibatalkan. Silakan hubungi admin jika ada kesalahan.';
        
        } elseif($request->status == 'paid') {
            $title = 'Pembayaran Diterima ✅';
            $pesan = 'Terima kasih! Pembayaran untuk pesanan #' . $order->order_number . ' telah kami terima. Segera kami proses.';
        }

        // Simpan Notifikasi jika ada pesan
        if($pesan) {
            OrderNotification::create([
                'user_id' => $order->user_id,
                'order_id' => $order->id,
                'title'   => $title,    // Gunakan judul yang sudah dikustomisasi
                'message' => $pesan,
                'is_read' => false
            ]);
        }
        // ---------------------------------

        return back()->with('success', 'Status pesanan berhasil diperbarui & notifikasi dikirim!');
    }
}