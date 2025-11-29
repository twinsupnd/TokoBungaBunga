<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - Profil</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600&family=playfair-display:700&family=quicksand:300,400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <nav class="navbar">
        <div class="navbar-brand">{{ config('app.name', 'Whispering Flora') }}</div>
        <div class="navbar-nav">
            <a href="/">🏠 Home</a>
            <a href="{{ route('profile.show') }}">👤 Profil</a>
            <a href="{{ route('cart.index') }}">🛍️ Keranjang</a>
        </div>
    </nav>

    @if (session('success'))
        <div class="profile-container">
            <div class="alert alert-success">✓ {{ session('success') }}</div>
        </div>
    @endif

    @if ($errors->any())
        <div class="profile-container">
            <div class="alert alert-error">
                ✗ Terjadi kesalahan: {{ $errors->first() }}
            </div>
        </div>
    @endif

    <div class="profile-container">
        <a href="/" class="btn-back">
            ← Kembali
        </a>
    </div>

    <div class="profile-header">
        <div class="profile-header-content">
            <div class="profile-photo-wrapper">
                <img src="{{ auth()->user()->profilePhotoUrl() }}" alt="{{ auth()->user()->name }}" class="profile-photo">
                <button class="upload-photo-btn" onclick="document.getElementById('photo-upload').click()" title="Ubah Foto Profil">
                    📷
                </button>
                <form id="photo-form" method="POST" action="{{ route('profile.uploadPhoto') }}" enctype="multipart/form-data" style="display: none;">
                    @csrf
                    <input type="file" id="photo-upload" name="profile_photo" accept="image/*" onchange="document.getElementById('photo-form').submit()">
                </form>
            </div>
            <h1>{{ auth()->user()->name }}</h1>
            <div class="role-badge">✨ {{ auth()->user()->role ?? 'Customer' }}</div>
        </div>
    </div>

    <div class="profile-container">
        <div class="profile-card">
            <div class="section-title">📋 Informasi Profil</div>

            <div class="info-row">
                <div class="info-label">Nama / Username</div>
                <div class="info-value">{{ auth()->user()->name }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Email</div>
                <div class="info-value">{{ auth()->user()->email }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Role</div>
                <div class="info-value text-capitalize">{{ auth()->user()->role ?? 'Customer' }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Member Sejak</div>
                <div class="info-value">{{ auth()->user()->created_at->format('d M Y') }}</div>
            </div>

            @if(auth()->user()->role === 'admin' && auth()->user()->promoted_to_admin_at)
                <div class="info-row">
                    <div class="info-label">Menjadi Admin Sejak</div>
                    <div class="info-value">{{ auth()->user()->promoted_to_admin_at->format('d M Y H:i') }}</div>
                </div>
            @endif

            <div class="section-divider"></div>

            <div id="profile-view">
                <div class="profile-actions">
                    <button id="btn-edit-profile" class="btn btn-edit">✏️ Edit Profil</button>
                    <form method="POST" action="{{ route('logout') }}" style="flex: 1;">
                        @csrf
                        <button type="submit" class="btn btn-logout" style="width: 100%; margin: 0;">🚪 Logout</button>
                    </form>
                </div>
            </div>

            <div id="profile-edit" style="display: none;">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" id="name" name="name" class="form-input" value="{{ old('name', auth()->user()->name) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-input" value="{{ old('email', auth()->user()->email) }}" required>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
                        <button type="button" id="btn-cancel-edit" class="btn btn-secondary">✗ Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Toggle edit/view for inline profile editing
        const btnEdit = document.getElementById('btn-edit-profile');
        const profileView = document.getElementById('profile-view');
        const profileEdit = document.getElementById('profile-edit');
        const btnCancel = document.getElementById('btn-cancel-edit');

        if (btnEdit) {
            btnEdit.addEventListener('click', (e) => {
                e.preventDefault();
                profileView.style.display = 'none';
                profileEdit.style.display = 'block';
                // focus first input
                const firstInput = profileEdit.querySelector('input');
                if (firstInput) firstInput.focus();
            });
        }

        if (btnCancel) {
            btnCancel.addEventListener('click', (e) => {
                e.preventDefault();
                profileEdit.style.display = 'none';
                profileView.style.display = 'block';
            });
        }
    </script>
</body>
</html>
