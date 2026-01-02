<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderNotification;

class AdminOrderController extends Controller
{
    /**
     * 1. LIHAT SEMUA PESANAN MASUK
     */
    public function index()
    {
        // Mengambil data order dengan relasi user dan item, diurutkan dari yang terbaru
        $orders = Order::with(['user', 'items'])->latest()->paginate(10); 
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * 2. LIHAT DETAIL PESANAN
     */
    public function show($id)
    {
        $order = Order::with(['user', 'items'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * 3. UPDATE STATUS PESANAN (+ NOTIFIKASI OTOMATIS)
     */
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // Validasi input status (tambahkan 'shipped' agar kompatibel dengan view admin)
        $request->validate([
            'status' => 'required|in:pending,paid,processing,shipped,completed,cancelled'
        ]);

        // Update Status di Database
        $order->update([
            'status' => $request->status
        ]);

        // --- LOGIKA NOTIFIKASI KHUSUS ---
        $title = 'Status Pesanan Berubah'; 
        $pesan = '';

        // Tentukan pesan berdasarkan status yang dipilih
        switch ($request->status) {
            case 'paid':
                $title = 'Pembayaran Diterima ✅';
                $pesan = 'Terima kasih! Pembayaran untuk pesanan #' . $order->order_number . ' telah kami terima. Segera kami proses.';
                break;

            case 'processing':
                $title = 'Pesanan Sedang Dimasak 🍳';
                $pesan = 'Hore! Pesanan #' . $order->order_number . ' sedang disiapkan oleh dapur kami. Mohon ditunggu ya!';
                break;

            case 'shipped':
                $title = 'Pesanan Sedang Diantar 🛵';
                $pesan = 'Kurir kami sedang menuju ke lokasi kamu membawa pesanan #' . $order->order_number . '. Siap-siap ya!';
                break;

            case 'completed':
                $title = 'Pesanan Selesai 🏁';
                $pesan = 'Pesanan #' . $order->order_number . ' sudah sampai. Selamat menikmati! Jangan lupa berikan ulasan bintang 5 ya ⭐';
                break;

            case 'cancelled':
                $title = 'Pesanan Dibatalkan ❌';
                $pesan = 'Mohon maaf, pesanan #' . $order->order_number . ' dibatalkan. Silakan hubungi admin jika ini kesalahan.';
                break;
        }

        // Simpan Notifikasi ke Database (Hanya jika pesan ada)
        if ($pesan) {
            OrderNotification::create([
                'user_id' => $order->user_id,
                'order_id' => $order->id,
                'title'   => $title,
                'message' => $pesan,
                'is_read' => false
            ]);
        }
        // ---------------------------------

        return back()->with('success', 'Status pesanan berhasil diperbarui & notifikasi dikirim ke user!');
    }
}