@extends('dashboard.layout')

@section('title', 'Kelola Produk')

@section('content')

<style>
    .section { margin-bottom: 32px; }
    .product-grid { display:grid; grid-template-columns: minmax(280px,420px) 1fr; gap:24px; align-items:start; margin-bottom:36px; box-sizing: border-box; font-family: Inter, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; }
    .card {
        background: #fff;
        border-radius: 12px;
        padding: 20px 18px;
        box-shadow: 0 6px 18px rgba(86,63,163,0.06);
        border: 1px solid #efeafc;
        max-width: none;
        margin: 0;
    }
    .card h2 {
        margin: 0 0 12px 0;
        font-size: 16px;
        font-weight: 600;
        color: #3b2f61;
        text-align: left;
    }
    .form-group { margin-bottom: 14px; }
    .form-group label { display: block; font-weight: 500; color: #5b497f; margin-bottom: 6px; font-size: 13px; }
    .form-input {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #efe9ff;
        border-radius: 12px;
        font-size: 14px;
        background: linear-gradient(180deg,#ffffff,#fbf8ff);
        color: #2f2a4a;
        transition: all 0.14s ease;
        box-shadow: 0 2px 8px rgba(99,72,171,0.04);
    }
    .form-input::placeholder { color: #bdb3d6; }
    .form-input:focus {
        outline: none;
        border-color: #b794f4;
        box-shadow: 0 6px 18px rgba(167,139,250,0.12);
        background: #fff;
    }
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 20px;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.18s ease;
        font-size: 15px;
        box-shadow: 0 6px 20px rgba(167,139,250,0.08);
    }
    .btn-primary {
        background: linear-gradient(135deg, #a78bfa, #fbc2eb);
        color: white;
    }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 16px rgba(199,183,255,0.18); }
    .btn-secondary { background: #f7f6fd; color: #a78bfa; border: 1px solid #a78bfa; }
    .btn-secondary:hover { background: #ece9f9; }
    .table-wrapper { overflow-x: auto; margin-top: 6px; }
    table { width: 100%; border-collapse: collapse; background: transparent; font-size: 14px; }
    thead th { background: #faf8ff; padding: 10px 8px; text-align: left; font-weight: 600; color: #4b3c7a; font-size: 13px; border-bottom: 1px solid #f1ecfb; }
    tbody td { padding: 10px 8px; border-bottom: 1px solid #f1ecfb; color: #2f2a4a; font-size: 14px; vertical-align: middle; }
    tr:hover { background: #f7f6fd; }
    .action-cell { display: flex; gap: 8px; align-items: center; }
    .table-actions { display:flex; justify-content:flex-end; }
    .action-link { display: inline-flex; align-items: center; justify-content: center; gap: 6px; padding: 6px 10px; border-radius: 6px; font-size: 13px; font-weight: 600; text-decoration: none; transition: all 0.14s ease; white-space: nowrap; border: none; }
    .action-pill { padding:6px 10px; border-radius:10px; font-weight:600; font-size:13px; border: none; }
    .link-view { color: #6b46c1; background: #fbf8ff; }
    .link-view:hover { background: #f3efff; transform: translateY(-2px); }
    .link-edit { color: #7b3b6f; background: #fff6fb; }
    .link-edit:hover { background: #fff0f7; transform: translateY(-2px); }
    .link-delete { color: #e53e3e; background: #fff5f5; }
    .link-delete:hover { background: #ffecec; transform: translateY(-2px); }
    .inline-form { display: inline; }
    .empty-state { text-align: center; padding: 28px 16px; color: #8a8a9b; }
    .thumb { width:56px; height:56px; object-fit:cover; border-radius:8px; border:1px solid #f1edf9; box-shadow: 0 4px 10px rgba(89,63,133,0.04); }
    .name-cell { font-weight:600; color:#2f2a4a; }
    .price-cell { color:#6b46c1; font-weight:600; }
    .count-badge { display:inline-block; padding:4px 8px; border-radius:6px; font-weight:600; font-size:13px; }
    .in-stock { background:#f3fdf3; color:#2e7d32; }
    .out-stock { background:#fff0f0; color:#c62828; }
    @media (max-width: 900px) { .product-grid { display:block; } .card { padding: 14px 10px; } thead th, tbody td { font-size: 13px; padding: 8px 6px; } }
</style>
<div class="product-grid">
    <!-- Left: Form -->
    <div class="card">
        <h2>Tambah Produk</h2>
        <form action="{{ route('dashboard.jenis.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Nama Produk</label>
                <input type="text" name="name" id="name" class="form-input" placeholder="Contoh: Bunga Mawar Merah" required>
            </div>
            <div class="form-group">
                <label for="price">Harga (Rp)</label>
                <input type="number" name="price" id="price" class="form-input" placeholder="Contoh: 75000" min="0" required>
            </div>
            <div class="form-group">
                <label for="stock">Stok</label>
                <input type="number" name="stock" id="stock" class="form-input" placeholder="Contoh: 50" min="0">
            </div>
            <div class="form-group">
                <label for="image">Gambar Produk (opsional)</label>
                <div class="file-input-wrap" style="display:flex;gap:10px;align-items:center;">
                    <label for="image" class="btn btn-secondary" style="padding:8px 12px; border-radius:10px; font-weight:600; cursor:pointer;">Pilih Gambar</label>
                    <span id="file-name" style="color:#8b83a6;font-size:13px;">Tidak ada file dipilih</span>
                </div>
                <input type="file" name="image" id="image" accept="image/*" class="form-input" style="display:none;">
            </div>
            <div class="form-group">
                <label for="description">Deskripsi singkat</label>
                <textarea name="description" id="description" class="form-input" rows="3" placeholder="Opsional, deskripsi singkat..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%; background: linear-gradient(90deg,#a78bfa,#fbc2eb); color:#fff;">Simpan</button>
        </form>
    </div>

    <!-- Right: Table -->
    <div class="card">
        <h2>Daftar Produk ({{ $items->count() }})</h2>
        @if($items->count())
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th style="padding:8px 6px; font-size:13px; font-weight:500;">Gambar</th>
                            <th style="padding:8px 6px; font-size:13px; font-weight:500;">Nama Produk</th>
                            <th style="padding:8px 6px; font-size:13px; font-weight:500;">Harga</th>
                            <th style="padding:8px 6px; font-size:13px; font-weight:500;">Stok</th>
                            <th style="padding:8px 6px; font-size:13px; font-weight:500;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            <tr style="font-size:14px;">
                                <td style="text-align:center;">
                                    <img src="{{ $item->image ? Storage::disk('public')->url($item->image) : asset('images/babybreath.jpg') }}" alt="{{ $item->name }}" class="thumb">
                                </td>
                                <td class="name-cell">{{ $item->name }}</td>
                                <td class="price-cell">Rp {{ number_format((float) $item->price, 0, ',', '.') }}</td>
                                <td>
                                    @if($item->stock > 0)
                                        <span style="background:#f3fdf3; color:#2ecc40; font-weight:500; padding:2px 8px; border-radius:5px; font-size:13px;">{{ $item->stock }} unit</span>
                                    @else
                                        <span style="background:#fff0f0; color:#ff3b3b; font-weight:500; padding:2px 8px; border-radius:5px; font-size:13px;">Stok Habis</span>
                                    @endif
                                </td>
                                <td style="padding:6px;">
                                    <div class="action-cell" style="gap:6px;">
                                        <a href="{{ route('dashboard.jenis.show', $item->slug) }}" class="action-link action-pill link-view" title="Lihat Detail">Lihat</a>
                                        <a href="{{ route('dashboard.jenis.edit', $item->slug) }}" class="action-link action-pill link-edit" title="Edit Produk">Edit</a>
                                        <form action="{{ route('dashboard.jenis.destroy', $item->slug) }}" method="POST" class="inline-form" onsubmit="return confirm('Yakin hapus produk ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-link action-pill link-delete" title="Hapus Produk">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <div style="font-size:18px; font-weight:600; margin-bottom:6px;">Belum ada produk</div>
                <div style="color:#9b9bb0;">Tambahkan produk melalui formulir di sebelah kiri.</div>
            </div>
        @endif
    </div>
</div>

<script>
    (function(){
        var input = document.getElementById('image');
        var nameEl = document.getElementById('file-name');
        if (! input) return;
        input.addEventListener('change', function(e){
            var name = (e.target.files && e.target.files.length) ? e.target.files[0].name : 'Tidak ada file dipilih';
            if (nameEl) nameEl.textContent = name;
        });
    })();
</script>

@endsection
