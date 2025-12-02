<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\Jenis;
use App\Models\Cart as CartModel;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

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

        // If DB cart is empty, allow client to pass items in request body (fallback)
        if ($cartItems->isEmpty()) {
            // Accept optional 'items' payload from client (same shape used in localStorage)
            $payloadItems = $request->input('items', []);
            if (! is_array($payloadItems) || count($payloadItems) === 0) {
                return response()->json(['error' => 'Keranjang kosong'], 422);
            }

            $items = [];
            $total = 0;
            foreach ($payloadItems as $p) {
                $jenisId = isset($p['id']) ? (int) $p['id'] : null;
                $qty = isset($p['quantity']) ? max(1, (int) $p['quantity']) : 1;
                if (! $jenisId) continue;

                $jenis = Jenis::find($jenisId);
                if (! $jenis) continue;

                // Defensive parsing: accept numeric or formatted string prices (eg "Rp75.000")
                if (isset($p['price']) && $p['price'] !== null) {
                    $priceRaw = $p['price'];
                    $price = (int) preg_replace('/[^0-9]/', '', (string) $priceRaw);
                } else {
                    $price = (int) preg_replace('/[^0-9]/', '', $jenis->price ?? 0);
                }

                $items[] = [
                    'id' => $jenis->id,
                    'name' => Str::limit($jenis->name ?? 'Produk', 50),
                    'price' => $price,
                    'quantity' => $qty,
                ];

                $total += $price * $qty;
            }

            if (count($items) === 0) {
                return response()->json(['error' => 'Keranjang kosong'], 422);
            }

            // Log incoming payload and computed totals for debugging
            try {
                Log::info('checkout.process: creating order', [
                    'user_id' => $user->id ?? null,
                    'items_count' => count($items),
                    'computed_total' => $total,
                    'payload_items_sample' => array_slice($payloadItems, 0, 5),
                ]);
            } catch (\Exception $e) {
                // ignore logging failure
            }

            // Create a pending order in DB so we have an order id to reference
            $orderId = 'ORDER-' . time() . '-' . Str::random(6);
            // Build order data defensively: only include columns that actually exist
            $orderData = [
                'user_id' => $user->id ?? null,
                'status' => 'pending',
            ];

            if (Schema::hasColumn('orders', 'name')) {
                $orderData['name'] = $data['name'] ?? null;
            }
            if (Schema::hasColumn('orders', 'phone')) {
                $orderData['phone'] = $data['phone'] ?? null;
            }
            if (Schema::hasColumn('orders', 'address')) {
                $orderData['address'] = $data['address'] ?? null;
            }
            if (Schema::hasColumn('orders', 'order_number')) {
                $orderData['order_number'] = $orderId;
            }
            if (Schema::hasColumn('orders', 'total')) {
                $orderData['total'] = $total;
            }

            $order = Order::create($orderData);

            // persist items
            foreach ($items as $it) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'jenis_id' => $it['id'] ?? null,
                    'name' => $it['name'] ?? 'Produk',
                    'price' => $it['price'] ?? 0,
                    'quantity' => $it['quantity'] ?? 1,
                    'subtotal' => ($it['price'] ?? 0) * ($it['quantity'] ?? 1),
                ]);
            }

            return response()->json([
                'status' => 'ok',
                'order_id' => $order->order_number,
                'total' => $total,
                'items' => $items,
            ]);
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

        // Persist an order record as pending so UI can reference it
        $orderId = 'ORDER-' . time() . '-' . Str::random(6);
        $orderData = [
            'user_id' => $user->id ?? null,
            'status' => 'pending',
        ];

        if (Schema::hasColumn('orders', 'name')) {
            $orderData['name'] = $data['name'] ?? null;
        }
        if (Schema::hasColumn('orders', 'phone')) {
            $orderData['phone'] = $data['phone'] ?? null;
        }
        if (Schema::hasColumn('orders', 'address')) {
            $orderData['address'] = $data['address'] ?? null;
        }
        if (Schema::hasColumn('orders', 'order_number')) {
            $orderData['order_number'] = $orderId;
        }
        if (Schema::hasColumn('orders', 'total')) {
            $orderData['total'] = $total;
        }

        $order = Order::create($orderData);

        foreach ($items as $it) {
            OrderItem::create([
                'order_id' => $order->id,
                'jenis_id' => $it['id'] ?? null,
                'name' => $it['name'] ?? 'Produk',
                'price' => $it['price'] ?? 0,
                'quantity' => $it['quantity'] ?? 1,
                'subtotal' => ($it['price'] ?? 0) * ($it['quantity'] ?? 1),
            ]);
        }

        return response()->json([
            'status' => 'ok',
            'order_id' => $order->order_number,
            'total' => $total,
            'items' => $items,
        ]);
    }

    // Mark a pending order as paid (called when user clicks Complete in popup)
    public function complete(Request $request)
    {
        if (! auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            Log::info('checkout.complete called', ['payload' => $request->all(), 'user_id' => auth()->id()]);
        } catch (\Exception $e) {
            // ignore logging errors
        }

        $data = $request->validate([
            'order_number' => 'required|string',
        ]);

        $user = auth()->user();
        $order = Order::where('order_number', $data['order_number'])->first();
        try {
            Log::info('checkout.complete: order lookup', ['order_number' => $data['order_number'], 'found' => $order ? true : false, 'order_id' => $order->id ?? null]);
        } catch (\Exception $e) {}
        if (! $order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        // ensure order belongs to user (or allow admin override)
        if ($order->user_id && $order->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized order'], 403);
        }

        $order->status = 'paid';
        $order->paid_at = Carbon::now();
        $order->save();

        // Clear user's cart
        \App\Models\Cart::where('user_id', $user->id)->delete();

        try {
            Log::info('checkout.complete: order marked paid and cart cleared', ['order_number' => $order->order_number, 'user_id' => $user->id]);
        } catch (\Exception $e) {}

        return response()->json(['status' => 'ok']);
    }

    // Show checkout page with current server cart items (for authenticated users)
    public function show()
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        $items = CartModel::with('jenis')->where('user_id', $user->id)->get()->map(function($it) {
            return [
                'id' => $it->jenis->id ?? $it->id,
                'name' => $it->jenis->name ?? 'Produk',
                'price' => (int) ($it->price ?? preg_replace('/[^0-9]/', '', $it->jenis->price ?? 0)),
                'quantity' => (int) $it->quantity,
                'imageUrl' => $it->jenis->image ? asset('storage/' . $it->jenis->image) . '?v=' . strtotime($it->jenis->updated_at) : asset('images/babybreath.jpg'),
            ];
        });

        return view('auth.detail', ['items' => $items]);
    }
}
