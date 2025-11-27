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

    <header class="header">
        <a href="/" class="logo-container">
            <img src="{{ asset('images/logo.png') }}" alt="Whispering Flora Logo">
        </a>
        <nav class="nav">
            <a href="#katalog">Katalog</a>
            <a href="#about">Tentang Kami</a>
            
            @auth
                <div class="user-menu">
                    <button class="user-menu-btn" id="user-menu-toggle">
                        👤 {{ auth()->user()->name }}
                    </button>
                    <div class="user-dropdown" id="user-dropdown">
                        <a href="{{ route('profile.show') }}" class="dropdown-item">
                            👤 Profil Saya
                        </a>
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            ✏️ Edit Profil
                        </a>
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="dropdown-item" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer;">
                                🚪 Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="#" id="open-auth-modal" class="nav-button open-auth-modal">Login</a>
                <a href="{{ route('register') }}" style="margin-left: 15px; color: var(--color-accent-strong); font-weight: 600;">Register</a>
            @endauth
        </nav>
    </header>

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
                
                {{-- CARD SIMULASI PRODUK 1 --}}
                <div class="product-card">
                    <img src="{{ asset('images/babybreath.jpg') }}" alt="Baby's Breath">
                    <div class="product-info">
                        <h3>Baby's Breath Flower</h3>
                        <p style="color: var(--color-text-light); font-size: 14px;">Baby's Breath memiliki Simbol Cinta Abadi, Kemurnian, dan Kekuatan.</p>
                        <p class="price">Rp 50.000</p>
                    </div>
                </div>

                {{-- CARD SIMULASI PRODUK 2 --}}
                <div class="product-card">
                    <img src="{{ asset('images/helleborus.jpg') }}" alt="Helleborus">
                    <div class="product-info">
                        <h3>Helleborus Flower</h3>
                        <p style="color: var(--color-text-light); font-size: 14px;">Bunga Helleborus sering dianggap sebagai simbol kedamaian dan ketenangan.</p>
                        <p class="price">Rp 80.000</p>
                    </div>
                </div>
                
                {{-- CARD SIMULASI PRODUK 3 --}}
                <div class="product-card">
                    <img src="{{ asset('images/minicymbidium.jpg') }}" alt="Mini Cymbidium">
                    <div class="product-info">
                        <h3>Mini Cymbidium Flower</h3>
                        <p style="color: var(--color-text-light); font-size: 14px;">Cymbidium secara umum melambangkan cinta, kemewahan, dan keindahan yang langka.</p>
                        <p class="price">Rp 40.000</p>
                    </div>
                </div>

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
        // User menu dropdown toggle
        const userMenuBtn = document.getElementById('user-menu-toggle');
        const userDropdown = document.getElementById('user-dropdown');

        if (userMenuBtn && userDropdown) {
            userMenuBtn.addEventListener('click', (e) => {
                e.preventDefault();
                userDropdown.classList.toggle('active');
            });

            // Close dropdown jika klik di luar
            document.addEventListener('click', (e) => {
                if (!e.target.closest('.user-menu')) {
                    userDropdown.classList.remove('active');
                }
            });
        }

        // Modal login functionality (existing code)
        const openAuthModal = document.getElementById('open-auth-modal');
        if (openAuthModal) {
            openAuthModal.addEventListener('click', (e) => {
                e.preventDefault();
                const modal = document.getElementById('auth-modal');
                if (modal) modal.style.display = 'flex';
            });
        }
    </script>

    </body>
    </html>