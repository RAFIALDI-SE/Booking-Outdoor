<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $userId = Auth::id(); // <-- Wajib pakai ini

        $cartItems = Cart::with('product')
            ->where('user_id', $userId)
            ->get();

        $total = $cartItems->sum('subtotal');

        return view('members.carts', compact('cartItems', 'total'));
    }


    public function update(Request $request, $id)
    {
        $userId = Auth::id();

        $cart = Cart::where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();

        $cart->quantity = $request->quantity;

        $cart->subtotal = $cart->product->price_per_day * $cart->quantity * $cart->rent_days;
        $cart->save();

        return back()->with('success', 'Quantity berhasil diperbarui.');
    }


    public function updateDays(Request $request)
    {
        $userId = Auth::id();

        $cartItems = Cart::where('user_id', $userId)->get();

        foreach ($cartItems as $item) {
            $item->rent_days = $request->rent_days;
            $item->subtotal = $item->product->price_per_day * $item->quantity * $item->rent_days;
            $item->save();
        }

        return back()->with('success', 'Lama sewa diperbarui.');
    }


    public function add(Request $request, $productId)
    {
        $userId = Auth::id();

        // Ambil produk
        $product = \App\Models\Product::findOrFail($productId);

        // Ambil lama sewa aktif dari keranjang user
        $firstCart = Cart::where('user_id', $userId)->first();
        $rentDays = $firstCart ? $firstCart->rent_days : 1;

        // Cek apakah produk sudah ada di cart
        $existing = Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            $existing->quantity += 1;
            $existing->subtotal = $product->price_per_day * $existing->quantity * $existing->rent_days;
            $existing->save();
        } else {

            Cart::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => 1,
                'rent_days' => $rentDays,  // ← pakai lama hari yg sedang aktif

                'subtotal' => $product->price_per_day * 1 * $rentDays, // ← dikalikan lama hari aktif
            ]);
        }

        return redirect()->route('cart_index')->with('success', 'Produk ditambahkan ke keranjang!');
    }


    public function destroy($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();

        return redirect()->back()->with('success', 'Produk dihapus dari keranjang.');
    }



}
