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

    // Sync client-side cart (localStorage) into DB for the authenticated user
    public function sync(\Illuminate\Http\Request $request)
    {
        if (! auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $data = $request->validate([
            'items' => 'required|array'
        ]);

        $user = auth()->user();

        foreach ($data['items'] as $it) {
            $jenisId = isset($it['id']) ? (int) $it['id'] : null;
            if (! $jenisId) continue;

            $qty = max(1, (int) ($it['quantity'] ?? 1));
            $price = isset($it['price']) ? (float) $it['price'] : null;

            $existing = Cart::where('user_id', $user->id)->where('jenis_id', $jenisId)->first();

            if ($existing) {
                // increase quantity instead of creating duplicate rows
                $existing->quantity = $existing->quantity + $qty;
                if ($price) $existing->price = $price;
                $existing->save();
            } else {
                Cart::create([
                    'user_id' => $user->id,
                    'jenis_id' => $jenisId,
                    'quantity' => $qty,
                    'price' => $price,
                ]);
            }
        }

        return response()->json(['status' => 'ok']);
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
