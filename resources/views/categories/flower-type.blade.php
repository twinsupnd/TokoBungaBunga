<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $flowerName }} - Whispering Flora</title>
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .category-header {
            background: linear-gradient(135deg, #f5d5e3 0%, #ffeaa7 100%);
            padding: 60px 50px;
            text-align: center;
            margin-bottom: 40px;
        }

        .category-header h1 {
            font-size: 3rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0 0 10px;
            font-family: 'Playfair Display', serif;
        }

        .category-header p {
            font-size: 1rem;
            color: #6b7280;
            margin: 0;
        }

        .breadcrumb {
            display: flex;
            gap: 8px;
            align-items: center;
            margin-bottom: 30px;
            padding: 0 50px;
        }

        .breadcrumb a {
            color: #ec4899;
            text-decoration: none;
            font-weight: 500;
        }

        .breadcrumb span {
            color: #d1d5db;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 24px;
            padding: 0 50px 60px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .product-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        .product-image {
            width: 100%;
            aspect-ratio: 1;
            object-fit: cover;
            background: #f9fafb;
        }

        .product-info {
            padding: 16px;
        }

        .product-name {
            font-size: 16px;
            font-weight: 600;
            color: #1f2937;
            margin: 0 0 8px;
        }

        .product-description {
            font-size: 13px;
            color: #6b7280;
            margin: 0 0 12px;
            line-height: 1.4;
        }

        .product-price {
            font-size: 16px;
            font-weight: 700;
            color: #ec4899;
            margin: 0;
        }

        .empty-state {
            text-align: center;
            padding: 80px 50px;
            grid-column: 1 / -1;
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 20px;
        }

        .empty-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0 0 10px;
        }

        .empty-text {
            font-size: 1rem;
            color: #6b7280;
            margin: 0;
        }

        @media (max-width: 768px) {
            .category-header {
                padding: 40px 20px;
            }

            .category-header h1 {
                font-size: 2rem;
            }

            .breadcrumb {
                padding: 0 20px;
            }

            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 16px;
                padding: 0 20px 40px;
            }
        }
    </style>
</head>

<body>
    @include('components.header')

    <main>
        <div class="category-header">
            <h1>🌸 {{ $flowerName }}</h1>
            <p>Koleksi Pilihan {{ $flowerName }} Terbaik dari Whispering Flora</p>
        </div>

        <div class="breadcrumb">
            <a href="{{ route('catalog.index') }}">Katalog</a>
            <span>›</span>
            <span>{{ $flowerName }}</span>
        </div>

        @if ($products->count() > 0)
            <div class="product-grid">
                @foreach ($products as $product)
                    <div class="welcome-slide" data-slug="{{ $product->slug }}" style="padding:0;">
                        <a href="{{ route('jenis.show', $product->slug) }}" style="display:block; color:inherit; text-decoration:none;">
                            <div class="product-card" style="position: relative; border-radius: 10px; overflow: hidden; transition: all 0.25s ease; box-shadow: 0 4px 12px rgba(0,0,0,0.08); background: white;">
                                <div style="position: relative; width: 100%; aspect-ratio: 1; overflow: hidden;">
                                    @if ($product->image && file_exists(public_path('images/' . basename($product->image))))
                                        <img src="{{ asset('images/' . basename($product->image)) }}" alt="{{ $product->name }}" style="width:100%; height:100%; object-fit:cover; transition: transform 0.25s ease;">
                                    @else
                                        <img src="{{ asset('images/babybreath.jpg') }}" alt="{{ $product->name }}" style="width:100%; height:100%; object-fit:cover; opacity:0.7;">
                                    @endif
                                    <div style="position: absolute; top: 12px; left: 12px; background: rgba(255,255,255,0.95); padding: 6px 12px; border-radius: 999px; font-size: 12px; font-weight: 600; color: var(--pastel-accent); backdrop-filter: blur(4px);">
                                        🌸 Favorit
                                    </div>
                                </div>
                                <div class="product-info" style="padding: 16px; background: #fff;">
                                    <h3 style="margin: 0 0 6px; font-size: 16px; font-weight: 600; color: var(--text);">{{ $product->name }}</h3>
                                    <p style="color: var(--muted); font-size: 13px; margin: 0 0 10px; line-height: 1.4;">{{ \Illuminate\Support\Str::limit($product->description, 80) }}</p>
                                    <p class="price" style="margin: 0; font-weight: 700; color: var(--pastel-accent); font-size: 16px;">{{ $product->price }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="product-grid">
                <div class="empty-state">
                    <div class="empty-icon">🌼</div>
                    <h2 class="empty-title">Belum Ada Produk</h2>
                    <p class="empty-text">Produk {{ $flowerName }} sedang tidak tersedia saat ini</p>
                </div>
            </div>
        @endif
    </main>

    <footer class="footer" style="margin-top: 60px;">
        &copy; {{ date('Y') }} Whispering Flora. Hak Cipta Dilindungi.
        <div>
            <a href="#">Kebijakan Privasi</a> |
            <a href="#">Syarat & Ketentuan</a> |
            <a href="#">Kontak Kami</a>
        </div>
    </footer>

    @include('auth._login-modal')
</body>

</html>
