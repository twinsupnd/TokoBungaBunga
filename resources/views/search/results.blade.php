<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pencarian "{{ $q }}" — Whispering Flora</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
      .results-wrap { max-width:1200px; margin: 36px auto; padding: 0 20px; }
      .search-hero { padding: 18px 0 8px; text-align:center; }
      .search-input { width: 100%; max-width:680px; margin: 10px auto; display:flex; gap:8px; }
      .product-grid { display:grid; grid-template-columns: repeat(auto-fill,minmax(260px,1fr)); gap: 18px; margin-top:18px; }
      .empty { text-align:center; color:#6b7280; padding: 50px 14px; }
    </style>
  </head>
  <body>

    @include('components.header')

    <main>
      <div class="results-wrap">
        <div class="search-hero">
          <h2 style="margin:0;">Hasil Pencarian untuk "{{ $q }}"</h2>
          <div style="margin-top:8px;">
            <form action="{{ route('search') }}" method="get" class="search-input">
              <input type="text" name="q" value="{{ $q }}" placeholder="Cari bunga..." style="flex:1; padding:12px 14px; border-radius:999px; border:1px solid #eee;">
              <button type="submit" style="padding:10px 14px; border-radius:999px; border: none; background:#ec4899; color:#fff; font-weight:700;">Cari</button>
            </form>
          </div>
        </div>

        @if($products->count())
          <div class="product-grid">
            @foreach($products as $product)
              <a href="{{ route('jenis.show', $product->slug) }}" style="text-decoration:none; color:inherit;">
                <div class="product-card" style="background:white; border-radius:12px; overflow:hidden; box-shadow:0 6px 20px rgba(0,0,0,0.06);">
                  <div style="aspect-ratio:1; overflow:hidden;"><img src="{{ asset('images/' . ($product->image ?? 'babybreath.jpg')) }}" alt="{{ $product->name }}" style="width:100%; height:100%; object-fit:cover"></div>
                  <div style="padding:12px;">
                    <h3 style="margin:0 0 6px;">{{ $product->name }}</h3>
                    <p style="margin:0; color:#6b7280">{{ \Illuminate\Support\Str::limit($product->description, 80) }}</p>
                    <div style="margin-top:8px; font-weight:700; color:#ec4899">{{ $product->price }}</div>
                  </div>
                </div>
              </a>
            @endforeach
          </div>
        @else
          <div class="empty">
            <p>Tidak ditemukan hasil untuk <strong>"{{ $q }}"</strong>.</p>
            <p>Coba kata kunci lain atau lihat <a href="{{ route('catalog.index') }}">semua produk</a>.</p>
          </div>
        @endif

      </div>
    </main>

    @include('auth._login-modal')

  </body>
</html>
