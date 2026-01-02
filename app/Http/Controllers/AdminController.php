<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu; // <--- Tambahkan ini di paling atas
use Illuminate\Support\Facades\Storage; // <--- Tambahkan ini untuk hapus gambar
use App\Models\Order; // <--- JANGAN LUPA TAMBAHKAN INI
use App\Models\User;
use App\Models\Review;

class AdminController extends Controller
{
    public function index()
{
    // Hitung data untuk dashboard
    $totalOrders = Order::count();
    
    // Hitung pendapatan (hanya yg statusnya paid/processing/completed)
    $revenue = Order::whereIn('status', ['paid', 'processing', 'completed'])->sum('total_bayar');
    
    $totalMenus = Menu::count();

    // Ambil 5 order terbaru
    $recentOrders = Order::with('user')->latest()->take(5)->get();

    return view('admin.dashboard', compact('totalOrders', 'revenue', 'totalMenus', 'recentOrders'));
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
public function editMenu(Menu $menu)
    {
        return view('admin.menus.edit', compact('menu'));
    }

    // 9. Update Menu ke Database
    public function updateMenu(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
        ];

        // Cek jika ada gambar baru yang diupload
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($menu->image) {
                Storage::disk('public')->delete($menu->image);
            }
            // Simpan gambar baru
            $data['image'] = $request->file('image')->store('menu_images', 'public');
        }

        $menu->update($data);

        return redirect()->route('admin.menus')->with('success', 'Menu berhasil diperbarui!');
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
    // --- TAMBAHKAN KODE INI DI BAGIAN BAWAH SEBELUM KURUNG KURAWAL TUTUP TERAKHIR ---

    // 5. Tampilkan Daftar Pesanan Masuk
    public function orders()
    {
        // Ambil data order, urutkan dari yang terbaru, dan sertakan data user-nya
        $orders = Order::with('user')->latest()->get();
        
        return view('admin.orders.index', compact('orders'));
    }
    public function showOrder(Order $order)
    {
        // Ambil data order beserta item menu dan data user-nya
        $order->load(['items.menu', 'user']);
        return view('admin.orders.show', compact('order'));
    }

    // 7. Update Status Pesanan
    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,processing,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
   public function reviews()
    {
        // Ambil data review, urutkan dari yang terbaru
        $reviews = Review::with(['user', 'order'])->latest()->paginate(10);
        
        return view('admin.reviews.index', compact('reviews'));
    }

}