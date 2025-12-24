<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Tampilkan halaman keranjang
    public function show()
    {
        $userId = Auth::id();
        $carts = Cart::where('user_id', $userId)->with('menu')->get();
        $total = Cart::total($userId);

        return view('keranjang', compact('carts', 'total'));
    }

    // Tambah item ke keranjang
    public function add(Request $request)
    {
        $userId = Auth::id();
        $menuId = $request->id;
        $name = $request->name;
        $price = $request->price;
        $image = $request->image;

        // Cek apakah item sudah ada di cart
        $existingCart = Cart::where('user_id', $userId)
            ->where('menu_id', $menuId)
            ->first();

        if ($existingCart) {
            // Update quantity jika sudah ada
            $existingCart->quantity += 1;
            $existingCart->total_price = $existingCart->price * $existingCart->quantity;
            $existingCart->save();
        } else {
            // Buat cart item baru
            Cart::create([
                'user_id' => $userId,
                'menu_id' => $menuId,
                'name' => $name,
                'image' => $image,
                'price' => $price,
                'quantity' => 1,
                'total_price' => $price,
            ]);
        }

        return redirect()->route('cart')->with('success', 'Item berhasil ditambahkan ke keranjang!');
    }

    // Update quantity item
    public function update(Request $request, $id)
    {
        $cart = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        $cart->quantity = $request->quantity;
        $cart->total_price = $cart->price * $cart->quantity;
        $cart->save();

        return redirect()->route('cart')->with('success', 'Keranjang berhasil diperbarui!');
    }

    // Hapus item dari keranjang
    public function remove($id)
    {
        $cart = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $cart->delete();

        return redirect()->route('cart')->with('success', 'Item berhasil dihapus dari keranjang!');
    }

    // Kosongkan seluruh keranjang
    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();
        
        return redirect()->route('cart')->with('success', 'Keranjang berhasil dikosongkan!');
    }
    public function checkout()
    {
        $carts = auth()->user()->carts;

        $order = Order::create([
            'order_number' => 'ORD-' . time(),
            'user_id' => auth()->id(),
            'subtotal' => $carts->sum(fn($c) => $c->price * $c->quantity),
            'total_bayar' => $carts->sum(fn($c) => $c->price * $c->quantity) + 1000,
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

        return redirect()->route('orders.pay', $order->id);
    }

}
