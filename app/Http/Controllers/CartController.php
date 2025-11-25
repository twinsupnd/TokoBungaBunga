<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        // --- Data Keranjang Belanja (Sama seperti yang ditampilkan di screenshot) ---
        $items = [
            [
                'name' => 'Baby Blooms',
                'price' => 550000,
                'quantity' => 1,
                // Asumsi ada kolom 'image_url' atau 'product_image'
                'image_url' => 'placeholder_url_baby_blooms', 
            ],
        ];
        
        // Menghitung Subtotal
        $subtotal = array_sum(array_map(function($item) {
            return $item['price'] * $item['quantity'];
        }, $items));
        
        // Detail Pengiriman & Total
        $shipping = 0; // Karena ada promo Free Shipping
        $total = $subtotal + $shipping;

        return view('cart', compact('items', 'subtotal', 'shipping', 'total'));
    }
}