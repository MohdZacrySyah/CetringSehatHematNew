<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $user = Auth::user();
        // Load relasi 'menu' agar bisa ambil harga & nama asli
        $carts = Cart::where('user_id', $user->id)->with('menu')->get();

        if ($carts->isEmpty()) {
            return back()->with('error', 'Keranjang Anda kosong.');
        }

        DB::beginTransaction();

        try {
            // Hitung subtotal pakai harga dari tabel Menu (bukan dari tabel cart)
            $subtotal = $carts->sum(function($item) {
                return $item->menu->price * $item->quantity;
            });
            
            $biayaAplikasi = 1000;
            $total = $subtotal + $biayaAplikasi;

            // Buat Order
            $order = Order::create([
                'order_number' => 'ORD-' . time() . rand(100, 999),
                'user_id' => $user->id,
                'subtotal' => $subtotal,
                'biaya_aplikasi' => $biayaAplikasi,
                'total_bayar' => $total,
                'status' => 'pending'
            ]);

            // Simpan Item Order
            foreach ($carts as $cart) {
                // Cek apakah menu masih ada
                if($cart->menu) {
                    $order->items()->create([
                        'menu_id' => $cart->menu_id,
                        'menu_name' => $cart->menu->name, // AMBIL DARI RELASI MENU
                        'price' => $cart->menu->price,     // AMBIL DARI RELASI MENU
                        'quantity' => $cart->quantity,
                        'subtotal' => $cart->menu->price * $cart->quantity,
                        // Pastikan di database tabel order_items ada kolom menu_image. 
                        // Jika tidak ada, hapus baris di bawah ini:
                        'menu_image' => $cart->menu->image 
                    ]);
                }
            }

            // Hapus keranjang setelah order dibuat
            Cart::where('user_id', $user->id)->delete();

            DB::commit();

            // Berhasil! Lanjut ke halaman pembayaran Midtrans
            return redirect()->route('orders.pay', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            // Kembalikan ke keranjang dengan pesan error
            return back()->with('error', 'Gagal Checkout: ' . $e->getMessage());
        }
    }
}