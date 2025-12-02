<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Pesanan Selesai - Whispering Flora</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root{--accent:#ED3878;--text:#5A4B4B}
        body{font-family:Quicksand,system-ui,Segoe UI,Roboto,Arial;background:#F8EDEB;color:var(--text)}
        .title-display{font-family:'Playfair Display',serif}
    </style>
</head>
<body class="min-h-screen">

    @include('components.header')

    <main class="max-w-3xl mx-auto px-6 py-16">
        <div class="bg-white rounded-xl p-8 shadow-lg border border-[#F3D8D8]">
            @php
                $status = $status ?? request()->query('status', 'success');
                $orderId = request()->query('order_id', null);
            @endphp

            <div class="flex items-center gap-6">
                <div class="flex-none">
                    @if($status === 'success')
                        <div class="w-20 h-20 rounded-full bg-[#E9F8EF] flex items-center justify-center border border-green-200">
                            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                    @elseif($status === 'pending')
                        <div class="w-20 h-20 rounded-full bg-[#FFF2D9] flex items-center justify-center border border-yellow-200">
                            <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"></path></svg>
                        </div>
                    @else
                        <div class="w-20 h-20 rounded-full bg-[#FFECEC] flex items-center justify-center border border-red-200">
                            <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </div>
                    @endif
                </div>

                <div class="flex-1">
                    <h1 class="text-2xl md:text-3xl title-display font-bold text-[#2D1F1F]">
                        @if($status === 'success') Terima kasih! Pesanan Anda Berhasil. @elseif($status === 'pending') Pembayaran Terkonfirmasi (Pending) @else Terjadi Kesalahan pada Pembayaran @endif
                    </h1>
                    <p class="mt-2 text-sm text-[#7A6A6A]">Kami sudah menerima permintaan Anda. Detail ringkasan pesanan akan dikirimkan via email.</p>

                    @if($orderId)
                        <div class="mt-4 text-sm text-[#5A4B4B]">Order ID: <span class="font-medium">{{ $orderId }}</span></div>
                    @endif
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-[#FBF7F8] p-4 rounded-md border">
                    <h3 class="font-semibold text-sm mb-2">Ringkasan</h3>
                    <div class="text-sm text-[#5A4B4B]">Subtotal: —</div>
                    <div class="text-sm text-[#5A4B4B]">Pengiriman: —</div>
                    <div class="text-sm text-[#5A4B4B]">Diskon: —</div>
                    <div class="mt-3 text-lg font-bold text-[#2D1F1F]">Total: —</div>
                </div>

                <div class="bg-[#FBF7F8] p-4 rounded-md border">
                    <h3 class="font-semibold text-sm mb-2">Langkah Selanjutnya</h3>
                    <ul class="text-sm text-[#5A4B4B] list-inside list-disc space-y-2">
                        <li>Cek email untuk detail pesanan dan bukti pembayaran.</li>
                        <li>Tim kami akan menghubungi jika perlu konfirmasi tambahan.</li>
                        <li>Anda dapat melihat riwayat pesanan di profil Anda.</li>
                    </ul>
                </div>
            </div>

            <div class="mt-8 flex gap-4 justify-end">
                <a href="/" class="px-6 py-3 rounded-md border font-semibold">Kembali ke Beranda</a>
                <a href="/profile" class="px-6 py-3 rounded-md bg-[#ED3878] text-white font-bold">Lihat Pesanan Saya</a>
            </div>
        </div>
    </main>

</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Konfirmasi Pesanan</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;600&display=swap" rel="stylesheet">
    <style>body{font-family:Quicksand, sans-serif; padding:40px; background:#fafafa; color:#222}</style>
</head>
<body>
    <h1>Konfirmasi Pesanan</h1>
    @if(isset($status) && $status === 'success')
        <p>Terima kasih! Pembayaran berhasil. Pesanan Anda akan segera diproses.</p>
    @else
        <p>Status pembayaran: {{ $status }}</p>
        <p>Kami belum menerima pembayaran. Silakan hubungi admin jika perlu bantuan.</p>
    @endif
    <p><a href="{{ route('catalog.index') }}">Kembali ke Katalog</a></p>
</body>
</html>
