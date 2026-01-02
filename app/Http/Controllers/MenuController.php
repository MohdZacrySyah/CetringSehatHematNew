<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu; // Penting: Import Model Menu

class MenuController extends Controller
{
    // Fungsi untuk menampilkan Detail Menu
    public function show($id)
    {
        // 1. Ambil data menu berdasarkan ID
        // 'with('reviews')' memuat data ulasan sekaligus (jika Anda sudah buat relasi di Model Menu)
        // Jika belum ada relasi reviews, bisa dihapus 'with(...)' nya, tapi nanti rating jadi 0 semua.
        $menu = Menu::with('reviews')->findOrFail($id);

        // 2. Logika Hitung Rating (Agar bar bintangnya jalan)
        $totalReviews = $menu->reviews->count();
        $avgRating = $totalReviews > 0 ? $menu->reviews->avg('rating') : 0;
        
        // Hitung jumlah orang yang kasih bintang 5, 4, 3, dst
        $starCounts = [
            5 => $menu->reviews->where('rating', 5)->count(),
            4 => $menu->reviews->where('rating', 4)->count(),
            3 => $menu->reviews->where('rating', 3)->count(),
            2 => $menu->reviews->where('rating', 2)->count(),
            1 => $menu->reviews->where('rating', 1)->count(),
        ];

        // 3. Kirim semua data ke View 'menu.detail'
        return view('menu.detail', compact('menu', 'totalReviews', 'avgRating', 'starCounts'));
    }
}