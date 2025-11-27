<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Whispering Flora - Aesthetic Landing</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
<body>

    @include('components.header')

    <main>
        <section class="hero" style="background-image: url('{{ asset('images/bg.jpg') }}');">
            <div class="hero-content">
                <h1>Temukan Makna Tersembunyi di Setiap Helai Bunga.</h1>
                <p>Koleksi Bunga Pilihan Terbaik, Dirangkai dengan Sentuhan Hati dari Whispering Flora.</p>
                <a href="#katalog" class="cta-button">Lihat Koleksi Kami</a>
            </div>
        </section>
        
        <section class="section" id="katalog">
            <h2 class="section-title">Bunga Pilihan Mingguan</h2>
            <div class="product-grid">
                @if(isset($products) && $products->count())
                    @foreach($products as $product)
                        <a href="{{ route('jenis.show', $product->slug) }}" style="display: block; color: inherit; text-decoration: none;">
                            <div class="product-card" style="position: relative; border-radius: 10px; overflow: hidden; transition: all 0.25s ease; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                                <div style="position: relative; width: 100%; aspect-ratio: 1; overflow: hidden;">
                                    <img src="{{ asset('images/' . ($product->image ?? 'babybreath.jpg')) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.25s ease;">
                                    <div style="position: absolute; top: 12px; left: 12px; background: rgba(255, 255, 255, 0.95); padding: 6px 12px; border-radius: 999px; font-size: 12px; font-weight: 600; color: var(--color-accent-strong, #d4847c); backdrop-filter: blur(4px);">
                                        🌸 Favorit
                                    </div>
                                </div>
                                <div class="product-info" style="padding: 16px;">
                                    <h3 style="margin: 0 0 6px; font-size: 16px; font-weight: 600; color: var(--color-text-dark);">{{ $product->name }}</h3>
                                    <p style="color: var(--color-text-light); font-size: 13px; margin: 0 0 10px; line-height: 1.4;">{{ \Illuminate\Support\Str::limit($product->description, 80) }}</p>
                                    <p class="price" style="margin: 0; font-weight: 700; color: var(--color-accent-strong, #d4847c); font-size: 16px;">{{ $product->price }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @else
                    <div style="color: var(--color-text-light); text-align: center; padding: 40px; grid-column: 1 / -1;">
                        <p>Belum ada produk — silahkan jalankan <code>php artisan migrate:fresh --seed</code></p>
                    </div>
                @endif
            </div>
            
            <a href="{{ route('login') }}" class="cta-button" style="margin-top: 50px; display: inline-block;">Lihat Semua Produk &raquo;</a>
        </section>
        
        <section class="section" id="about" style="background-color: var(--color-pastel-bliss-4); padding: 60px 50px;">
            <h2 class="section-title" style="margin-bottom: 20px;">Tentang Whispering Flora</h2>
            <p style="max-width: 700px; margin: 0 auto 30px; font-size: 16px; color: var(--color-text-dark);">
                Kami percaya bahwa setiap bunga memiliki cerita dan pesan tersembunyi. Whispering Flora berdedikasi untuk memilih hanya bunga-bunga dengan kualitas terbaik, merangkainya dengan sentuhan hati agar pesan Anda tersampaikan dengan sempurna. Kami menyediakan sistem penjualan sederhana dengan fokus pada kemudahan pengelolaan data dan pengalaman pengguna yang lancar.
            </p>
            <p style="font-style: italic; font-weight: 500; color: var(--color-accent-strong);">
                "Biar bunga yang bicara, saat kata tak lagi cukup."
            </p>
        </section>
        
    </main>

    <footer class="footer">
        &copy; {{ date('Y') }} Whispering Flora. Hak Cipta Dilindungi.
        <div>
            <a href="#">Kebijakan Privasi</a> | 
            <a href="#">Syarat & Ketentuan</a> |
            <a href="#">Kontak Kami</a>
        </div>
    </footer>

        @include('auth._login-modal')

    <script>
        // Update cart count badge from localStorage
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
                console.log('Error loading cart from localStorage:', e);
            }
        }

        // Modal login functionality
        const openAuthModal = document.getElementById('open-auth-modal');
        if (openAuthModal) {
            openAuthModal.addEventListener('click', (e) => {
                e.preventDefault();
                const modal = document.getElementById('auth-modal');
                if (modal) modal.style.display = 'flex';
            });
        }
    </script>

    @include('auth._login-modal')

    </body>
    </html>