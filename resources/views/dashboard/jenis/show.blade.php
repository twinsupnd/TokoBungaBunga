@extends('dashboard.layout')

@section('title', 'Detail Produk')

@section('content')

<style>
    .header-section { display: flex; justify-content: space-between; align-items: flex-start; gap: 18px; margin-bottom: 28px; }
    .page-header { flex: 1; }
    .page-title { font-size: 28px; font-weight: 700; color: var(--text); margin: 0; }
    .page-subtitle { font-size: 14px; color: var(--muted); margin: 6px 0 0 0; }

    .detail-grid { display: grid; grid-template-columns: 320px 1fr; gap: 24px; }
    .card { background: var(--pastel-card); border-radius: 14px; padding: 24px; box-shadow: 0 8px 20px rgba(34,34,59,0.04); border: 1px solid rgba(199,183,255,0.1); }
    .card img { width: 100%; border-radius: 10px; object-fit: cover; }

    .product-details h2 { margin: 0 0 12px 0; font-size: 24px; font-weight: 700; color: var(--text); }
    .product-price { font-size: 20px; font-weight: 700; color: var(--pastel-accent); margin-bottom: 18px; }
    .product-description { color: var(--text); line-height: 1.7; margin-bottom: 24px; font-size: 14px; }

    .action-buttons { display: flex; gap: 12px; flex-wrap: wrap; }
    .btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 10px 18px; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; font-size: 14px; text-decoration: none; }
    .btn-primary { background: linear-gradient(135deg, var(--pastel-accent), var(--pastel-accent-2)); color: white; }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 16px rgba(199,183,255,0.3); }
    .btn-secondary { background: rgba(199,183,255,0.1); color: var(--pastel-accent); border: 1px solid var(--pastel-accent); }
    .btn-secondary:hover { background: rgba(199,183,255,0.15); }
    .btn-danger { background: rgba(255,107,107,0.15); color: #FF6B6B; border: 1px solid #FF6B6B; }
    .btn-danger:hover { background: rgba(255,107,107,0.25); }

    @media (max-width: 900px) {
        .header-section { flex-direction: column; }
        .detail-grid { grid-template-columns: 1fr; }
        .action-buttons { width: 100%; }
        .btn { flex: 1; }
    }
</style>

<div class="header-section">
    <div class="page-header">
        <h1 class="page-title">📦 Detail Produk</h1>
        <p class="page-subtitle">Informasi lengkap dan pengelolaan produk</p>
    </div>
    <a href="{{ route('dashboard.jenis.index') }}" class="btn btn-secondary">← Kembali ke Daftar</a>
</div>

<div class="detail-grid">
    <!-- Product Image -->
    <div class="card">
        <img src="{{ asset('images/' . ($item->image ?? 'babybreath.jpg')) }}" alt="{{ $item->name }}">
    </div>

    <!-- Product Details -->
    <div class="card product-details">
        <h2>{{ $item->name }}</h2>
        <div class="product-price">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
        <div class="product-description">
            {{ $item->description ?: 'Tidak ada deskripsi produk.' }}
        </div>

        <div class="action-buttons">
            <a href="{{ route('dashboard.jenis.edit', $item->slug) }}" class="btn btn-primary">✏️ Edit Produk</a>
            <form method="POST" action="{{ route('dashboard.jenis.destroy', $item->slug) }}" style="flex: 1;" onsubmit="return confirm('Yakin ingin menghapus produk ini? Tindakan ini tidak dapat dibatalkan.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" style="width: 100%">🗑️ Hapus Produk</button>
            </form>
        </div>
    </div>
</div>

@endsection
