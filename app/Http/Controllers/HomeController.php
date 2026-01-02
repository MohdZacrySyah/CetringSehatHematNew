<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class HomeController extends Controller
{
  public function index()
    {
        // 1. Ambil Semua Menu (Untuk daftar utama di bawah)
        $menus = Menu::all();

        // 2. Ambil Menu Khusus Kategori "Makanan Sehat" (Termasuk support data lama 'paket_hemat')
        $makananSehat = Menu::whereIn('category', ['makanan_sehat', 'paket_hemat'])->get();

        return view('home', compact('menus', 'makananSehat'));
    }
}
