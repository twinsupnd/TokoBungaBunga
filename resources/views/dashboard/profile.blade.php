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
        font-size: 28px;
        font-weight: 700;
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
        grid-template-columns: 280px 1fr;
        gap: 28px;
        margin-bottom: 40px;
    }

    .profile-sidebar {
        background: linear-gradient(135deg, #FFF8FB 0%, #FFFAFC 100%);
        border-radius: 14px;
        padding: 24px;
        box-shadow: 0 4px 12px rgba(199,183,255,0.08);
        border: 1px solid rgba(199,183,255,0.15);
        height: fit-content;
    }

    .profile-photo-wrapper {
        position: relative;
        width: 100px;
        height: 100px;
        margin: 0 auto 18px;
    }

    .profile-photo {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #C7B7FF;
        box-shadow: 0 4px 12px rgba(199,183,255,0.2);
    }

    .upload-photo-btn {
        position: absolute;
        bottom: -2px;
        right: -2px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #C7B7FF, #FFD6E0);
        border: 2px solid white;
        cursor: pointer;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(199,183,255,0.25);
    }

    .upload-photo-btn:hover {
        transform: scale(1.08);
        box-shadow: 0 4px 12px rgba(199,183,255,0.3);
    }

    .profile-name {
        font-size: 18px;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0 0 6px 0;
        text-align: center;
    }

    .profile-role {
        display: flex;
        justify-content: center;
        background: linear-gradient(135deg, rgba(199,183,255,0.2), rgba(255,214,224,0.2));
        color: #8B5A9E;
        padding: 5px 14px;
        border-radius: 16px;
        font-weight: 600;
        font-size: 11px;
        text-transform: uppercase;
        margin-bottom: 16px;
    }

    .profile-info-section {
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid rgba(199,183,255,0.15);
    }

    .profile-info-item {
        margin-bottom: 14px;
        font-size: 12px;
    }

    .profile-info-label {
        color: #8B5A9E;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 10px;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .profile-info-value {
        color: var(--text-dark);
        font-size: 13px;
        word-break: break-word;
        font-weight: 500;
    }

    .profile-main {
        background: white;
        border-radius: 14px;
        padding: 28px;
        box-shadow: 0 4px 12px rgba(199,183,255,0.08);
        border: 1px solid rgba(199,183,255,0.15);
    }

    .profile-main h2 {
        font-size: 20px;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0 0 28px 0;
        padding-bottom: 16px;
        border-bottom: 2px solid rgba(199,183,255,0.1);
    }

    .form-group {
        margin-bottom: 22px;
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
        padding: 11px 13px;
        border: 1.5px solid rgba(199,183,255,0.2);
        border-radius: 9px;
        font-size: 14px;
        font-family: inherit;
        background: white;
        color: var(--text-dark);
        transition: all 0.2s ease;
        box-sizing: border-box;
    }

    .form-input::placeholder,
    .form-textarea::placeholder {
        color: #9D8FB0;
    }

    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
        outline: none;
        border-color: #C7B7FF;
        box-shadow: 0 0 0 3px rgba(199,183,255,0.12);
        background: #FFFAFC;
    }

    .form-textarea {
        resize: vertical;
        min-height: 90px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    .radio-group {
        display: flex;
        gap: 22px;
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
        accent-color: #C7B7FF;
    }

    .btn-group {
        display: flex;
        gap: 12px;
        margin-top: 28px;
        padding-top: 20px;
        border-top: 1px solid rgba(199,183,255,0.1);
    }

    .btn {
        padding: 11px 28px;
        border: none;
        border-radius: 9px;
        font-weight: 700;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .btn-save {
        background: linear-gradient(135deg, #C7B7FF, #FFD6E0);
        color: white;
        flex: 1;
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(199,183,255,0.35);
    }

    .btn-cancel {
        background: white;
        color: #C7B7FF;
        border: 1.5px solid #C7B7FF;
        flex: 1;
    }

    .btn-cancel:hover {
        background: rgba(199,183,255,0.08);
    }

    .alert {
        padding: 14px 16px;
        border-radius: 9px;
        margin-bottom: 24px;
        border-left: 4px solid;
        font-size: 13px;
        font-weight: 500;
    }

    .alert-success {
        background: rgba(76,175,80,0.08);
        border-left-color: #4CAF50;
        color: #2e7d32;
    }

    .alert-error {
        background: rgba(239,68,68,0.08);
        border-left-color: #EF4444;
        color: #B91C1C;
    }

    .error-message {
        color: #DC2626;
        font-size: 12px;
        margin-top: 5px;
        font-weight: 500;
    }

    .file-input {
        display: none;
    }

    .verified-badge {
        color: #16A34A;
        font-size: 12px;
        margin-top: 5px;
        font-weight: 600;
    }

    @media (max-width: 1024px) {
        .profile-container {
            grid-template-columns: 1fr;
        }

        .profile-sidebar {
            display: grid;
            grid-template-columns: 100px auto 1fr;
            gap: 24px;
            align-items: start;
        }

        .profile-photo-wrapper {
            margin: 0;
        }

        .profile-name {
            text-align: left;
        }
    }

    @media (max-width: 600px) {
        .form-row {
            grid-template-columns: 1fr;
        }

        .btn-group {
            flex-direction: column;
        }

        .profile-sidebar {
            grid-template-columns: 1fr;
            text-align: center;
        }

        .profile-name {
            text-align: center;
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
                    <div class="verified-badge">✓ Terverifikasi</div>
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
                <a href="{{ route('dashboard.index') }}" class="btn btn-cancel" style="text-decoration: none; display: flex; align-items: center; justify-content: center;">Batal</a>
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
