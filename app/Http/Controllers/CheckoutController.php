<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Process checkout and request Midtrans Snap token.
     * Requires MIDTRANS_SERVER_KEY and MIDTRANS_CLIENT_KEY in .env
     */
    public function process(Request $request)
    {
        if (! auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:32',
            'address' => 'required|string|max:1000',
            'payment_method' => 'required|string|max:100',
        ]);

        // Pull cart items from DB for the authenticated user
        $user = auth()->user();
        $cartItems = \App\Models\Cart::with('jenis')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['error' => 'Keranjang kosong'], 422);
        }

        // Build item details and total
        $items = [];
        $total = 0;
        foreach ($cartItems as $it) {
            $price = (int) ($it->price ?? preg_replace('/[^0-9]/', '', $it->jenis->price ?? 0));
            $qty = (int) $it->quantity;
            $items[] = [
                'id' => $it->jenis->id ?? $it->id,
                'name' => Str::limit($it->jenis->name ?? 'Produk', 50),
                'price' => $price,
                'quantity' => $qty,
            ];
            $total += $price * $qty;
        }

        // For now we do not call any external payment gateway.
        // Create a simple order identifier and return it to the frontend so
        // the frontend can show a simulated payment popup/modal.
        $orderId = 'ORDER-' . time() . '-' . Str::random(6);

        return response()->json([
            'status' => 'ok',
            'order_id' => $orderId,
            'total' => $total,
            'items' => $items,
        ]);
    }
}
