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
