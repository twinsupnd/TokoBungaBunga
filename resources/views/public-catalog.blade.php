<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Katalog Produk - Toko Bunga</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --pastel-bg: #F8F6FF;
            --pastel-card: #FFF8FB;
            --pastel-accent: #C7B7FF;
            --pastel-accent-2: #FFD6E0;
            --muted: #7B7B8B;
            --text: #22223B;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
        }

      

        .navbar {
            background: linear-gradient(180deg, var(--pastel-card), #FFF);
            border-bottom: 1px solid rgba(34, 34, 59, 0.04);
            padding: 16px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(180, 170, 200, 0.05);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 18px;
            text-decoration: none;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-brand img {
            width: 32px;
            height: 32px;
            object-fit: contain;
            border-radius: 6px;
        }

        .navbar-links {
            display: flex;
            gap: 24px;
            align-items: center;
        }

        .navbar-link {
            text-decoration: none;
            color: var(--text);
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .navbar-link:hover {
            color: var(--pastel-accent);
        }

        .btn-login {
            background: linear-gradient(135deg, var(--pastel-accent), var(--pastel-accent-2));
            color: white;
            padding: 8px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(199, 183, 255, 0.3);
        }

        .catalog-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 28px;
        }

        .page-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .page-title {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .page-subtitle {
            font-size: 16px;
            color: var(--muted);
        }

        .catalog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 28px;
        }

        .product-card {
            background: var(--pastel-card);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(34, 34, 59, 0.04);
            border: 1px solid rgba(199, 183, 255, 0.1);
            transition: all 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 28px rgba(199, 183, 255, 0.15);
        }

        .product-image {
            width: 100%;
            height: 240px;
            background: linear-gradient(135deg, #f0f0f0 0%, #e8e8e8 100%);
            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-image img {
            transform: scale(1.05);
        }

        .product-info {
            padding: 24px;
        }

        .product-name {
            font-size: 17px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 8px;
        }

        .product-description {
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 12px;
            line-height: 1.5;
        }

        .product-price {
            font-size: 18px;
            font-weight: 700;
            color: var(--pastel-accent);
            margin-bottom: 16px;
        }

        .product-actions {
            display: flex;
            gap: 12px;
        }

        .btn {
            padding: 10px 16px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
        }

        .btn-view {
            background: linear-gradient(135deg, var(--pastel-accent), var(--pastel-accent-2));
            color: white;
            flex: 1;
        }

        .btn-view:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(199, 183, 255, 0.3);
        }

        .btn-login-product {
            background: rgba(199, 183, 255, 0.1);
            color: var(--pastel-accent);
            border: 1px solid var(--pastel-accent);
            flex: 1;
        }

        .btn-login-product:hover {
            background: rgba(199, 183, 255, 0.15);
        }

        .empty-state {
            text-align: center;
            padding: 80px 28px;
            color: var(--muted);
        }

        .empty-icon {
            font-size: 64px;
            margin-bottom: 16px;
        }

        .empty-text {
            font-size: 18px;
        }

        footer {
            background: linear-gradient(180deg, var(--pastel-card), #FFF);
            border-top: 1px solid rgba(34, 34, 59, 0.04);
            padding: 28px;
            text-align: center;
            color: var(--muted);
            font-size: 13px;
            margin-top: 60px;
        }

        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                gap: 16px;
            }

            .navbar-links {
                flex-direction: column;
                gap: 12px;
                width: 100%;
            }

            .catalog-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 16px;
            }

            .catalog-container {
                padding: 28px 16px;
            }

            .page-title {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>
    @include('components.header')

    <div class="catalog-container">
        <div class="page-header">
            <h1 class="page-title">🌸 Katalog Produk</h1>
            <p class="page-subtitle">Koleksi bunga pilihan kami yang indah dan segar</p>
        </div>

        <form method="GET" action="{{ route('catalog.index') }}" style="max-width:900px; margin:12px auto 20px; display:flex; gap:8px; padding:0 12px;">
            <input name="q" type="search" placeholder="Cari produk, nama atau deskripsi..." value="{{ request('q', isset($q) ? $q : '') }}"
                style="flex:1; padding:10px 14px; border-radius:10px; border:1px solid rgba(51, 51, 168, 0.06); font-size:14px;">
            <button type="submit" style="padding:10px 14px; border-radius:10px; background:linear-gradient(135deg,#c7b7ff,#ffd6e0); border:none; font-weight:700;">Cari</button>
            @if(request('q') || (isset($q) && $q))
                <a href="{{ route('catalog.index') }}" style="display:inline-flex; align-items:center; padding:10px 12px; border-radius:10px; background:#fff; border:1px solid rgba(34,34,59,0.04); text-decoration:none; color:inherit;">Reset</a>
            @endif
        </form>

        {{-- Types section removed to avoid duplicating the same Jenis entries that are shown below as products. --}}

        @if ($products->count() > 0)
            <div class="catalog-grid">
                @foreach ($products as $product)
                    <a href="{{ route('jenis.show', $product->slug) }}" style="display:block; color:inherit; text-decoration:none;">
                        <div class="product-card" style="position: relative; border-radius: 10px; overflow: hidden; transition: all 0.25s ease; box-shadow: 0 4px 12px rgba(0,0,0,0.08); background: white;">
                            <div style="position: relative; width: 100%; aspect-ratio: 1; overflow: hidden;">
                                @if ($product->image)
                                    <img src="{{ asset($product->image) . '?v=' . strtotime($product->updated_at) }}" alt="{{ $product->name }}" style="width:100%; height:100%; object-fit:cover; transition: transform 0.25s ease;">
                                @else
                                    <img src="{{ asset('images/babybreath.jpg') }}" alt="{{ $product->name }}" style="width:100%; height:100%; object-fit:cover; opacity:0.6;">
                                @endif
                                <div style="position: absolute; top: 12px; left: 12px; background: rgba(255, 255, 255, 0.95); padding: 6px 12px; border-radius: 999px; font-size: 12px; font-weight: 600; color: var(--pastel-accent); backdrop-filter: blur(4px);">
                                    🌸 Favorit
                                </div>
                            </div>
                            <div class="product-info" style="padding: 16px; background: #fff;">
                                <h3 style="margin: 0 0 6px; font-size: 16px; font-weight: 600; color: var(--text);">{{ $product->name }}</h3>
                                <p style="color: var(--muted); font-size: 13px; margin: 0 0 10px; line-height: 1.4;">{{ \Illuminate\Support\Str::limit($product->description, 100) }}</p>
                                <p class="price" style="margin: 0; font-weight: 700; color: var(--pastel-accent); font-size: 16px;">Rp {{ number_format((float) $product->price, 0, ',', '.') }}</p>
                                <div style="margin-top:10px;">
                                    @if ($product->stock > 0)
                                        <span style="background:#e0ffe0; color:#2ecc40; font-weight:600; padding:3px 12px; border-radius:8px; font-size:13px;">Stok: {{ $product->stock }} unit</span>
                                    @else
                                        <span style="background:#ffe0e0; color:#ff3b3b; font-weight:600; padding:3px 12px; border-radius:8px; font-size:13px;">Stok Habis</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">📦</div>
                <p class="empty-text">Belum ada produk tersedia. Cek kembali nanti!</p>
            </div>
        @endif

        {{-- Pagination (compact window) --}}
        @if ($products->hasPages())
            @php
                $current = $products->currentPage();
                $last = $products->lastPage();
                $start = max(1, $current - 2);
                $end = min($last, $current + 2);
            @endphp

            <div style="display: flex; justify-content: center; margin-top: 40px; padding: 20px 0;">
                <div style="display: flex; gap: 8px; align-items: center;">
                    {{-- Prev --}}
                    @if ($products->onFirstPage())
                        <span style="padding: 10px 14px; border-radius:8px; color:#9ca3af; background:#fff; border:1px solid rgba(34,34,59,0.04);">←</span>
                    @else
                        <a href="{{ $products->previousPageUrl() }}" style="padding: 10px 14px; border-radius:8px; background:#fff; border:1px solid rgba(34,34,59,0.06); text-decoration:none; color:inherit;">←</a>
                    @endif

                    {{-- First page + ellipsis if needed --}}
                    @if ($start > 1)
                        <a href="{{ $products->url(1) }}" style="padding: 10px 14px; border-radius:8px; background:#fff; border:1px solid rgba(34,34,59,0.06); text-decoration:none; color:inherit;">1</a>
                        @if ($start > 2)
                            <span style="padding: 10px 6px; color:#9ca3af;">…</span>
                        @endif
                    @endif

                    {{-- Page window --}}
                    @for ($p = $start; $p <= $end; $p++)
                        @if ($p == $current)
                            <span style="padding: 10px 14px; border-radius:8px; background: linear-gradient(135deg,#c7b7ff,#ffd6e0); color:#fff; font-weight:700;">{{ $p }}</span>
                        @else
                            <a href="{{ $products->url($p) }}" style="padding: 10px 14px; border-radius:8px; background:#fff; border:1px solid rgba(34,34,59,0.06); text-decoration:none; color:inherit;">{{ $p }}</a>
                        @endif
                    @endfor

                    {{-- Last page + ellipsis if needed --}}
                    @if ($end < $last)
                        @if ($end < $last - 1)
                            <span style="padding: 10px 6px; color:#9ca3af;">…</span>
                        @endif
                        <a href="{{ $products->url($last) }}" style="padding: 10px 14px; border-radius:8px; background:#fff; border:1px solid rgba(34,34,59,0.06); text-decoration:none; color:inherit;">{{ $last }}</a>
                    @endif

                    {{-- Next --}}
                    @if ($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}" style="padding: 10px 14px; border-radius:8px; background:#fff; border:1px solid rgba(34,34,59,0.06); text-decoration:none; color:inherit;">→</a>
                    @else
                        <span style="padding: 10px 14px; border-radius:8px; color:#9ca3af; background:#fff; border:1px solid rgba(34,34,59,0.04);">→</span>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <footer>
        &copy; {{ date('Y') }} Toko Bunga. Semua hak dilindungi.
    </footer>

    <script>
        function addToCart(productId, productName, price) {
            try {
                let cart = JSON.parse(localStorage.getItem('whispering_flora_cart')) || {
                    items: []
                };
                let item = cart.items.find(i => i.id == productId);
                if (item) {
                    item.quantity += 1;
                } else {
                    cart.items.push({
                        id: productId,
                        name: productName,
                        price: price,
                        quantity: 1,
                        image: ''
                    });
                }
                localStorage.setItem('whispering_flora_cart', JSON.stringify(cart));
                alert(productName + ' ditambahkan ke keranjang!');
                updateCartBadge();
            } catch (e) {
                console.error('Error adding to cart:', e);
            }
        }

        function updateCartBadge() {
            try {
                const savedCart = localStorage.getItem('whispering_flora_cart');
                if (savedCart) {
                    const cartData = JSON.parse(savedCart);
                    const totalItems = cartData.items.reduce((sum, item) => sum + item.quantity, 0);
                    const badge = document.getElementById('cart-count-badge');
                    if (badge) {
                        badge.textContent = totalItems;
                        badge.style.display = totalItems > 0 ? 'flex' : 'none';
                    }
                }
            } catch (e) {
                console.log('Error loading cart:', e);
            }
        }

        updateCartBadge();
    </script>
    <script>
        // Poll server for catalog updates. If any product is updated, reload page.
        (function() {
            var lastKnown = {{ $products->count() ? (int) strtotime($products->max('updated_at')) : 0 }};
            var endpoint = "{{ route('catalog.lastUpdated') }}";

            function checkUpdates() {
                fetch(endpoint, {
                        cache: 'no-store'
                    })
                    .then(function(r) {
                        return r.json();
                    })
                    .then(function(data) {
                        if (!data || !data.last) return;
                        var serverTs = parseInt(data.last, 10) || 0;
                        if (serverTs > lastKnown) {
                            // Newer data available — reload to show updated images/content
                            location.reload(true);
                        }
                    }).catch(function(e) {
                        console.warn('Catalog update check failed', e);
                    });
            }

            // Check every 10 seconds
            setInterval(checkUpdates, 10000);
        })();
    </script>
</body>

</html>
