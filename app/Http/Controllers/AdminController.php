<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu; // <--- Tambahkan ini di paling atas
use Illuminate\Support\Facades\Storage; // <--- Tambahkan ini untuk hapus gambar

class AdminController extends Controller
{
    public function index()
    {
        // Menampilkan halaman dashboard admin
        return view('admin.dashboard');
    }
    // 1. Tampilkan Daftar Menu
    public function menus()
    {
        $menus = Menu::all();
        return view('admin.menus.index', compact('menus'));
    }

    // 2. Tampilkan Form Tambah Menu
    public function createMenu()
    {
        return view('admin.menus.create');
    }

    // 3. Simpan Menu Baru ke Database
    public function storeMenu(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category' => 'required|string', // Pastikan kolom ini ada di tabel menus Anda
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menu_images', 'public');
        }

        Menu::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.menus')->with('success', 'Menu berhasil ditambahkan!');
    }

    // 4. Hapus Menu
    public function destroyMenu(Menu $menu)
    {
        // Hapus gambar jika ada
        if ($menu->image) {
            Storage::disk('public')->delete($menu->image);
        }
        
        $menu->delete();
        return redirect()->back()->with('success', 'Menu berhasil dihapus!');
    }
}