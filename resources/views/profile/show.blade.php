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
            --primary-color: #FFB5A7;
            --secondary-color: #FCD5CE;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --bg-light: #f9fafb;
            --border-color: #e5e7eb;
            --success-color: #10b981;
            --error-color: #ef4444;
        }

        .navbar {
            background: linear-gradient(135deg, var(--color-pastel-bliss-1) 0%, var(--color-pastel-bliss-2) 100%);
            color: white;
            padding: 12px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(237, 56, 120, 0.08);
            border-bottom: 1px solid rgba(255, 181, 167, 0.15);
            backdrop-filter: blur(8px);
            gap: 40px;
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .btn-back-navbar {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.2);
            border: 1.5px solid rgba(255, 255, 255, 0.4);
            border-radius: 24px;
            color: white;
            text-decoration: none;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 13px;
            white-space: nowrap;
        }

        .btn-back-navbar:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.6);
            transform: translateX(-3px);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            white-space: nowrap;
        }

        .navbar-logo {
            height: 35px;
            width: auto;
            flex-shrink: 0;
        }

        .navbar-brand-text {
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .navbar-nav {
            display: flex;
            gap: 35px;
            align-items: center;
            margin-left: auto;
        }

        .nav-link {
            color: white;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.3s ease;
            position: relative;
            font-size: 14px;
            padding: 6px 0;
            white-space: nowrap;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: rgba(255, 255, 255, 0.8);
            transition: width 0.3s ease;
        }

        .nav-link:hover {
            color: white;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .nav-link.active::after {
            width: 100%;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
            font-size: 14px;
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
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 50px;
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 40px;
        }

        /* Sidebar Styling */
        .profile-sidebar {
            background: white;
            border-radius: 12px;
            padding: 24px 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            height: fit-content;
            top: 100px;
            position: sticky;
        }

        .profile-sidebar-header {
            text-align: center;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .profile-photo-wrapper-sidebar {
            position: relative;
            width: 100px;
            height: 100px;
            margin: 0 auto 15px;
        }

        .profile-photo-sidebar {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--secondary-color);
        }

        .upload-photo-btn-sidebar {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--primary-color);
            border: 2px solid white;
            cursor: pointer;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .upload-photo-btn-sidebar:hover {
            transform: scale(1.15);
        }

        .profile-name {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 10px;
        }

        .role-badge-sidebar {
            display: inline-block;
            background: rgba(255, 181, 167, 0.2);
            color: var(--primary-color);
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .sidebar-menu-item {
            width: 100%;
            text-align: left;
            padding: 12px 16px;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            color: var(--text-dark);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 13px;
            white-space: nowrap;
        }

        .sidebar-menu-item:hover {
            background: #f9fafb;
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .sidebar-menu-item.active {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            border-color: var(--primary-color);
        }

        .sidebar-menu-item.logout:hover {
            background: #fee2e2;
            border-color: #ef4444;
            color: #ef4444;
        }

        /* Main Content */
        .profile-main {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .profile-tab {
            display: none;
        }

        .profile-tab.active {
            display: block;
        }

        .profile-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-label {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-light);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .form-input {
            padding: 12px 14px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.3s ease;
            background: #f9fafb;
        }

        .form-input:focus {
            outline: none;
            background: white;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(255, 181, 167, 0.1);
        }

        .radio-group {
            display: flex;
            gap: 20px;
        }

        .radio-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
        }

        .verified-badge {
            font-size: 12px;
            color: #10b981;
            font-weight: 700;
            margin-top: 4px;
        }

        .form-hint {
            font-size: 13px;
            color: var(--text-light);
            margin: 0;
        }

        .form-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 24px;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
        }

        .btn-secondary {
            background: white;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }

        .btn-secondary:hover {
            background: #f9fafb;
        }

        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                gap: 12px;
                padding: 12px 20px;
            }

            .navbar-left {
                width: 100%;
                justify-content: space-between;
            }

            .navbar-brand {
                gap: 8px;
            }

            .navbar-brand-text {
                font-size: 16px;
            }

            .navbar-nav {
                width: 100%;
                justify-content: space-around;
                gap: 15px;
                margin-left: 0;
            }

            .nav-link {
                font-size: 13px;
            }

            .profile-container {
                grid-template-columns: 1fr;
                padding: 20px;
                gap: 20px;
            }

            .profile-sidebar {
                position: static;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .profile-card {
                padding: 1.5rem;
            }

            .form-actions {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                gap: 12px;
                padding: 12px 20px;
            }

            .navbar-brand {
                gap: 8px;
                width: 100%;
            }

            .navbar-brand-text {
                font-size: 16px;
            }

            .navbar-nav {
                width: 100%;
                justify-content: space-around;
                gap: 15px;
                margin-left: 0;
            }

            .nav-link {
                font-size: 13px;
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

            .profile-container {
                padding: 0 20px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-left">
            <a href="/" class="btn-back-navbar">← Kembali</a>
            <div class="navbar-brand">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="navbar-logo" style="height: 35px; width: auto;">
                <span class="navbar-brand-text">Whispering Flora</span>
            </div>
        </div>
        <div class="navbar-nav">
            <a href="/" class="nav-link">🏠 Home</a>
            <a href="{{ route('profile.show') }}" class="nav-link active">👤 Profil</a>
            <a href="/cart" class="nav-link">🛍️ Keranjang</a>
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
        <!-- Sidebar -->
        <aside class="profile-sidebar">
            <div class="profile-sidebar-header">
                <div class="profile-photo-wrapper-sidebar">
                    <img src="{{ auth()->user()->profilePhotoUrl() }}" alt="{{ auth()->user()->name }}" class="profile-photo-sidebar">
                    <button class="upload-photo-btn-sidebar" onclick="document.getElementById('photo-upload').click()" title="Ubah Foto Profil">
                        📷
                    </button>
                    <form id="photo-form" method="POST" action="{{ route('profile.uploadPhoto') }}" enctype="multipart/form-data" style="display: none;">
                        @csrf
                        <input type="file" id="photo-upload" name="profile_photo" accept="image/*" onchange="document.getElementById('photo-form').submit()">
                    </form>
                </div>
                <h2 class="profile-name">{{ auth()->user()->name }}</h2>
                <div class="role-badge-sidebar">✨ {{ auth()->user()->role ?? 'Customer' }}</div>
            </div>

            <nav class="sidebar-nav">
                <button class="sidebar-menu-item active" onclick="showTab('personal')">
                    📋 Personal Information
                </button>
                <button class="sidebar-menu-item" onclick="showTab('security')">
                    🔐 Login & Password
                </button>
                <form method="POST" action="{{ route('logout') }}" style="width: 100%;">
                    @csrf
                    <button type="submit" class="sidebar-menu-item logout">
                        🚪 Log Out
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="profile-main">
            @if (session('success'))
                <div class="alert alert-success">✓ {{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">
                    ✗ Terjadi kesalahan: {{ $errors->first() }}
                </div>
            @endif

            <!-- Personal Information Tab -->
            <div id="personal" class="profile-tab active">
                <div class="profile-card">
                    <h3 class="section-title">Personal Information</h3>

                    <form method="POST" action="{{ route('profile.update') }}" class="profile-form">
                        @csrf
                        @method('PATCH')

                        <div class="form-row">
                            <div class="form-group">
                                <label for="gender" class="form-label">Gender</label>
                                <div class="radio-group">
                                    <label class="radio-label">
                                        <input type="radio" name="gender" value="male" checked> Male
                                    </label>
                                    <label class="radio-label">
                                        <input type="radio" name="gender" value="female"> Female
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="name" class="form-label">First Name</label>
                                <input type="text" id="name" name="name" class="form-input" value="{{ old('name', auth()->user()->name) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" id="last_name" name="last_name" class="form-input" value="{{ old('last_name', '') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-input" value="{{ old('email', auth()->user()->email) }}" required>
                            <span class="verified-badge">✓ Verified</span>
                        </div>

                        <div class="form-group">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" id="address" name="address" class="form-input" value="{{ old('address', '') }}" placeholder="Your address">
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" id="phone" name="phone" class="form-input" value="{{ old('phone', '') }}" placeholder="(555) 555-0128">
                            </div>
                            <div class="form-group">
                                <label for="date_of_birth" class="form-label">Date of Birth</label>
                                <input type="date" id="date_of_birth" name="date_of_birth" class="form-input" value="{{ old('date_of_birth', '') }}">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="location" class="form-label">Location</label>
                                <select id="location" name="location" class="form-input">
                                    <option selected>Atlanta, USA</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="postal_code" class="form-label">Postal Code</label>
                                <input type="text" id="postal_code" name="postal_code" class="form-input" value="{{ old('postal_code', '') }}" placeholder="30301">
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="reset" class="btn btn-secondary">Discard Changes</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Security Tab -->
            <div id="security" class="profile-tab">
                <div class="profile-card">
                    <h3 class="section-title">Login & Password</h3>
                    <p class="form-hint">Update your password to keep your account secure.</p>

                    <form method="POST" action="{{ route('password.update') }}" class="profile-form">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" id="current_password" name="current_password" class="form-input" required>
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" id="password" name="password" class="form-input" required>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required>
                        </div>

                        <div class="form-actions">
                            <button type="reset" class="btn btn-secondary">Discard Changes</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Tab switching functionality
        function showTab(tabName) {
            // Hide all tabs
            const tabs = document.querySelectorAll('.profile-tab');
            tabs.forEach(tab => tab.classList.remove('active'));

            // Remove active class from all menu items
            const menuItems = document.querySelectorAll('.sidebar-menu-item');
            menuItems.forEach(item => item.classList.remove('active'));

            // Show selected tab
            const selectedTab = document.getElementById(tabName);
            if (selectedTab) {
                selectedTab.classList.add('active');
            }

            // Add active class to clicked menu item
            event.target.classList.add('active');
        }
    </script>
</body>
</html>
