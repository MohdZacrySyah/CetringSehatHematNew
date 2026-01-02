<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Order;
use App\Models\User;
use App\Models\Review;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
   public function index()
{
    $totalOrders = Order::count();
    $totalMenus = Menu::count();
    $totalUsers = User::where('role', 'user')->count();
    $recentOrders = Order::latest()->take(5)->get();

    // ADD THIS LINE: Calculate Revenue (Sum of 'total_bayar' where status is 'paid')
    // Ensure you import the Order model if not already imported
    $revenue = Order::where('status', 'paid')->sum('total_bayar'); 

    return view('admin.dashboard', compact(
        'totalOrders', 
        'totalMenus', 
        'totalUsers', 
        'recentOrders',
        'revenue' // <--- Pass the new variable here
    ));
}
    // --- MANAJEMEN MENU ---

    public function menus()
    {
        $menus = Menu::latest()->get();
        return view('admin.menus.index', compact('menus'));
    }

    public function createMenu()
    {
        return view('admin.menus.create');
    }

    // 1. PERBAIKAN STORE MENU (TAMBAH)
    public function storeMenu(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            // Validasi kategori harus mencakup 'makanan_sehat'
            'category' => 'required|in:makanan,minuman,snack,makanan_sehat,paket_hemat', 
            // Validasi gambar max 5MB agar aman
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', 
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menus', 'public');
            $data['image'] = $imagePath;
        }

        Menu::create($data);

        return redirect()->route('admin.menus')->with('success', 'Menu berhasil ditambahkan!');
    }

    public function editMenu($id)
    {
        $menu = Menu::findOrFail($id);
        return view('admin.menus.edit', compact('menu'));
    }

    // 2. PERBAIKAN UPDATE MENU (EDIT)
    public function updateMenu(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            // Validasi kategori
            'category' => 'required|in:makanan,minuman,snack,makanan_sehat,paket_hemat',
            // Validasi gambar max 5MB
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $data = $request->except(['image']);

        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($menu->image && Storage::disk('public')->exists($menu->image)) {
                Storage::disk('public')->delete($menu->image);
            }
            
            $path = $request->file('image')->store('menus', 'public');
            $data['image'] = $path;
        }

        $menu->update($data);

        return redirect()->route('admin.menus')->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroyMenu($id)
    {
        $menu = Menu::findOrFail($id);
        
        if ($menu->image && Storage::disk('public')->exists($menu->image)) {
            Storage::disk('public')->delete($menu->image);
        }

        $menu->delete();

        return redirect()->route('admin.menus')->with('success', 'Menu berhasil dihapus!');
    }

    public function reviews()
    {
        $reviews = Review::with('user', 'menu')->latest()->get();
        return view('admin.reviews.index', compact('reviews'));
    }
}