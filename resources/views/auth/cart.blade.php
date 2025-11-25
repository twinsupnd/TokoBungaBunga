@extends('layouts.app') {{-- Pastikan Anda memiliki resources/views/layouts/app.blade.php --}}

@section('content')
<div class="container mx-auto px-4 py-8">
    
    {{-- Judul dan Breadcrumb --}}
    <h1 class="text-3xl font-light mb-8">
        Keranjang Belanja &gt; <span class="font-semibold text-gray-700">Detail Pemesanan</span> &gt; Pesanan Selesai
    </h1>
    
    {{-- Main Content Area: Dua Kolom (Produk dan Ringkasan Total) --}}
    <div class="flex flex-wrap -mx-4">
        
        {{-- KOLOM KIRI: PRODUK DI KERANJANG (8/12 lebar) --}}
        <div class="w-full lg:w-3/4 px-4">
            <h2 class="text-sm font-bold uppercase text-gray-500 mb-4">PRODUCT</h2>
            
            @foreach ($items as $item)
            <div class="flex items-center border-b border-gray-200 py-4">
                {{-- Detail Produk --}}
                <div class="flex-shrink-0 w-1/2 flex items-center">
                    <button class="text-red-500 mr-2" title="Hapus Item">×</button>
                    {{--  --}}
                    <img src="https://via.placeholder.com/100x100" alt="{{ $item['name'] }}" class="w-20 h-20 object-cover border rounded mr-4">
                    <span class="text-gray-900">{{ $item['name'] }}</span>
                </div>

                {{-- Harga --}}
                <div class="w-1/6 text-left">
                    Rp{{ number_format($item['price'], 0, ',', '.') }}
                </div>

                {{-- Kuantitas (Quantity) --}}
                <div class="w-1/6 text-center">
                    <input type="number" value="{{ $item['quantity'] }}" min="1" class="w-16 border text-center py-1">
                </div>
                
                {{-- Subtotal Item --}}
                <div class="w-1/6 text-right font-semibold">
                    Rp{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                </div>
            </div>
            @endforeach
            
            {{-- Tombol Lanjutkan Belanja --}}
            <div class="mt-6">
                <a href="#" class="inline-block px-6 py-2 border border-red-500 text-red-500 font-medium tracking-wider uppercase text-sm hover:bg-red-50">
                    &larr; CONTINUE SHOPPING
                </a>
            </div>
        </div> {{-- End Kolom Kiri --}}
        
        {{-- KOLOM KANAN: RINGKASAN TOTAL (4/12 lebar) --}}
        <div class="w-full lg:w-1/4 px-4 mt-8 lg:mt-0">
            <h2 class="text-sm font-bold uppercase text-gray-500 mb-4">CART TOTALS</h2>
            
            <div class="bg-gray-50 p-4 border rounded-lg">
                {{-- Subtotal --}}
                <div class="flex justify-between py-2 border-b border-gray-200">
                    <span>Subtotal</span>
                    <span class="font-semibold">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                
                {{-- Shipping --}}
                <div class="py-2 border-b border-gray-200">
                    <div class="flex justify-between">
                        <span>Shipping</span>
                        <span class="font-semibold text-green-600">Free shipping</span>
                    </div>
                    <div class="text-right text-xs text-gray-500 mt-1">
                        Shipping to DKI Jakarta. <a href="#" class="text-red-500 underline">Change address</a>
                    </div>
                </div>
                
                {{-- Total --}}
                <div class="flex justify-between py-2 font-bold text-lg">
                    <span>Total</span>
                    <span>Rp{{ number_format($total, 0, ',', '.') }}</span>
                </div>
                
                {{-- Tombol Checkout --}}
                <a href="#" class="block text-center mt-4 px-6 py-3 bg-yellow-500 text-white font-bold uppercase hover:bg-yellow-600 rounded">
                    PROCEED TO CHECKOUT
                </a>
                
                {{-- Coupon Code --}}
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <p class="text-sm text-gray-700 mb-2">Coupon</p>
                    <input type="text" placeholder="Coupon code" class="w-full p-2 border border-gray-300 rounded mb-2">
                    <button class="w-full p-2 bg-pink-500 text-white font-medium uppercase rounded hover:bg-pink-600">
                        Apply coupon
                    </button>
                </div>
            </div>
        </div> {{-- End Kolom Kanan --}}
        
    </div> {{-- End Flex Wrapper --}}
</div>
@endsection