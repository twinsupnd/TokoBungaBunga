@extends('dashboard.layout')

@section('title', 'Kelola Produk')

@section('content')

<style>
    .page-header { margin-bottom: 28px; }
    .page-title { font-size: 28px; font-weight: 700; color: var(--text); margin: 0; }
    .page-subtitle { font-size: 14px; color: var(--muted); margin: 6px 0 0 0; }

    .alert-success {
        background: linear-gradient(135deg, rgba(199,183,255,0.1), rgba(255,214,224,0.1));
        border: 1px solid rgba(199,183,255,0.3);
        padding: 14px 18px;
        border-radius: 10px;
        margin-bottom: 24px;
        color: var(--pastel-accent);
        font-weight: 500;
        font-size: 14px;
    }

    .content-grid { display: grid; grid-template-columns: 1fr 2fr; gap: 24px; margin-bottom: 28px; }
    
    .card { background: var(--pastel-card); border-radius: 14px; padding: 24px; box-shadow: 0 8px 20px rgba(34,34,59,0.04); border: 1px solid rgba(199,183,255,0.1); }
    .card h2 { margin: 0 0 18px 0; font-size: 18px; font-weight: 700; color: var(--text); }

    .form-group { margin-bottom: 16px; }
    .form-group label { display: block; font-weight: 600; color: var(--text); margin-bottom: 6px; font-size: 14px; }
    .form-input { width: 100%; padding: 10px 12px; border: 1px solid rgba(199,183,255,0.2); border-radius: 8px; font-size: 14px; font-family: inherit; background: rgba(199,183,255,0.04); color: var(--text); transition: all 0.2s ease; }
    .form-input:focus { outline: none; border-color: var(--pastel-accent); box-shadow: 0 0 0 3px rgba(199,183,255,0.1); background: white; }

    .btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 10px 18px; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; font-size: 14px; }
    .btn-primary { background: linear-gradient(135deg, var(--pastel-accent), var(--pastel-accent-2)); color: white; }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 16px rgba(199,183,255,0.3); }
    .btn-secondary { background: rgba(199,183,255,0.1); color: var(--pastel-accent); border: 1px solid var(--pastel-accent); }
    .btn-secondary:hover { background: rgba(199,183,255,0.15); }

    .table-wrapper { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    th { background: linear-gradient(90deg, rgba(199,183,255,0.08), rgba(255,214,224,0.08)); padding: 12px; text-align: left; font-weight: 600; color: var(--text); font-size: 12px; text-transform: uppercase; border-bottom: 2px solid rgba(199,183,255,0.1); }
    td { padding: 14px 12px; border-bottom: 1px solid rgba(199,183,255,0.08); color: var(--text); font-size: 14px; }
    tr:hover { background: rgba(199,183,255,0.04); }

    .action-cell { display: flex; gap: 8px; }
    .action-link { display: inline-flex; align-items: center; justify-content: center; gap: 4px; padding: 6px 12px; border-radius: 6px; font-size: 13px; font-weight: 600; text-decoration: none; transition: all 0.2s ease; }
    .link-view { color: var(--pastel-accent); background: rgba(199,183,255,0.1); }
    .link-view:hover { background: rgba(199,183,255,0.2); }
    .link-edit { color: var(--pastel-accent-2); background: rgba(255,214,224,0.2); }
    .link-edit:hover { background: rgba(255,214,224,0.3); }
    .link-delete { color: #FF6B6B; background: rgba(255,107,107,0.1); }
    .link-delete:hover { background: rgba(255,107,107,0.2); }

    .inline-form { display: inline; }

    .empty-state { text-align: center; padding: 48px 24px; color: var(--muted); }
    .empty-icon { font-size: 48px; margin-bottom: 12px; }

    @media (max-width: 900px) {
        .content-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="page-header">
    <h1 class="page-title">📦 Kelola Produk</h1>
    <p class="page-subtitle">Tambah, edit, dan kelola semua produk bunga Anda</p>
</div>

@if(session('success'))
    <div class="alert-success">✓ {{ session('success') }}</div>
@endif

<div class="content-grid">
    <!-- Form Tambah Produk -->
    <div class="card">
        <h2>Buat Produk Baru</h2>
        <form action="{{ route('dashboard.jenis.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" name="name" class="form-input" placeholder="Misal: Bunga Mawar Merah" required>
            </div>
            <div class="form-group">
                <label>Harga (Rp)</label>
                <input type="text" name="price" class="form-input" placeholder="Misal: 75000" required>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description" class="form-input" rows="4" placeholder="Jelaskan detail produk..."></textarea>
            </div>
            <div class="form-group">
                <label>Gambar Produk</label>
                <input type="file" name="image" accept="image/*" class="form-input">
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">
                ➕ Simpan Produk
            </button>
        </form>
    </div>

    <!-- Daftar Produk -->
    <div class="card">
        <h2>Daftar Produk ({{ $items->count() }})</h2>
        @if($items->count())
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td><strong>{{ $item->name }}</strong></td>
                                <td style="color: var(--pastel-accent); font-weight: 600;">Rp {{ number_format((float) $item->price, 0, ',', '.') }}</td>
                                <td>
                                    <div class="action-cell">
                                        <a href="{{ route('dashboard.jenis.show', $item->id) }}" class="action-link link-view">👁 Lihat</a>
                                        <a href="{{ route('dashboard.jenis.edit', $item->id) }}" class="action-link link-edit">✏️ Edit</a>
                                        <form action="{{ route('dashboard.jenis.destroy', $item->id) }}" method="POST" class="inline-form" onsubmit="return confirm('Yakin hapus produk ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-link link-delete" style="border: none; padding: 6px 12px; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer;">🗑️ Hapus</button>
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
                <div class="empty-icon">📦</div>
                <div>Belum ada produk. Buat produk baru di form sebelah!</div>
            </div>
        @endif
    </div>
</div>

@endsection
