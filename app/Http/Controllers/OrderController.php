<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of orders for admin dashboard.
     */
    public function index(Request $request)
    {
        $query = Order::query();

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function ($b) use ($q) {
                $b->where('order_number', 'like', "%{$q}%")
                  ->orWhere('name', 'like', "%{$q}%")
                  ->orWhere('phone', 'like', "%{$q}%");
            });
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

        return view('dashboard.orders.index', compact('orders'));
    }
}
