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
            <style>
                /* Welcome products carousel */
                .welcome-carousel { max-width:1200px; margin: 24px auto; position: relative; }
                .welcome-track { display:flex; transition: transform 0.4s ease; gap:24px; padding: 12px 6px; }
                .welcome-slide { min-width: 100%; box-sizing: border-box; }
                .welcome-slide .product-card { height: 420px; display:flex; flex-direction:column; }
                .welcome-slide .product-card .product-info { flex:0 0 auto; }
                .welcome-btn { position:absolute; top:50%; transform: translateY(-50%); width:44px; height:44px; border-radius:999px; background: rgba(255,255,255,0.95); display:flex; align-items:center; justify-content:center; box-shadow:0 6px 18px rgba(0,0,0,0.08); cursor:pointer; }
                .welcome-btn.prev { left: 8px; }
                .welcome-btn.next { right: 8px; }
                .welcome-dots { text-align:center; margin-top:14px; }
                .welcome-dots .dot { display:inline-block; width:10px; height:10px; border-radius:999px; background:#e5e7eb; margin: 0 6px; cursor:pointer; }
                .welcome-dots .dot.active { background: #ec4899; }

                @media (min-width: 900px) {
                    .welcome-slide { min-width: calc(33.333% - 16px); }
                    .welcome-slide .product-card { height: 380px; }
                }
            </style>

            <div class="welcome-carousel" id="welcome-carousel">
                @if(isset($products) && $products->count())
                    <div class="welcome-track">
                        @foreach($products as $product)
                            <div class="welcome-slide" data-slug="{{ $product->slug }}">
                                <a href="{{ route('jenis.show', $product->slug) }}" style="display:block; color:inherit; text-decoration:none;">
                                    <div class="product-card" style="position: relative; border-radius: 10px; overflow: hidden; transition: all 0.25s ease; box-shadow: 0 4px 12px rgba(0,0,0,0.08); background: white;">
                                        <div style="position: relative; width: 100%; aspect-ratio: 1; overflow: hidden;">
                                            <img src="{{ asset('images/' . ($product->image ?? 'babybreath.jpg')) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.25s ease;">
                                            <div style="position: absolute; top: 12px; left: 12px; background: rgba(255, 255, 255, 0.95); padding: 6px 12px; border-radius: 999px; font-size: 12px; font-weight: 600; color: var(--color-accent-strong, #d4847c); backdrop-filter: blur(4px);">
                                                🌸 Favorit
                                            </div>
                                        </div>
                                        <div class="product-info" style="padding: 16px; background: #fff;">
                                            <h3 style="margin: 0 0 6px; font-size: 16px; font-weight: 600; color: var(--color-text-dark);">{{ $product->name }}</h3>
                                            <p style="color: var(--color-text-light); font-size: 13px; margin: 0 0 10px; line-height: 1.4;">{{ \Illuminate\Support\Str::limit($product->description, 80) }}</p>
                                            <p class="price" style="margin: 0; font-weight: 700; color: var(--color-accent-strong, #d4847c); font-size: 16px;">{{ $product->price }}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <button class="welcome-btn prev" id="welcome-prev" aria-label="Previous">◀</button>
                    <button class="welcome-btn next" id="welcome-next" aria-label="Next">▶</button>

                    <div class="welcome-dots" id="welcome-dots" aria-hidden="false"></div>
                @else
                    <div style="color: var(--color-text-light); text-align: center; padding: 40px;">
                        <p>Belum ada produk — silahkan jalankan <code>php artisan migrate:fresh --seed</code></p>
                    </div>
                @endif
            </div>
            
            <a href="{{ route('login') }}" class="cta-button" style="margin-top: 50px; display: inline-block;">Lihat Semua Produk &raquo;</a>
        </section>
        
        <!-- Reviews / Testimonials -->
        <section class="section" id="reviews" style="padding: 48px 50px;">
            <h2 class="section-title">Ulasan Pelanggan</h2>
            <p style="max-width:820px; margin: 8px auto 28px; color:var(--color-text-light); text-align:center;">Apa kata pelanggan kami — jujur, hangat, dan membantu orang memilih rangkaian yang tepat untuk momen mereka.</p>

            <div style="max-width:1200px; margin: 0 auto; display:grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
                <div style="background: white; border-radius: 12px; padding: 18px; box-shadow: 0 8px 28px rgba(0,0,0,0.06); display:flex; gap:14px; align-items:flex-start;">
                    <img src="{{ asset('images/review-1.jpg') }}" alt="avatar" style="width:64px; height:64px; border-radius:999px; object-fit:cover;">
                    <div style="flex:1;">
                        <div style="display:flex; justify-content:space-between; align-items:center; gap:12px;">
                            <div style="font-weight:700; color:var(--color-text-dark);">Nadia Putri</div>
                            <div style="color:#f9739c; font-weight:700;">★★★★★</div>
                        </div>
                        <p style="margin:8px 0 0; color:var(--color-text-light); line-height:1.5;">“Cepat, rapi, dan komunikasinya ramah. Bunganya segar & packagingnya cantik — sesuai pesan saya.”</p>
                    </div>
                </div>

                <div style="background: white; border-radius: 12px; padding: 18px; box-shadow: 0 8px 28px rgba(0,0,0,0.06); display:flex; gap:14px; align-items:flex-start;">
                    <img src="{{ asset('images/review-2.jpg') }}" alt="avatar" style="width:64px; height:64px; border-radius:999px; object-fit:cover;">
                    <div style="flex:1;">
                        <div style="display:flex; justify-content:space-between; align-items:center; gap:12px;">
                            <div style="font-weight:700; color:var(--color-text-dark);">Adel Bajideh</div>
                            <div style="color:#f9739c; font-weight:700;">★★★★★</div>
                        </div>
                        <p style="margin:8px 0 0; color:var(--color-text-light); line-height:1.5;">“Pilihan bunga variatif dan harganya sesuai. Pengiriman tepat waktu, dan penerima sangat senang.”</p>
                    </div>
                </div>

                <div style="background: white; border-radius: 12px; padding: 18px; box-shadow: 0 8px 28px rgba(0,0,0,0.06); display:flex; gap:14px; align-items:flex-start;">
                    <img src="{{ asset('images/review-3.jpg') }}" alt="avatar" style="width:64px; height:64px; border-radius:999px; object-fit:cover;">
                    <div style="flex:1;">
                        <div style="display:flex; justify-content:space-between; align-items:center; gap:12px;">
                            <div style="font-weight:700; color:var(--color-text-dark);">Rina Wijaya</div>
                            <div style="color:#f9739c; font-weight:700;">★★★★★</div>
                        </div>
                        <p style="margin:8px 0 0; color:var(--color-text-light); line-height:1.5;">“Kualitas bunga bagus, dan respon customer service membantu memilih rangkaian yang pas untuk acara keluarga.”</p>
                    </div>
                </div>
            </div>
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
        <!-- Newsletter / Subscribe section (large) -->
        <section style="background-image: linear-gradient(135deg, rgba(255,181,167,0.10), rgba(237,56,120,0.06)), url('{{ asset('images/bg.jpg') }}'); background-size: cover; color: var(--color-text-dark); padding: 64px 20px; margin-top: 18px;">
            <div style="max-width:1200px; margin: 0 auto; display:flex; gap:30px; align-items:center; flex-wrap:wrap;">
                <div style="flex:1; min-width:300px; color: var(--color-text-dark);">
                    <h2 style="font-family: var(--font-display); font-size: 44px; margin:0 0 8px; line-height:1.05; color:var(--color-text-dark);">JANGAN SAMPAI KETINGGALAN — DAPATKAN UPDATE & PROMO</h2>
                    <p style="margin: 10px 0 18px; color: var(--color-text-light); max-width:620px;">Berlangganan untuk mendapatkan promo menarik, informasi produk baru, dan tips perawatan tanaman setiap bulan.</p>
                </div>

                <div style="flex:0 0 420px; min-width:260px;">
                    <form action="{{ route('subscribe') }}" method="post" style="display:flex; gap:8px; align-items:center; background: rgba(255,255,255,0.06); padding:12px; border-radius:999px; backdrop-filter: blur(4px);">
                        @csrf
                        <input type="email" name="email" placeholder="Masukkan email Anda" required style="flex:1; padding:12px 16px; border-radius:999px; border: 1px solid rgba(0,0,0,0.06); background: rgba(255,255,255,0.96); color:var(--color-text-dark); outline: none;">
                        <button type="submit" style="padding:10px 18px; background: linear-gradient(135deg,var(--color-pastel-bliss-1), var(--color-accent-strong)); border: none; color: white; border-radius:999px; font-weight:700;">BERLANGGANAN</button>
                    </form>

                    @if(session('subscribed'))
                        <div style="margin-top:12px; background: rgba(255,255,255,0.96); padding:8px 12px; border-radius:8px; color: var(--color-text-dark); font-weight:600;">Terima kasih — email Anda sudah kami terima.</div>
                    @endif
                </div>
            </div>
        </section>

    </main>

    <footer style="background: var(--color-pastel-bliss-3); padding:60px 18px 36px; margin-top:18px;">
        <div style="max-width:1200px; margin: 0 auto; display:grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap:18px; align-items:start;">
            <div style="padding-right:12px;">
                <div style="font-family: var(--font-display); font-size:20px; color:var(--color-text-dark); font-weight:700; margin-bottom:8px;">Whispering Flora</div>
                <p style="color:var(--color-text-light); font-size:14px; margin:0;">Dari kelopak pertama hingga akhir, kami merangkai setiap bunga dengan ketulusan, kreativitas, dan perhatian pada detail.</p>
            </div>

            <div>
                <h4 style="font-weight:700; margin-bottom:8px; color:var(--color-text-dark);">Halaman</h4>
                <ul style="list-style:none; padding:0; margin:0; color:#6b7280;">
                    <li><a href="{{ route('catalog.index') }}">Katalog</a></li>
                    <li><a href="{{ route('search') }}?q=">Produk</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="{{ route('cart') }}">Keranjang</a></li>
                </ul>
            </div>

            <div>
                <h4 style="font-weight:700; margin-bottom:8px; color:var(--color-text-dark);">Informasi</h4>
                <ul style="list-style:none; padding:0; margin:0; color:#6b7280;">
                    <li><a href="#">Kemitraan Korporat</a></li>
                    <li><a href="#">Syarat & Ketentuan</a></li>
                    <li><a href="#">Kebijakan Privasi</a></li>
                    <li><a href="#">Layanan Pelanggan</a></li>
                </ul>
            </div>

            <div>
                <h4 style="font-weight:700; margin-bottom:8px; color:var(--color-text-dark);">Perusahaan</h4>
                <ul style="list-style:none; padding:0; margin:0; color:#6b7280;">
                    <li><a href="#">Siaran Pers</a></li>
                    <li><a href="#">Karir</a></li>
                    <li><a href="#">Cara Pesan</a></li>
                    <li><a href="#">Laporan</a></li>
                </ul>
            </div>
        </div>

        <div style="max-width:1200px; margin:18px auto 0; color:#6b7280; display:flex; justify-content:space-between; align-items:center; font-size:13px;">
            <div>&copy; {{ date('Y') }} Whispering Flora. Semua hak dilindungi.</div>
            <div>
                <a href="#" style="margin-right:12px;">Kebijakan Privasi</a>
                <a href="#" style="margin-right:12px;">Syarat & Ketentuan</a>
                <a href="#">Kontak Kami</a>
            </div>
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

        // Welcome page carousel (prev/next + dots + keyboard)
        (function() {
            const carousel = document.getElementById('welcome-carousel');
            if (!carousel) return;

            const track = carousel.querySelector('.welcome-track');
            const slides = Array.from(track.children);
            let index = 0;

            const prevBtn = document.getElementById('welcome-prev');
            const nextBtn = document.getElementById('welcome-next');
            const dotsContainer = document.getElementById('welcome-dots');

            function renderDots() {
                dotsContainer.innerHTML = '';
                slides.forEach((s, i) => {
                    const dot = document.createElement('button');
                    dot.className = 'dot' + (i === index ? ' active' : '');
                    dot.addEventListener('click', () => goTo(i));
                    dotsContainer.appendChild(dot);
                });
            }

            function goTo(i) {
                index = (i + slides.length) % slides.length;
                const target = slides[index];
                // move track so target slide aligns with container
                track.style.transform = `translateX(${-target.offsetLeft}px)`;
                updateDots();
            }

            function updateDots() {
                const dots = Array.from(dotsContainer.children);
                dots.forEach((d, i) => d.classList.toggle('active', i === index));
            }

            prevBtn.addEventListener('click', () => goTo(index - 1));
            nextBtn.addEventListener('click', () => goTo(index + 1));

            document.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft') prevBtn.click();
                if (e.key === 'ArrowRight') nextBtn.click();
            });

            // Reposition on resize
            window.addEventListener('resize', () => goTo(index));

            renderDots();
            goTo(0);
        })();
    </script>

    @include('auth._login-modal')

    </body>
    </html>