@extends('dashboard.layout')

@section('title', 'Detail Produk')

@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; gap:12px;">
    <div>
        <h1 class="page-title">Detail Produk</h1>
        <p class="text-sm text-gray-500">Informasi lengkap produk</p>
    </div>
    <div>
        <a href="{{ route('dashboard.jenis.index') }}" class="logout-btn">Kembali</a>
    </div>
</div>

<div style="margin-top:18px; display:grid; grid-template-columns: 320px 1fr; gap:18px;">
    <div class="stat-card">
        <img src="{{ asset('images/' . ($item->image ?? 'babybreath.jpg')) }}" alt="{{ $item->name }}" style="width:100%; border-radius:8px; object-fit:cover">
    </div>

    <div class="stat-card">
        <h2 style="margin-top:0">{{ $item->name }}</h2>
        <p style="font-weight:800; color:var(--accent)">{{ $item->price }}</p>
        <div style="margin-top:12px; color:#374151">{{ $item->description }}</div>

        <div style="margin-top:18px; display:flex; gap:8px;">
            <a href="#" class="logout-btn">Edit</a>
            <form method="POST" action="#" onsubmit="return confirm('Hapus produk ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="logout-btn">Hapus</button>
            </form>
        </div>
    </div>
</div>

@endsection
