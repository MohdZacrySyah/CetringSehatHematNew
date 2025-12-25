<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class AdminOrderController extends Controller
{
    // 1. LIHAT SEMUA PESANAN MASUK
    public function index()
    {
        // Ambil order terbaru, load relasi user dan items biar hemat query
        $orders = Order::with(['user', 'items'])
                    ->latest()
                    ->paginate(10); // Tampilkan 10 per halaman

        return view('admin.orders.index', compact('orders'));
    }

    // 2. LIHAT DETAIL PESANAN (Opsional, jika admin mau lihat detail menu)
    public function show($id)
    {
        $order = Order::with(['user', 'items'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    // 3. UPDATE STATUS PESANAN (PENTING)
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,paid,processing,completed,cancelled'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}