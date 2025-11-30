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

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { height: 100%; }
        body { font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto; background: var(--pastel-bg); color: var(--text); }

        .navbar {
            background: linear-gradient(180deg, var(--pastel-card), #FFF);
            border-bottom: 1px solid rgba(34,34,59,0.04);
            padding: 16px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(180,170,200,0.05);
        }

        .navbar-brand { font-weight: 700; font-size: 18px; text-decoration: none; color: var(--text); display: flex; align-items: center; gap: 10px; }
        .navbar-brand img { width: 32px; height: 32px; object-fit: contain; border-radius: 6px; }

        .navbar-links { display: flex; gap: 24px; align-items: center; }
        .navbar-link { text-decoration: none; color: var(--text); font-weight: 500; transition: color 0.2s ease; }
        .navbar-link:hover { color: var(--pastel-accent); }
        .btn-login { background: linear-gradient(135deg, var(--pastel-accent), var(--pastel-accent-2)); color: white; padding: 8px 18px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(199,183,255,0.3); }

        .catalog-container { max-width: 1200px; margin: 0 auto; padding: 40px 28px; }
        .page-header { text-align: center; margin-bottom: 40px; }
        .page-title { font-size: 32px; font-weight: 700; margin-bottom: 8px; }
        .page-subtitle { font-size: 16px; color: var(--muted); }

        .catalog-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 28px; }
        .product-card { background: var(--pastel-card); border-radius: 14px; overflow: hidden; box-shadow: 0 8px 20px rgba(34,34,59,0.04); border: 1px solid rgba(199,183,255,0.1); transition: all 0.3s ease; }
        .product-card:hover { transform: translateY(-6px); box-shadow: 0 12px 28px rgba(199,183,255,0.15); }

        .product-image { width: 100%; height: 240px; background: linear-gradient(135deg, #f0f0f0 0%, #e8e8e8 100%); overflow: hidden; }
        .product-image img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease; }
        .product-card:hover .product-image img { transform: scale(1.05); }

        .product-info { padding: 24px; }
        .product-name { font-size: 17px; font-weight: 700; color: var(--text); margin-bottom: 8px; }
        .product-description { font-size: 13px; color: var(--muted); margin-bottom: 12px; line-height: 1.5; }
        .product-price { font-size: 18px; font-weight: 700; color: var(--pastel-accent); margin-bottom: 16px; }

        .product-actions { display: flex; gap: 12px; }
        .btn { padding: 10px 16px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s ease; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; font-size: 13px; }
        .btn-view { background: linear-gradient(135deg, var(--pastel-accent), var(--pastel-accent-2)); color: white; flex: 1; }
        .btn-view:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(199,183,255,0.3); }
        .btn-login-product { background: rgba(199,183,255,0.1); color: var(--pastel-accent); border: 1px solid var(--pastel-accent); flex: 1; }
        .btn-login-product:hover { background: rgba(199,183,255,0.15); }

        .empty-state { text-align: center; padding: 80px 28px; color: var(--muted); }
        .empty-icon { font-size: 64px; margin-bottom: 16px; }
        .empty-text { font-size: 18px; }

        footer { background: linear-gradient(180deg, var(--pastel-card), #FFF); border-top: 1px solid rgba(34,34,59,0.04); padding: 28px; text-align: center; color: var(--muted); font-size: 13px; margin-top: 60px; }

        @media (max-width: 768px) {
            .navbar { flex-direction: column; gap: 16px; }
            .navbar-links { flex-direction: column; gap: 12px; width: 100%; }
            .catalog-grid { grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; }
            .catalog-container { padding: 28px 16px; }
            .page-title { font-size: 24px; }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="/" class="navbar-brand">
            <img src="{{ asset('images/logo.png') }}" alt="Toko Bunga">
            Toko Bunga
        </a>
        <div class="navbar-links">
            <a href="/" class="navbar-link">Beranda</a>
            <a href="{{ route('public.catalog') }}" class="navbar-link" style="color: var(--pastel-accent); font-weight: 700;">Katalog</a>
            @if(auth()->check())
                <a href="{{ route('dashboard') }}" class="navbar-link">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="navbar-link" style="background: none; border: none; cursor: pointer; padding: 0;">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-login">Login / Daftar</a>
            @endif
        </div>
    </nav>

    <div class="catalog-container">
        <div class="page-header">
            <h1 class="page-title">🌸 Katalog Produk</h1>
            <p class="page-subtitle">Koleksi bunga pilihan kami yang indah dan segar</p>
        </div>

        @if($products->count() > 0)
            <div class="catalog-grid">
                @foreach($products as $product)
                    <div class="product-card">
                        <div class="product-image">
                            @if($product->image)
                                <img src="{{ Storage::disk('public')->url($product->image) }}" alt="{{ $product->name }}">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #ccc; font-size: 14px;">No Image</div>
                            @endif
                        </div>
                        <div class="product-info">
                            <h3 class="product-name">{{ $product->name }}</h3>
                            <p class="product-description">{{ \Illuminate\Support\Str::limit($product->description, 100) }}</p>
                            <div class="product-price">Rp {{ number_format((float) $product->price, 0, ',', '.') }}</div>
                            <div style="margin-bottom:10px;">
                                @if($product->stock > 0)
                                    <span style="background:#e0ffe0; color:#2ecc40; font-weight:600; padding:3px 12px; border-radius:8px; font-size:13px;">Stok: {{ $product->stock }} unit</span>
                                @else
                                    <span style="background:#ffe0e0; color:#ff3b3b; font-weight:600; padding:3px 12px; border-radius:8px; font-size:13px;">Stok Habis</span>
                                @endif
                            </div>
                            <div class="product-actions">
                                <a href="{{ route('jenis.show', $product->slug) }}" class="btn btn-view">👁 Lihat Detail</a>
                                @if(auth()->check())
                                    <button class="btn btn-login-product" onclick="addToCart('{{ $product->id }}', '{{ $product->name }}', {{ $product->price }})">🛒 Keranjang</button>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-login-product">🛒 Keranjang</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">📦</div>
                <p class="empty-text">Belum ada produk tersedia. Cek kembali nanti!</p>
            </div>
        @endif
    </div>

    <footer>
        &copy; {{ date('Y') }} Toko Bunga. Semua hak dilindungi.
    </footer>

    <script>
        function addToCart(productId, productName, price) {
            try {
                let cart = JSON.parse(localStorage.getItem('whispering_flora_cart')) || { items: [] };
                let item = cart.items.find(i => i.id == productId);
                if (item) {
                    item.quantity += 1;
                } else {
                    cart.items.push({ id: productId, name: productName, price: price, quantity: 1, image: '' });
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
</body>
</html>
