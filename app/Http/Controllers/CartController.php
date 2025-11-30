<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Jenis;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class CartController extends Controller
{
    // Show cart page
    public function index()
    {
        if (!auth()->check()) {
            // if not logged in, show a message prompting login
            return view('cart.cart', ['items' => collect(), 'message' => 'Silakan login untuk melihat keranjang yang tersimpan.']);
        }

        $user = auth()->user();
        $items = Cart::with('jenis')->where('user_id', $user->id)->get();

        return view('cart.cart', ['items' => $items, 'message' => null]);
    }

    // Update quantity
    public function update(Request $request, Cart $cart): RedirectResponse
    {
        $this->authorize('update', $cart);

        $qty = (int) $request->input('quantity', 1);
        $qty = max(0, $qty);
        if ($qty === 0) {
            $cart->delete();
            return redirect()->route('cart')->with('success', 'Item dihapus dari keranjang.');
        }

        $cart->quantity = $qty;
        $cart->save();

        return redirect()->route('cart')->with('success', 'Jumlah item diperbarui.');
    }

    // Delete item
    public function destroy(Cart $cart): RedirectResponse
    {
        $this->authorize('delete', $cart);
        $cart->delete();

        return redirect()->route('cart')->with('success', 'Item dihapus dari keranjang.');
    }
}
