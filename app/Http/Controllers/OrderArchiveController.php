<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // PENTING: Gunakan model Order utama, bukan OrderArchive
use Illuminate\Support\Facades\Auth;

class OrderArchiveController extends Controller
{
    /**
     * 1. LIST PESANAN SAYA (History)
     * Menampilkan semua pesanan (Sedang dipesan, Selesai, atau Batal)
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil data langsung dari tabel 'orders'
        // Filter berdasarkan user_id
        // Load relasi 'items' agar bisa menampilkan gambar/nama menu di view
        $orders = Order::where('user_id', $user->id)
                        ->with('items') 
                        ->latest()      // Urutkan dari yang terbaru
                        ->paginate(10); // Pagination 10 item per halaman

        // Kirim data sebagai variabel '$orders' agar sesuai dengan view 'arsip-pesanan' yang baru
        return view('arsip-pesanan', compact('orders'));
    }

    /**
     * 2. DETAIL PESANAN
     */
    public function detail($id)
    {
        // Cari order di tabel utama
        $order = Order::where('id', $id)
                      ->where('user_id', Auth::id())
                      ->with('items')
                      ->firstOrFail();

        // Gunakan view detail order yang sudah ada (reusable)
        return view('order.detail', compact('order'));
    }

    /**
     * 3. BELI LAGI (Opsional)
     * Untuk saat ini kita arahkan ke menu utama agar user memilih manual
     */
    public function buyAgain($id)
    {
        // Fitur re-order otomatis bisa dikembangkan nanti (add to cart logic)
        // Untuk sekarang redirect ke menu
        return redirect()->url('/menu')->with('success', 'Silakan pilih menu favorit Anda kembali.');
    }

    /**
     * 4. HAPUS SATU (Dinonaktifkan)
     * Data transaksi asli tidak boleh dihapus user, hanya bisa di-Cancel.
     */
    public function destroy($id)
    {
        return back()->with('error', 'Riwayat pesanan tidak dapat dihapus demi data transaksi. Gunakan tombol Batalkan jika status masih pending.');
    }

    /**
     * 5. HAPUS SEMUA (Dinonaktifkan)
     */
    public function clearAll()
    {
        return back()->with('error', 'Riwayat pesanan tidak dapat dihapus.');
    }
}