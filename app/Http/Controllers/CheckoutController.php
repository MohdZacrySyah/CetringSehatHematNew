<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\OrderItem; // Tambahkan ini untuk keamanan
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $user = Auth::user();

        // 1. Ambil Keranjang User (Load relasi 'menu' untuk ambil data asli)
        $carts = Cart::where('user_id', $user->id)->with('menu')->get();

        // Cek jika keranjang kosong
        if ($carts->isEmpty()) {
            return back()->with('error', 'Keranjang Anda kosong.');
        }

        // 2. Mulai Transaksi Database
        DB::beginTransaction();

        try {
            // 3. Hitung Total & Subtotal
            // Kita hitung ulang dari tabel Menu (bukan Cart) untuk keamanan harga
            $subtotal = $carts->sum(function($item) {
                return $item->menu->price * $item->quantity;
            });
            
            $biayaAplikasi = 1000;
            $total = $subtotal + $biayaAplikasi;

            // 4. Buat Data Order (Master)
            $order = Order::create([
                'order_number'    => 'ORD-' . time() . rand(100, 999),
                'user_id'         => $user->id,
                'subtotal'        => $subtotal,
                'biaya_aplikasi'  => $biayaAplikasi,
                'total_bayar'     => $total,
                'status'          => 'pending', // Status awal
                'payment_method'  => $request->payment_method ?? 'bank_transfer', // Default jika tidak ada input
            ]);

            // 5. Simpan Rincian Item (Order Items)
            foreach ($carts as $cart) {
                // Pastikan menu masih ada di database
                if($cart->menu) {
                    OrderItem::create([
                        'order_id'   => $order->id,
                        'menu_id'    => $cart->menu_id,
                        'menu_name'  => $cart->menu->name,     // Snapshot Nama (cegah perubahan nama menu nanti)
                        'price'      => $cart->menu->price,    // Snapshot Harga
                        'quantity'   => $cart->quantity,
                        'subtotal'   => $cart->menu->price * $cart->quantity, // <--- INI PERBAIKAN UTAMA (Wajib Ada)
                        'menu_image' => $cart->menu->image     // Snapshot Gambar
                    ]);
                }
            }

            // 6. Kosongkan Keranjang
            Cart::where('user_id', $user->id)->delete();

            // 7. Commit Transaksi (Simpan Permanen)
            DB::commit();

            // 8. Redirect ke Pembayaran
            return redirect()->route('orders.pay', $order->id)->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            // Jika ada error, batalkan semua perubahan database
            DB::rollBack();
            
            // Debugging: Tampilkan pesan error spesifik
            return back()->with('error', 'Gagal Checkout: ' . $e->getMessage());
        }
    }
}