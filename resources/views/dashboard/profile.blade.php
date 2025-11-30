@extends('dashboard.layout')

@section('title', 'Profil - ' . auth()->user()->name)

@section('content')

<style>
    :root {
        --primary: #C7B7FF;
        --secondary: #FFD6E0;
        --accent-light: #FFF8FB;
        --bg-light: #F8F6FF;
        --text-dark: #22223B;
        --text-muted: #7B7B8B;
        --border-light: rgba(199,183,255,0.1);
        --shadow: 0 8px 20px rgba(34,34,59,0.04);
        --shadow-hover: 0 12px 24px rgba(199,183,255,0.15);
    }

    .profile-header {
        margin-bottom: 32px;
    }

    .profile-header h1 {
        font-size: 32px;
        font-weight: 800;
        color: var(--text-dark);
        margin: 0 0 8px 0;
    }

    .profile-header p {
        font-size: 14px;
        color: var(--text-muted);
        margin: 0;
    }

    .profile-container {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 32px;
        margin-bottom: 40px;
    }

    .profile-sidebar {
        background: var(--accent-light);
        border-radius: 16px;
        padding: 32px;
        box-shadow: var(--shadow);
        border: 1px solid var(--border-light);
        height: fit-content;
        position: sticky;
        top: 28px;
    }

    .profile-photo-wrapper {
        position: relative;
        width: 120px;
        height: 120px;
        margin: 0 auto 20px;
    }

    .profile-photo {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--primary);
        box-shadow: 0 4px 12px rgba(199,183,255,0.2);
    }

    .upload-photo-btn {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border: 3px solid white;
        cursor: pointer;
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(199,183,255,0.25);
    }

    .upload-photo-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 16px rgba(199,183,255,0.3);
    }

    .profile-name {
        font-size: 20px;
        font-weight: 800;
        color: var(--text-dark);
        margin: 0 0 8px 0;
        text-align: center;
    }

    .profile-role {
        display: inline-flex;
        margin: 0 auto;
        background: linear-gradient(135deg, rgba(199,183,255,0.15), rgba(255,214,224,0.15));
        color: var(--primary);
        padding: 6px 16px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 12px;
        text-transform: uppercase;
    }

    .profile-info-section {
        margin-top: 24px;
        padding-top: 24px;
        border-top: 1px solid var(--border-light);
    }

    .profile-info-item {
        margin-bottom: 12px;
        font-size: 13px;
    }

    .profile-info-label {
        color: var(--text-muted);
        font-weight: 700;
    }

    .profile-info-value {
        color: var(--text-dark);
        margin-top: 4px;
        word-break: break-all;
    }

    .profile-main {
        background: var(--accent-light);
        border-radius: 16px;
        padding: 32px;
        box-shadow: var(--shadow);
        border: 1px solid var(--border-light);
    }

    .profile-main h2 {
        font-size: 20px;
        font-weight: 800;
        color: var(--text-dark);
        margin: 0 0 24px 0;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-weight: 700;
        font-size: 14px;
        color: var(--text-dark);
        margin-bottom: 10px;
    }

    .form-input,
    .form-select,
    .form-textarea {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid rgba(199,183,255,0.2);
        border-radius: 10px;
        font-size: 14px;
        font-family: inherit;
        background: white;
        color: var(--text-dark);
        transition: all 0.2s ease;
        box-sizing: border-box;
    }

    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(199,183,255,0.1);
        background: #faf8ff;
    }

    .form-textarea {
        resize: vertical;
        min-height: 100px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .radio-group {
        display: flex;
        gap: 20px;
        margin-top: 10px;
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
    }

    .btn-group {
        display: flex;
        gap: 12px;
        margin-top: 28px;
        padding-top: 20px;
        border-top: 1px solid var(--border-light);
    }

    .btn {
        padding: 12px 24px;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-save {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        flex: 1;
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(199,183,255,0.3);
    }

    .btn-cancel {
        background: white;
        color: var(--primary);
        border: 2px solid var(--primary);
        flex: 1;
    }

    .btn-cancel:hover {
        background: rgba(199,183,255,0.05);
    }

    .alert {
        padding: 14px 18px;
        border-radius: 10px;
        margin-bottom: 24px;
        border: 1px solid;
    }

    .alert-success {
        background: rgba(76,175,80,0.1);
        border-color: rgba(76,175,80,0.3);
        color: #2e7d32;
    }

    .alert-error {
        background: rgba(255,107,107,0.1);
        border-color: rgba(255,107,107,0.3);
        color: #FF6B6B;
    }

    .error-message {
        color: #FF6B6B;
        font-size: 13px;
        margin-top: 6px;
    }

    .file-input {
        display: none;
    }

    @media (max-width: 1024px) {
        .profile-container {
            grid-template-columns: 1fr;
        }

        .profile-sidebar {
            position: relative;
            top: 0;
        }
    }

    @media (max-width: 600px) {
        .form-row {
            grid-template-columns: 1fr;
        }

        .btn-group {
            flex-direction: column;
        }
    }
</style>

<div class="profile-header">
    <h1>Profil Saya</h1>
    <p>Kelola Informasi Pribadi dan Pengaturan Akun Anda</p>
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

<div class="profile-container">
    <!-- Sidebar -->
    <div class="profile-sidebar">
        <div class="profile-photo-wrapper">
            <img src="{{ auth()->user()->profilePhotoUrl() }}" alt="{{ auth()->user()->name }}" class="profile-photo">
            <button class="upload-photo-btn" onclick="document.getElementById('photo-upload').click()" title="Ubah Foto Profil">
                📷
            </button>
            <form id="photo-form" method="POST" action="{{ route('profile.uploadPhoto') }}" enctype="multipart/form-data" style="display: none;">
                @csrf
                <input type="file" id="photo-upload" name="profile_photo" accept="image/*" onchange="submitPhotoForm()">
            </form>
        </div>

        <h3 class="profile-name">{{ auth()->user()->name }}</h3>
        <div style="text-align: center;">
            <div class="profile-role">{{ auth()->user()->role ?? 'User' }}</div>
        </div>

        <div class="profile-info-section">
            <div class="profile-info-item">
                <div class="profile-info-label">EMAIL</div>
                <div class="profile-info-value">{{ auth()->user()->email }}</div>
            </div>
            <div class="profile-info-item" style="margin-top: 16px;">
                <div class="profile-info-label">BERGABUNG</div>
                <div class="profile-info-value">{{ auth()->user()->created_at->format('d M Y') }}</div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="profile-main">
        <h2>Informasi Pribadi</h2>

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label>Gender</label>
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
                    <label for="name">Nama Depan :</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        class="form-input" 
                        value="{{ old('name', auth()->user()->name) }}"
                        required
                    >
                    @error('name') <div class="error-message">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="last_name">Nama Belakang :</label>
                    <input 
                        type="text" 
                        id="last_name" 
                        name="last_name" 
                        class="form-input" 
                        value="{{ old('last_name', auth()->user()->last_name ?? '') }}"
                    >
                    @error('last_name') <div class="error-message">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email :</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-input" 
                    value="{{ old('email', auth()->user()->email) }}"
                    required
                >
                @error('email') <div class="error-message">{{ $message }}</div> @enderror
                @if(auth()->user()->email_verified_at)
                    <div style="color: #2e7d32; font-size: 13px; margin-top: 6px;">✓ Terverifikasi</div>
                @endif
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="phone">Nomor Telepon :</label>
                    <input 
                        type="tel" 
                        id="phone" 
                        name="phone" 
                        class="form-input" 
                        placeholder="(+62) 812-3456-7890"
                        value="{{ old('phone', auth()->user()->phone ?? '') }}"
                    >
                    @error('phone') <div class="error-message">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="date_of_birth">Tanggal Lahir :</label>
                    <input 
                        type="date" 
                        id="date_of_birth" 
                        name="date_of_birth" 
                        class="form-input"
                        value="{{ old('date_of_birth', auth()->user()->date_of_birth ?? '') }}"
                    >
                    @error('date_of_birth') <div class="error-message">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="address">Alamat :</label>
                <input 
                    type="text" 
                    id="address" 
                    name="address" 
                    class="form-input" 
                    placeholder="Jalan, Nomor, Kota"
                    value="{{ old('address', auth()->user()->address ?? '') }}"
                >
                @error('address') <div class="error-message">{{ $message }}</div> @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="location">Kota/Lokasi :</label>
                    <input 
                        type="text" 
                        id="location" 
                        name="location" 
                        class="form-input" 
                        placeholder="Jakarta, Indonesia"
                        value="{{ old('location', auth()->user()->location ?? '') }}"
                    >
                    @error('location') <div class="error-message">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="postal_code">Kode Pos :</label>
                    <input 
                        type="text" 
                        id="postal_code" 
                        name="postal_code" 
                        class="form-input" 
                        placeholder="12345"
                        value="{{ old('postal_code', auth()->user()->postal_code ?? '') }}"
                    >
                    @error('postal_code') <div class="error-message">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-save">Simpan Perubahan</button>
                <a href="{{ route('dashboard.index') }}" class="btn btn-cancel" style="text-decoration: none; display: flex; align-items: center; justify-content: center;">✕ Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
    function submitPhotoForm() {
        document.getElementById('photo-form').submit();
    }
</script>

@endsection
