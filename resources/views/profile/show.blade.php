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
    <style>
        :root {
            --primary-color: #ec4899;
            --secondary-color: #f97316;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --bg-light: #f9fafb;
            --border-color: #e5e7eb;
            --success-color: #10b981;
            --error-color: #ef4444;
        }

        .navbar {
            background: linear-gradient(135deg, #ec4899 0%, #f97316 100%);
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border-radius: 0 0 12px 12px;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .navbar-nav {
            display: flex;
            gap: 2rem;
        }

        .navbar-nav a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem;
            border-radius: 6px;
        }

        .navbar-nav a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-error {
            background: #fee2e2;
            color: #7f1d1d;
            border: 1px solid #fecaca;
        }

        .profile-container {
            max-width: 900px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: white;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            color: var(--text-dark);
            text-decoration: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 2rem;
        }

        .btn-back:hover {
            background: var(--bg-light);
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .profile-header {
            background: linear-gradient(135deg, #ec4899 0%, #f97316 100%);
            padding: 3rem 2rem;
            border-radius: 16px;
            margin-bottom: 2rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            color: white;
        }

        .profile-header-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .profile-photo-wrapper {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .profile-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .upload-photo-btn {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            border: none;
            cursor: pointer;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .upload-photo-btn:hover {
            transform: scale(1.1);
        }

        .profile-header h1 {
            margin: 1rem 0 0.5rem;
            font-size: 2rem;
            font-weight: 700;
        }

        .role-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.875rem;
            border: 1px solid rgba(255, 255, 255, 0.4);
        }

        .profile-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--border-color);
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1.5rem;
        }

        .info-row {
            display: grid;
            grid-template-columns: 150px 1fr;
            gap: 2rem;
            padding: 1.25rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .info-row:last-of-type {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: var(--text-light);
            font-size: 0.875rem;
            text-transform: uppercase;
        }

        .info-value {
            color: var(--text-dark);
            font-size: 1rem;
            font-weight: 500;
        }

        .section-divider {
            height: 1px;
            background: var(--border-color);
            margin: 2rem 0;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
        }

        .btn-secondary {
            background: var(--bg-light);
            color: var(--text-dark);
            border: 2px solid var(--border-color);
        }

        .btn-secondary:hover {
            background: white;
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .btn-edit {
            background: var(--primary-color);
            color: white;
            width: 100%;
            justify-content: center;
        }

        .btn-edit:hover {
            background: #be185d;
        }

        .btn-logout {
            background: var(--error-color);
            color: white;
            width: 100%;
            justify-content: center;
        }

        .btn-logout:hover {
            background: #dc2626;
        }

        .profile-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            font-family: inherit;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1);
        }

        .form-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-top: 2rem;
        }

        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                gap: 1rem;
                padding: 1rem;
            }

            .navbar-nav {
                width: 100%;
                justify-content: space-around;
                gap: 0;
            }

            .profile-header {
                padding: 2rem 1rem;
            }

            .profile-header h1 {
                font-size: 1.5rem;
            }

            .profile-card {
                padding: 1.5rem;
            }

            .info-row {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }

            .profile-actions,
            .form-actions {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-brand">{{ config('app.name', 'Whispering Flora') }}</div>
        <div class="navbar-nav">
            <a href="/">🏠 Home</a>
            <a href="{{ route('profile.show') }}">👤 Profil</a>
            <a href="/cart">🛍️ Keranjang</a>
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
