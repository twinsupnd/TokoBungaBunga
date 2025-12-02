<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tentang Kami - Whispering Flora</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
      .about-hero { background: linear-gradient(180deg, #fff6f6 0%, #fff 60%); padding: 80px 24px; text-align:center; }
      .about-hero h1 { font-family: 'Playfair Display', serif; font-size: 3rem; margin: 0 0 12px; color:#8b2b2b }
      .about-hero p { color: #6b7280; max-width:760px; margin: 0 auto; font-size:16px }

      .section { padding: 48px 20px; max-width:1200px; margin: 0 auto; }
      .values { display:grid; grid-template-columns: repeat(auto-fit,minmax(260px,1fr)); gap: 18px; margin-top: 28px; }
      .value-card { background: white; padding: 22px; border-radius: 12px; box-shadow: 0 6px 20px rgba(0,0,0,0.06); text-align:left }
      .value-card h3 { margin: 0 0 6px; color: #1f2937 }
      .value-card p { margin: 0; color:#6b7280 }

      .team-grid { display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; }
      .team-card { background: white; padding: 18px; border-radius: 12px; text-align:center; box-shadow: 0 6px 18px rgba(0,0,0,0.06); }
      .team-card img { width: 100%; height: 180px; object-fit:cover; border-radius: 10px; }

      .cta-hero { margin-top: 24px; padding: 26px; background: linear-gradient(90deg, rgba(236,72,153,0.06), rgba(212,132,124,0.02)); border-radius: 14px; display:flex; gap: 18px; align-items:center; justify-content:space-between; }

      @media (max-width: 780px) { .cta-hero { flex-direction: column; align-items:stretch; } }
    </style>
  </head>
  <body>

    @include('components.header')

    <main>
      <section class="about-hero" style="background: linear-gradient(180deg,#ffe8eb 0%, #fff6f8 60%); padding: 36px 20px 60px;">
        <div style="max-width:1200px;margin: 0 auto;">
          <div style="display:flex; gap:22px; align-items:stretch;">
            <a href="javascript:history.back()" style="background: rgba(255,255,255,0.85); display:inline-flex; align-items:center; gap:8px; padding:8px 12px; border-radius:20px; text-decoration:none; color:#8b2b2b; font-weight:600; box-shadow: 0 6px 18px rgba(0,0,0,0.06);">
              ◀ Kembali
            </a>
          </div>

          <div style="margin-top:18px; display:grid; grid-template-columns: 1fr 420px; gap: 26px; align-items:center;">
            <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 12px 34px rgba(0,0,0,0.12);">
              <img src="{{ asset('images/Bungawelcome.png') }}" alt="hero" style="width:100%; height:420px; object-fit:cover; display:block;">
            </div>

            <div style="background: linear-gradient(180deg, #f9739c 0%, #ee6b7c 100%); color: white; border-radius: 10px; padding: 32px 24px; display:flex; flex-direction:column; align-items:center; justify-content:center; box-shadow: 0 12px 30px rgba(0,0,0,0.08);">
              <div style="display:flex; flex-direction:column; align-items:center; gap:14px;">
                <img src="{{ asset('images/logo.png') }}" alt="Whispering Flora" style="height:64px; width:auto; filter: brightness(140%);">
                <div style="font-weight:800; letter-spacing:0.6px; font-size:20px; opacity:0.98;">Whispering Flora</div>
                <div style="font-style:italic; opacity:0.95;">Connecting Hearts, One Bouquet at a Time</div>
                <div style="width:95px; height:3px; background: rgba(255,255,255,0.25); margin-top:8px; border-radius:1px;"></div>
                <p style="text-align:center; margin-top:6px; color: rgba(255,255,255,0.95); max-width:320px; line-height:1.55;">Kami membantu Anda menyampaikan pesan yang dalam dengan rangkaian bunga yang penuh perhatian. Dari pilihan bunga berkualitas hingga pengiriman yang aman — setiap pesanan dikerjakan dengan ketulusan.</p>
                <a href="{{ route('catalog.index') }}" class="cta-button" style="margin-top:12px; background: rgba(255,255,255,0.14); color:white; border:1px solid rgba(255,255,255,0.06); padding:10px 16px; border-radius:999px; text-decoration:none; font-weight:700;">Lihat Katalog</a>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section id="story" class="section">
        <div style="display:flex; gap:30px; align-items:center; flex-wrap:wrap;">
          <div style="flex:1; min-width:280px;">
            <h2 style="font-family: 'Playfair Display', serif; font-size:28px; margin:0 0 10px; color:#8b2b2b;">Tentang Whispering Flora</h2>
            <p style="color:#444; font-size:16px; margin-bottom:10px;">
              Kami membantu Anda menyampaikan rasa melalui rangkaian bunga yang dipilih dengan cermat. Dari pemilihan bunga sampai pengiriman, semua langkah dilakukan agar pesan Anda sampai dengan hangat.
            </p>

            <div style="display:flex; gap:10px; margin-top:8px;">
              <div style="flex:1; background:#fff; border-radius:8px; padding:12px; box-shadow:0 6px 18px rgba(0,0,0,0.04); text-align:center;">
                <div style="font-weight:700; color:#ec4899">Kualitas</div>
                <div style="font-size:13px; color:#6b7280; margin-top:6px;">Bunga diperiksa dan dipilih untuk hasil terbaik.</div>
              </div>
              <div style="flex:1; background:#fff; border-radius:8px; padding:12px; box-shadow:0 6px 18px rgba(0,0,0,0.04); text-align:center;">
                <div style="font-weight:700; color:#ec4899">Desain</div>
                <div style="font-size:13px; color:#6b7280; margin-top:6px;">Rangkaian yang elegan dan bermakna untuk setiap momen.</div>
              </div>
              <div style="flex:1; background:#fff; border-radius:8px; padding:12px; box-shadow:0 6px 18px rgba(0,0,0,0.04); text-align:center;">
                <div style="font-weight:700; color:#ec4899">Layanan</div>
                <div style="font-size:13px; color:#6b7280; margin-top:6px;">Pengiriman aman dan layanan bantu pilih rangkaian.</div>
              </div>
            </div>
          </div>

        
        </div>
      </section>

      <section class="section" style="background: linear-gradient(180deg,#fff,#fff9f6); border-radius:12px; margin: 18px 18px 48px; padding: 36px;">
        <h3 style="text-align:center; font-size:20px; margin-bottom:6px;">Nilai-nilai kami</h3>
        <p style="text-align:center; color:#6b7280; max-width:760px; margin: 0 auto 22px;">Kami berdiri di atas tiga pilar yang membentuk layanan dan produk kami.</p>

        <div class="values">
          <div class="value-card">
            <h3>Kesungguhan</h3>
            <p>Setiap rangkaian dibuat dengan perhatian pada detail — dari pemilihan bunga hingga penyusunan finishing.</p>
          </div>
          <div class="value-card">
            <h3>Kualitas</h3>
            <p>Kami menjaga standar kualitas tinggi agar setiap pesanan sampai dalam kondisi terbaik.</p>
          </div>
          <div class="value-card">
            <h3>Kreativitas</h3>
            <p>Desain modern dan berjiwa, menggabungkan sentuhan tradisional dan estetika kontemporer.</p>
          </div>
        </div>
      </section>

      <section class="section">
        <div style="text-align:center; margin: 20px 0 36px;">
          <h3 style="margin:0 0 12px;">Mitra kami</h3>
          <p style="color:#6b7280; max-width:820px; margin:0 auto;">Kami bekerja sama dengan pembudidaya & florists berpengalaman untuk memastikan setiap rangkaian berkualitas dan dikirim dengan hati-hati.</p>
        </div>
      </section>

      <section class="section" style="margin-bottom: 80px;">
        <div class="cta-hero">
          <div style="display:flex; justify-content:space-between; align-items:center; gap:18px; flex-wrap:wrap;">
            <div>
              <h3 style="margin:0; font-size:20px;">Butuh rekomendasi rangkaian?</h3>
              <p style="margin:6px 0 0; color:#6b7280;">Kami siap bantu memilih rangkaian sesuai momen — chat cepat lewat WhatsApp, atau telusuri katalog kami.</p>
            </div>
            <div style="display:flex; gap:12px; align-items:center;">
              <a href="https://wa.me/6281234567890" class="cta-button" style="padding:10px 14px; background:#25D366; color:white; border-radius:8px; text-decoration:none; font-weight:700;">Chat WhatsApp</a>
              <a href="{{ route('catalog.index') }}" class="cta-button" style="background: #ec4899; color: white; padding:10px 14px; border-radius:8px; text-decoration:none; font-weight:700;">Lihat Katalog</a>
            </div>
          </div>
        </div>
      </section>

    </main>

    @include('components.footer')

    @include('auth._login-modal')

  </body>
</html>
