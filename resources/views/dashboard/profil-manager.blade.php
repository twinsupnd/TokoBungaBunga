@extends('dashboard.layout')

@section('title', 'Profil Manager - ' . auth()->user()->name)

@section('content')

<style>
    * {
        box-sizing: border-box;
    }

    :root {
        --primary: #C7B7FF;
        --primary-dark: #8B5A9E;
        --secondary: #FFD6E0;
        --bg-light: #F8F6FF;
        --card-bg: white;
        --text-dark: #1F2937;
        --text-muted: #6B7280;
        --border: #E5E7EB;
    }

    .profil-header {
        margin-bottom: 28px;
    }

    .profil-header h1 {
        font-size: 28px;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0 0 6px 0;
    }

    .profil-header p {
        font-size: 14px;
        color: var(--text-muted);
        margin: 0;
    }

    .profil-container {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 24px;
    }

    .profil-sidebar {
        background: linear-gradient(135deg, #FFF8FB 0%, #FFFAFC 100%);
        border-radius: 12px;
        padding: 24px;
        border: 1px solid #F3E8FF;
        height: fit-content;
    }

    .profil-photo-wrapper {
        position: relative;
        width: 110px;
        height: 110px;
        margin: 0 auto 18px;
    }

    .profil-photo {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid var(--primary);
        box-shadow: 0 4px 12px rgba(199, 183, 255, 0.2);
        display: block;
    }

    .profil-photo-upload {
        position: absolute;
        inset: 0;
        border-radius: 50%;
        opacity: 0;
        cursor: pointer;
    }

    .upload-btn {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border: 2px solid white;
        cursor: pointer;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(199, 183, 255, 0.3);
        color: white;
    }

    .upload-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(199, 183, 255, 0.4);
    }

    .profil-name {
        font-size: 18px;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0 0 8px 0;
        text-align: center;
    }

    .profil-role {
        display: flex;
        justify-content: center;
        background: linear-gradient(135deg, rgba(199, 183, 255, 0.2), rgba(255, 214, 224, 0.2));
        color: var(--primary-dark);
        padding: 5px 14px;
        border-radius: 16px;
        font-weight: 600;
        font-size: 11px;
        text-transform: uppercase;
        margin-bottom: 16px;
    }

    .profil-info-section {
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid #F3E8FF;
    }

    .profil-info-item {
        margin-bottom: 14px;
    }

    .profil-info-label {
        font-size: 10px;
        font-weight: 700;
        color: var(--primary-dark);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .profil-info-value {
        font-size: 13px;
        color: var(--text-dark);
        font-weight: 500;
        word-break: break-word;
    }

    .profil-main {
        background: var(--card-bg);
        border-radius: 12px;
        padding: 28px;
        border: 1px solid var(--border);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .profil-main h2 {
        font-size: 20px;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0 0 24px 0;
        padding-bottom: 16px;
        border-bottom: 2px solid #F3E8FF;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        font-size: 13px;
        color: var(--text-dark);
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .form-input,
    .form-select,
    .form-textarea {
        width: 100%;
        padding: 10px 12px;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        font-size: 14px;
        font-family: inherit;
        background: white;
        color: var(--text-dark);
        transition: all 0.2s ease;
    }

    .form-input::placeholder,
    .form-textarea::placeholder {
        color: #D1D5DB;
    }

    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(199, 183, 255, 0.1);
        background: #FFFAFC;
    }

    .form-textarea {
        resize: vertical;
        min-height: 100px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .radio-group {
        display: flex;
        gap: 24px;
        margin-top: 8px;
    }

    .radio-label {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        font-weight: 500;
        font-size: 14px;
        color: var(--text-dark);
    }

    .radio-label input[type="radio"] {
        cursor: pointer;
        width: 16px;
        height: 16px;
        accent-color: var(--primary);
    }

    .btn-group {
        display: flex;
        gap: 12px;
        margin-top: 28px;
        padding-top: 20px;
        border-top: 1px solid #F3E8FF;
    }

    .btn {
        padding: 11px 28px;
        border: none;
        border-radius: 8px;
        font-weight: 700;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .btn-save {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        flex: 1;
        box-shadow: 0 2px 8px rgba(199, 183, 255, 0.2);
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(199, 183, 255, 0.3);
    }

    .btn-cancel {
        background: white;
        color: var(--primary);
        border: 1.5px solid var(--primary);
        flex: 1;
    }

    .btn-cancel:hover {
        background: #FFF8FB;
    }

    .alert {
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        border-left: 4px solid;
        font-size: 13px;
        font-weight: 500;
    }

    .alert-success {
        background: #ECFDF5;
        border-left-color: #10B981;
        color: #047857;
    }

    .alert-error {
        background: #FEF2F2;
        border-left-color: #EF4444;
        color: #DC2626;
    }

    .error-message {
        color: #DC2626;
        font-size: 12px;
        margin-top: 5px;
        font-weight: 500;
    }

    .verified-badge {
        color: #059669;
        font-size: 12px;
        margin-top: 5px;
        font-weight: 600;
    }

    @media (max-width: 1024px) {
        .profil-container {
            grid-template-columns: 1fr;
        }

        .profil-sidebar {
            display: grid;
            grid-template-columns: 110px 1fr;
            gap: 20px;
            align-items: start;
        }

        .profil-photo-wrapper {
            margin: 0;
        }
    }

    @media (max-width: 600px) {
        .form-row {
            grid-template-columns: 1fr;
        }

        .btn-group {
            flex-direction: column;
        }

        .profil-main {
            padding: 20px;
        }

        .profil-header h1 {
            font-size: 24px;
        }
    }
</style>

<div class="profil-header">
    <h1>👔 Profil Manager</h1>
    <p>Kelola informasi pribadi dan pengaturan akun manager Anda</p>
</div>

@if(session('success'))
    <div class="alert alert-success">
        ✓ {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-error">
        ✗ {{ $errors->first() }}
    </div>
@endif

<div class="profil-container">
    <!-- Sidebar -->
    <div class="profil-sidebar">
        <div class="profil-photo-wrapper">
            <img src="{{ auth()->user()->profilePhotoUrl() }}" alt="{{ auth()->user()->name }}" class="profil-photo">
            <input type="file" id="photo-upload" class="profil-photo-upload" accept="image/*">
            <button class="upload-btn" onclick="document.getElementById('photo-upload').click()" title="Ubah Foto Profil">📷</button>
            <form id="photo-form" method="POST" action="{{ route('profile.uploadPhoto') }}" enctype="multipart/form-data" style="display: none;">
                @csrf
                <input type="file" name="profile_photo" id="photo-form-input" accept="image/*">
            </form>
        </div>

        <div>
            <h3 class="profil-name">{{ auth()->user()->name }}</h3>
            <div class="profil-role">👔 Manager</div>

            <div class="profil-info-section">
                <div class="profil-info-item">
                    <div class="profil-info-label">📧 Email</div>
                    <div class="profil-info-value">{{ auth()->user()->email }}</div>
                </div>
                <div class="profil-info-item">
                    <div class="profil-info-label">📅 Bergabung</div>
                    <div class="profil-info-value">{{ auth()->user()->created_at->format('d M Y') }}</div>
                </div>
                @if(auth()->user()->phone)
                    <div class="profil-info-item">
                        <div class="profil-info-label">📱 Telepon</div>
                        <div class="profil-info-value">{{ auth()->user()->phone }}</div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="profil-main">
        <h2>Informasi Pribadi Manager</h2>

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label>Jenis Kelamin</label>
                <div class="radio-group">
                    <label class="radio-label">
                        <input type="radio" name="gender" value="male" {{ old('gender', auth()->user()->gender ?? 'male') === 'male' ? 'checked' : '' }}>
                        Laki-laki
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="gender" value="female" {{ old('gender', auth()->user()->gender ?? '') === 'female' ? 'checked' : '' }}>
                        Perempuan
                    </label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Nama Depan</label>
                    <input 
                        type="text" 
                        name="name" 
                        class="form-input" 
                        value="{{ old('name', auth()->user()->name) }}"
                        required
                    >
                    @error('name') <div class="error-message">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>Nama Belakang</label>
                    <input 
                        type="text" 
                        name="last_name" 
                        class="form-input" 
                        value="{{ old('last_name', auth()->user()->last_name ?? '') }}"
                    >
                    @error('last_name') <div class="error-message">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input 
                    type="email" 
                    name="email" 
                    class="form-input" 
                    value="{{ old('email', auth()->user()->email) }}"
                    required
                >
                @error('email') <div class="error-message">{{ $message }}</div> @enderror
                @if(auth()->user()->email_verified_at)
                    <div class="verified-badge">✓ Terverifikasi</div>
                @endif
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Nomor Telepon</label>
                    <input 
                        type="tel" 
                        name="phone" 
                        class="form-input" 
                        placeholder="(+62) 812-3456-7890"
                        value="{{ old('phone', auth()->user()->phone ?? '') }}"
                    >
                    @error('phone') <div class="error-message">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input 
                        type="date" 
                        name="date_of_birth" 
                        class="form-input"
                        value="{{ old('date_of_birth', auth()->user()->date_of_birth ?? '') }}"
                    >
                    @error('date_of_birth') <div class="error-message">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-group">
                <label>Alamat</label>
                <input 
                    type="text" 
                    name="address" 
                    class="form-input" 
                    placeholder="Jalan, Nomor, Kota"
                    value="{{ old('address', auth()->user()->address ?? '') }}"
                >
                @error('address') <div class="error-message">{{ $message }}</div> @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Kota/Lokasi</label>
                    <input 
                        type="text" 
                        name="location" 
                        class="form-input" 
                        placeholder="Jakarta, Indonesia"
                        value="{{ old('location', auth()->user()->location ?? '') }}"
                    >
                    @error('location') <div class="error-message">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>Kode Pos</label>
                    <input 
                        type="text" 
                        name="postal_code" 
                        class="form-input" 
                        placeholder="12345"
                        value="{{ old('postal_code', auth()->user()->postal_code ?? '') }}"
                    >
                    @error('postal_code') <div class="error-message">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-save">💾 Simpan Perubahan</button>
                <a href="{{ route('dashboard') }}" class="btn btn-cancel" style="text-decoration: none; display: flex; align-items: center; justify-content: center;">✕ Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('photo-upload').addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            // Preview foto
            const reader = new FileReader();
            reader.onload = (event) => {
                document.querySelector('.profil-photo').src = event.target.result;
            };
            reader.readAsDataURL(e.target.files[0]);

            // Submit form
            const formInput = document.getElementById('photo-form-input');
            formInput.files = e.target.files;
            document.getElementById('photo-form').submit();
        }
    });
</script>

@endsection
