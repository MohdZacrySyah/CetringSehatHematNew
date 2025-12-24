<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $user = auth()->user();
        $carts = Cart::where('user_id', $user->id)->get();

        if ($carts->isEmpty()) {
            return back()->with('error', 'Keranjang kosong');
        }

        DB::beginTransaction();

        try {
            $subtotal = $carts->sum(fn($c) => $c->price * $c->quantity);
            $biayaAplikasi = 1000;
            $total = $subtotal + $biayaAplikasi;

            $order = Order::create([
                'order_number' => 'ORD-' . time(),
                'user_id' => $user->id,
                'subtotal' => $subtotal,
                'biaya_aplikasi' => $biayaAplikasi,
                'total_bayar' => $total,
                'status' => 'pending'
            ]);

            foreach ($carts as $cart) {
                $order->items()->create([
                    'menu_id' => $cart->menu_id,
                    'menu_name' => $cart->name,
                    'price' => $cart->price,
                    'quantity' => $cart->quantity,
                    'subtotal' => $cart->price * $cart->quantity,
                ]);
            }

            // kosongkan keranjang
            Cart::where('user_id', $user->id)->delete();

            DB::commit();

            return redirect()->route('orders.pay', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Checkout gagal');
        }
    }
}
