@extends('dashboard.layout')

@section('content')
    <div class="dashboard-container">
        <div class="content-header">
            <h1>Edit Produk</h1>
            <p class="text-muted">Perbarui detail produk bunga Anda</p>
        </div>

        <div class="edit-form-container">
            <form action="{{ route('dashboard.jenis.update', $jenis->slug) }}" method="POST" enctype="multipart/form-data"
                class="form-card">
                @csrf
                @method('PUT')

                <div class="form-section">
                    <h2>Informasi Produk</h2>

                    <!-- Nama Produk -->
                    <div class="form-group">
                        <label><span style="font-size:16px;"></span> Nama Produk</label>
                        <input type="text" name="name" class="form-input" value="{{ old('name', $jenis->name) }}"
                            required style="font-size:15px;">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Harga -->
                    <div class="form-group">
                        <label><span style="font-size:16px;"></span> Harga (Rp)</label>
                        <input type="number" name="price" class="form-input" value="{{ old('price', $jenis->price) }}"
                            min="0" required style="font-size:15px;">
                        @error('price')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="form-group">
                        <label><span style="font-size:16px;"></span> Deskripsi</label>
                        <textarea name="description" class="form-input" rows="4" style="font-size:15px;">{{ old('description', $jenis->description) }}</textarea>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Stok -->
                    <div class="form-group">
                        <label><span style="font-size:16px;"></span> Stok</label>
                        <input type="number" name="stock" class="form-input" value="{{ old('stock', $jenis->stock) }}"
                            min="0" style="font-size:15px;">
                        @error('stock')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Gambar -->
                <div class="form-section">
                    <h2>Gambar Produk</h2>

                    @if ($jenis->image)
                        <div class="current-image">
                            <p class="image-label">Gambar Saat Ini:</p>
                            <img src="{{ asset($jenis->image) }}" alt="{{ $jenis->name }}"
                                class="preview-image">
                            <p class="image-filename">{{ basename($jenis->image) }}</p>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="image" class="form-label">Unggah Gambar Baru (Opsional)</label>
                        <input type="file" id="image" name="image"
                            class="form-control @error('image') is-invalid @enderror" accept="image/*"
                            onchange="previewImage(event); showFileName(event);">
                        <div id="file-name" style="margin-top:8px;color:#6f5f94;font-size:13px;">Tidak ada file dipilih
                        </div>
                        <small class="form-text">Biarkan kosong jika ingin mempertahankan gambar lama. Format: JPG, PNG.
                            Ukuran max: 2MB</small>
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
        /* Container utama */
        .edit-form-container {
            max-width: 920px;
            margin: 0 auto;
        }

        /* Ensure header stays above the form and content stacks vertically */
        .dashboard-container {
            display: block;
        }

        .content-header {
            margin-bottom: 18px;
        }

        .content-header h1 {
            margin: 0 0 6px 0;
            font-size: 30px;
            color: #2f2a4a;
        }

        .content-header .text-muted {
            margin: 0;
            color: #7a6aa6;
        }

        /* Card */
        .form-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 28px;
            box-shadow: 0 6px 20px rgba(120, 100, 170, 0.08);
        }

        /* Heading section */
        .form-section h2 {
            font-size: 18px;
            font-weight: 700;
            color: #6b4bbf;
            margin-bottom: 18px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e8ddff;
        }

        /* Layout field agar seperti form sebelumnya */
        .form-group {
            margin-bottom: 20px;
        }

        /* Label */
        .form-group label {
            font-weight: 600;
            font-size: 14px;
            color: #3a2c60;
            margin-bottom: 6px;
            display: block;
        }

        /* Input style MATCH seperti form sebelumnya */
        .form-input,
        .form-control,
        textarea.form-input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #e9e0fb;
            border-radius: 10px;
            font-size: 14px;
            background: #faf8ff;
            color: #2f2a4a;
            transition: all .2s ease;
            box-shadow: 0 2px 8px rgba(99, 72, 171, 0.05);
        }

        .form-input:focus,
        .form-control:focus {
            border-color: #bca6ff;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(178, 149, 255, 0.2);
            outline: none;
        }

        /* Error message */
        .error-text {
            color: #e74c3c;
            font-size: 12px;
            margin-top: 4px;
        }

        /* Gambar container */
        .current-image,
        .image-preview-container {
            background: #f7f3ff;
            border: 2px dashed #c7b7ff;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            text-align: center;
        }

        .preview-image {
            max-width: 100%;
            max-height: 260px;
            border-radius: 10px;
            border: 2px solid #e6ddff;
            object-fit: cover;
        }

        /* Tombol */
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 14px;
            padding-top: 20px;
            border-top: 1px solid #e8ddff;
        }

        .btn {
            padding: 10px 22px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: .2s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #bfa7ff, #ffbad7);
            color: white;
            box-shadow: 0 4px 12px rgba(175, 150, 255, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(175, 150, 255, 0.5);
        }

        .btn-secondary {
            background: #f2f2f2;
            border: 1px solid #ddd;
            color: #333;
        }

        .btn-secondary:hover {
            background: #e6e6e6;
        }

        /* TEXTAREA = sama tinggi */
        textarea.form-input {
            resize: vertical;
        }

        /* File input appearance fix (ensure button visible and usable) */
        input[type="file"].form-control {
            display: block;
            width: 100%;
            padding: 10px 12px;
            border-radius: 10px;
            border: 1px dashed #d8cfee;
            background: #fff;
            color: #5e4d8a;
        }

        .form-label {
            font-weight: 600;
        }

        /* Sidebar full height */
        .sidebar {
            height: 100vh !important;
            min-height: 100vh !important;
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

        function showFileName(event) {
            const el = document.getElementById('file-name');
            if (!el) return;
            const file = event.target.files && event.target.files[0];
            el.textContent = file ? file.name : 'Tidak ada file dipilih';
        }
    </script>
@endsection
