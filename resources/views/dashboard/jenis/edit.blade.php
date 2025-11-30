@extends('dashboard.layout')

@section('content')
<div class="dashboard-container">
    <div class="content-header">
        <h1>Edit Produk</h1>
        <p class="text-muted">Perbarui detail produk bunga Anda</p>
    </div>

    <div class="edit-form-container">
        <form action="{{ route('dashboard.jenis.update', $jenis->slug) }}" method="POST" enctype="multipart/form-data" class="form-card">
            @csrf
            @method('PUT')

            <div class="form-section">
                <h2>Informasi Produk</h2>

                <!-- Nama Produk -->
                    <div class="form-group">
                        <label><span style="font-size:16px;">🌸</span> Nama Produk</label>
                        <input type="text" name="name" class="form-input" value="{{ old('name', $jenis->name) }}" required style="font-size:15px;">
                        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                <!-- Harga -->
                    <div class="form-group">
                        <label><span style="font-size:16px;">💸</span> Harga (Rp)</label>
                        <input type="number" name="price" class="form-input" value="{{ old('price', $jenis->price) }}" min="0" required style="font-size:15px;">
                        @error('price') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                <!-- Deskripsi -->
                    <div class="form-group">
                        <label><span style="font-size:16px;">📝</span> Deskripsi</label>
                        <textarea name="description" class="form-input" rows="4" style="font-size:15px;">{{ old('description', $jenis->description) }}</textarea>
                        @error('description') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                <!-- Stok -->
                    <div class="form-group">
                        <label><span style="font-size:16px;">📦</span> Stok</label>
                        <input type="number" name="stock" class="form-input" value="{{ old('stock', $jenis->stock) }}" min="0" style="font-size:15px;">
                        @error('stock') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
            </div>

            <!-- Gambar -->
            <div class="form-section">
                <h2>Gambar Produk</h2>

                @if ($jenis->image)
                    <div class="current-image">
                        <p class="image-label">Gambar Saat Ini:</p>
                        <img src="{{ Storage::disk('public')->url($jenis->image) }}" alt="{{ $jenis->name }}" class="preview-image">
                        <p class="image-filename">{{ basename($jenis->image) }}</p>
                    </div>
                @endif

                <div class="form-group">
                    <label for="image" class="form-label">Unggah Gambar Baru (Opsional)</label>
                    <input 
                        type="file" 
                        id="image" 
                        name="image" 
                        class="form-control @error('image') is-invalid @enderror"
                        accept="image/*"
                        onchange="previewImage(event)"
                    >
                    <small class="form-text">Biarkan kosong jika ingin mempertahankan gambar lama. Format: JPG, PNG. Ukuran max: 2MB</small>
                    @error('image')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div id="image-preview-container" style="display: none;" class="image-preview-container">
                    <p class="image-label">Preview Gambar Baru:</p>
                    <img id="image-preview" src="" alt="Preview" class="preview-image">
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="form-actions">
                <a href="{{ route('dashboard.jenis.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<style>
    .edit-form-container {
        max-width: 600px;
        margin: 0 auto;
    }

    .form-card {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .form-section {
        margin-bottom: 30px;
    }

    .form-section h2 {
        font-size: 18px;
        font-weight: 600;
        color: #6b5b95;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e0d4f7;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .form-control {
        width: 100%;
        padding: 12px 14px;
        border: 2px solid #e0d4f7;
        border-radius: 8px;
        font-size: 14px;
        font-family: inherit;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #c7b7ff;
        background-color: #faf8ff;
        box-shadow: 0 0 0 3px rgba(199, 183, 255, 0.1);
    }

    .form-control.is-invalid {
        border-color: #e74c3c;
        background-color: #fef5f5;
    }

    .error-text {
        display: block;
        color: #e74c3c;
        font-size: 12px;
        margin-top: 5px;
    }

    .form-text {
        display: block;
        color: #999;
        font-size: 12px;
        margin-top: 6px;
    }

    .current-image,
    .image-preview-container {
        background: #f8f6ff;
        border: 2px dashed #c7b7ff;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        margin-bottom: 20px;
    }

    .image-label {
        font-weight: 600;
        color: #6b5b95;
        margin-bottom: 12px;
        font-size: 13px;
    }

    .preview-image {
        max-width: 100%;
        max-height: 300px;
        border-radius: 6px;
        object-fit: cover;
        border: 2px solid #c7b7ff;
    }

    .image-filename {
        color: #999;
        font-size: 12px;
        margin-top: 10px;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #e0d4f7;
    }

    .btn {
        padding: 10px 24px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-primary {
        background: linear-gradient(135deg, #c7b7ff 0%, #ffd6e0 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(199, 183, 255, 0.4);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(199, 183, 255, 0.5);
    }

    .btn-secondary {
        background: #f0f0f0;
        color: #333;
        border: 1px solid #e0e0e0;
    }

    .btn-secondary:hover {
        background: #e8e8e8;
    }

    .dashboard-container {
        padding: 30px;
    }

    .content-header {
        margin-bottom: 30px;
    }

    .content-header h1 {
        font-size: 28px;
        font-weight: 700;
        color: #333;
        margin: 0 0 8px 0;
    }

    .text-muted {
        color: #999;
        font-size: 14px;
        margin: 0;
    }
</style>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('image-preview');
                preview.src = e.target.result;
                document.getElementById('image-preview-container').style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
