<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - Edit Profil</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600&family=playfair-display:700&family=quicksand:300,400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .profile-header-content {
            text-align: center;
        }

        .profile-header h1 {
            margin-bottom: 5px;
        }

        .profile-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 16px;
            margin: 0;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: var(--color-text-dark);
            margin-bottom: 8px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-family: var(--font-body);
            font-size: 16px;
            color: var(--color-text-dark);
            transition: border-color 0.3s, box-shadow 0.3s;
            box-sizing: border-box;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--color-accent-strong);
            box-shadow: 0 0 0 3px rgba(237, 56, 120, 0.1);
        }

        .form-input-error {
            border-color: #dc3545;
        }

        .form-input:disabled,
        .form-input[readonly] {
            background-color: #f5f5f5;
            cursor: not-allowed;
        }

        .error-message {
            display: block;
            color: #dc3545;
            font-size: 13px;
            margin-top: 4px;
        }

        .form-hint {
            display: block;
            color: var(--color-text-light);
            font-size: 13px;
            margin-top: 6px;
            margin-bottom: 0;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #f0f0f0;
        }

        .btn-primary {
            background: var(--color-button-primary);
            color: white;
        }

        .btn-primary:hover {
            background: #9c7f66;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #e0e0e0;
            color: var(--color-text-dark);
        }

        .btn-secondary:hover {
            background: #d0d0d0;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .form-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
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
        <a href="{{ route('profile.show') }}" class="btn-back">
            ← Kembali ke Profil
        </a>
    </div>

    <div class="profile-header">
        <div class="profile-header-content">
            <h1>✏️ Edit Profil</h1>
            <p class="profile-subtitle">Perbarui informasi akun Anda</p>
        </div>
    </div>

    <div class="profile-container">
        <div class="profile-card">
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" id="name" name="name" class="form-input @error('name') form-input-error @enderror" value="{{ old('name', auth()->user()->name) }}" required>
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-input @error('email') form-input-error @enderror" value="{{ old('email', auth()->user()->email) }}" required>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="role" class="form-label">Role (Tidak Dapat Diubah)</label>
                    <input type="text" id="role" disabled class="form-input" value="{{ auth()->user()->role ?? 'Customer' }}" readonly>
                    <p class="form-hint">Role Anda ditentukan oleh administrator</p>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        💾 Simpan Perubahan
                    </button>
                    <a href="{{ route('profile.show') }}" class="btn btn-secondary">
                        ✗ Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
