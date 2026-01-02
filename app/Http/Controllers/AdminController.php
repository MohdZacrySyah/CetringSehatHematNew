<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $totalOrders = Order::count();
        
        // PERBAIKAN: Menambahkan variabel $revenue yang hilang
        $revenue = Order::whereIn('status', ['paid', 'completed', 'processing'])
                        ->sum('total_bayar');

        $totalMenus = Menu::count();
        $totalUsers = User::where('role', 'user')->count();

        $recentOrders = Order::with('user')
                             ->latest()
                             ->limit(5)
                             ->get();

        return view('admin.dashboard', compact(
            'totalOrders', 
            'revenue',        // <-- Variabel ini penting
            'totalMenus', 
            'totalUsers', 
            'recentOrders'
        ));
    }

    public function menus()
    {
        $menus = Menu::paginate(10);
        return view('admin.menus.index', compact('menus'));
    }

    public function createMenu()
    {
        return view('admin.menus.create');
    }

    public function storeMenu(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category' => 'required|in:makanan,minuman,snack',
            'is_paket_hemat' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('menus', 'public');
            $validated['image'] = $path;
        }

        Menu::create($validated);

        return redirect()->route('admin.menus')->with('success', 'Menu berhasil ditambahkan');
    }

    public function editMenu(Menu $menu)
    {
        return view('admin.menus.edit', compact('menu'));
    }

    public function updateMenu(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category' => 'required|in:makanan,minuman,snack',
            'is_paket_hemat' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('menus', 'public');
            $validated['image'] = $path;
        }

        $menu->update($validated);

        return redirect()->route('admin.menus')->with('success', 'Menu berhasil diperbarui');
    }

    public function destroyMenu(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('admin.menus')->with('success', 'Menu berhasil dihapus');
    }
    
    public function reviews()
    {
        $reviews = Review::with(['user', 'menu'])->latest()->paginate(10);
        return view('admin.reviews.index', compact('reviews'));
    }
}