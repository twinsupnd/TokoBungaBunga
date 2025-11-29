@extends('dashboard.layout')

@section('title', 'Kelola Produk')

@section('content')

<h1 class="page-title">Kelola Produk</h1>

@if(session('success'))
    <div style="background:#ecfdf5; border:1px solid #bbf7d0; padding:10px; margin-bottom:12px; color:#065f46">{{ session('success') }}</div>
@endif

<div style="display:flex; gap:18px; flex-wrap:wrap;">
    <div style="flex:1 1 420px;">
        <div class="stat-card">
            <h3>Buat Produk Baru</h3>
            <form action="{{ route('dashboard.jenis.store') }}" method="post" enctype="multipart/form-data" style="margin-top:12px;">
                @csrf
                <div style="margin-bottom:8px;"><label>Nama</label>
                    <input type="text" name="name" class="form-input" required></div>
                <div style="margin-bottom:8px;"><label>Harga</label>
                    <input type="text" name="price" class="form-input"></div>
                <div style="margin-bottom:8px;"><label>Deskripsi</label>
                    <textarea name="description" class="form-input" rows="4"></textarea></div>
                <div style="margin-bottom:8px;"><label>Gambar (jpg/png)</label>
                    <input type="file" name="image" accept="image/*" class="form-input"></div>
                <div>
                    <button class="logout-btn" type="submit">Simpan Produk</button>
                </div>
            </form>
        </div>
    </div>

    <div style="flex:2 1 480px;">
        <div class="stat-card">
            <h3>Daftar Produk</h3>
            <div style="margin-top:12px;">
                @if($items->count())
                    <table style="width:100%; border-collapse:collapse;">
                        <thead>
                            <tr style="border-bottom:1px solid #e6e7ea;">
                                <th style="padding:8px;text-align:left">Nama</th>
                                <th style="padding:8px">Harga</th>
                                <th style="padding:8px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                <tr style="border-bottom:1px solid #f3f4f6">
                                    <td style="padding:8px">{{ $item->name }}</td>
                                    <td style="padding:8px">{{ $item->price }}</td>
                                    <td style="padding:8px">
                                        <a href="{{ route('dashboard.jenis.show', $item->id) }}" style="color:var(--accent); font-weight:700">Lihat</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div>Tidak ada produk.</div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
