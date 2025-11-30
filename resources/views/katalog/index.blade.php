<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Katalog - Whispering Flora</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
      .catalog-hero { padding: 60px 40px; text-align:center; background: linear-gradient(180deg,#fff6f6,#fff); }
      .catalog-hero h1 { font-family: 'Playfair Display', serif; font-size: 2.6rem; margin: 0 0 8px; }
      .catalog-hero p { color: #6b7280; margin: 0; }

      .carousel { max-width: 1100px; margin: 40px auto; position: relative; overflow: hidden; }
      .carousel-track { display: flex; transition: transform 0.4s ease; }
      .carousel-slide { min-width: 100%; box-sizing: border-box; padding: 20px; display: flex; gap: 24px; align-items: center; }

      .slide-image { flex: 0 0 50%; aspect-ratio: 1; border-radius: 12px; overflow: hidden; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
      .slide-image img { width: 100%; height: 100%; object-fit: cover; display:block; }

      .slide-info { flex: 1; padding: 12px 18px; }
      .slide-info h2 { margin: 0 0 10px; font-size: 26px; color: #1f2937; }
      .slide-info p { color: #6b7280; line-height: 1.5; }
      .slide-info .price { margin-top: 16px; font-weight: 700; color: #ec4899; font-size: 20px; }

      .carousel-btn { position: absolute; top: 50%; transform: translateY(-50%); width: 48px; height: 48px; background: rgba(255,255,255,0.9); border-radius: 999px; display:flex; align-items:center; justify-content:center; box-shadow: 0 6px 18px rgba(0,0,0,0.12); cursor:pointer; }
      .carousel-btn.prev { left: 12px; }
      .carousel-btn.next { right: 12px; }

      .carousel-pagination { text-align:center; margin-top: 14px; }
      .dot { display:inline-block; width: 10px; height: 10px; border-radius: 999px; background: #e5e7eb; margin: 0 6px; cursor:pointer; }
      .dot.active { background: #ec4899; }

      @media (max-width: 900px) {
        .carousel-slide { flex-direction: column; }
        .slide-image { width: 100%; flex: 0 0 auto; }
        .slide-info { width: 100%; }
      }
    </style>
  </head>
  <body>

    @include('components.header')

    <main>
      <section class="catalog-hero">
        <h1>✨ Katalog Produk</h1>
        <p>Temukan semua bunga pilihan — gunakan tombol prev / next untuk menelusuri produk.</p>
      </section>

      <div style="padding: 24px 20px;">
        <div class="breadcrumb" style="max-width:1100px;margin: 14px auto; display:flex; gap:8px; align-items:center; color:#6b7280;">
          <a href="{{ route('catalog.index') }}" style="text-decoration:none; font-weight:600; color: inherit;">Katalog</a>
          <span style="color:#e5e7eb">›</span>
          <span>Semua Produk</span>
        </div>

        @if(isset($products) && $products->count())
          <div class="carousel" id="product-carousel">
            <div class="carousel-track">
              @foreach($products as $product)
                <div class="carousel-slide" data-slug="{{ $product->slug }}">
                  <a href="{{ route('jenis.show', $product->slug) }}" style="display:flex; gap:24px; align-items:center; width:100%; text-decoration:none; color: inherit;">
                    <div class="slide-image">
                      <img src="{{ asset('images/' . ($product->image ?? 'babybreath.jpg')) }}" alt="{{ $product->name }}">
                    </div>
                    <div class="slide-info">
                      <h2>{{ $product->name }}</h2>
                      <p>{{ \Illuminate\Support\Str::limit($product->description, 250) }}</p>
                      <div class="price">{{ $product->price }}</div>
                    </div>
                  </a>
                </div>
              @endforeach
            </div>

            <button class="carousel-btn prev" id="carousel-prev" aria-label="Previous">◀</button>
            <button class="carousel-btn next" id="carousel-next" aria-label="Next">▶</button>
          </div>

          <div class="carousel-pagination" id="carousel-dots" aria-hidden="false"></div>

        @else
          <div style="max-width:1100px; margin:30px auto; text-align:center; color:#6b7280;">Belum ada produk.</div>
        @endif
      </div>

    </main>

    @include('auth._login-modal')

    <script>
      (function() {
        const track = document.querySelector('.carousel-track');
        if (!track) return;

        const slides = Array.from(track.children);
        let index = 0;

        const prevBtn = document.getElementById('carousel-prev');
        const nextBtn = document.getElementById('carousel-next');
        const dotsContainer = document.getElementById('carousel-dots');

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
          track.style.transform = `translateX(${-index * 100}%)`;
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

        renderDots();
        // initial layout
        goTo(0);
      })();
    </script>
  </body>
</html>
