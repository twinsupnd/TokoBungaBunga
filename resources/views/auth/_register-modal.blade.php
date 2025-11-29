@php
    $registerRoute = route('register');
@endphp

<style>
    /* Modal overlay dan box styling - sinkron dengan dashboard */
    .register-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.55);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        padding: 20px;
    }

    .register-modal-box {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        max-width: 500px;
        width: 100%;
        overflow: hidden;
        position: relative;
    }

    .register-modal-close {
        position: absolute;
        right: 18px;
        top: 14px;
        background: transparent;
        border: none;
        font-size: 28px;
        line-height: 1;
        color: rgba(255, 255, 255, 0.9);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .register-modal-close:hover {
        color: white;
        transform: rotate(90deg);
    }

    .register-modal-header {
        background: linear-gradient(135deg, var(--color-pastel-bliss-1) 0%, var(--color-pastel-bliss-2) 100%);
        padding: 2rem 1.5rem;
        text-align: center;
        color: white;
    }

    .register-modal-header h2 {
        font-size: 1.75rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        font-family: 'Playfair Display', serif;
    }

    .register-modal-header p {
        font-size: 0.875rem;
        opacity: 0.95;
        margin: 0;
    }

    .register-modal-body {
        padding: 2rem 1.5rem;
    }

    .register-form-group {
        margin-bottom: 1.25rem;
    }

    .register-form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: #5A4B4B;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .register-form-input {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid #FCD5CE;
        border-radius: 8px;
        font-size: 1rem;
        font-family: inherit;
        transition: all 0.3s ease;
        background: #fff;
    }

    .register-form-input:focus {
        outline: none;
        border-color: var(--color-pastel-bliss-1);
        box-shadow: 0 0 0 3px rgba(255, 181, 167, 0.15);
    }

    .register-form-input::placeholder {
        color: #B2A19E;
    }

    .register-error-message {
        display: block;
        color: #ED3878;
        font-size: 0.75rem;
        margin-top: 0.25rem;
        font-weight: 500;
    }

    .register-submit-button {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, var(--color-pastel-bliss-1) 0%, var(--color-pastel-bliss-2) 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 1.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .register-submit-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(255, 181, 167, 0.3);
    }

    .register-submit-button:active {
        transform: translateY(0);
    }

    .register-login-link {
        text-align: center;
        margin-top: 1.5rem;
        font-size: 0.875rem;
        color: #8C7878;
    }

    .register-login-link a {
        color: var(--color-pastel-bliss-1);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .register-login-link a:hover {
        color: var(--color-accent-strong);
    }

    @media (max-width: 480px) {
        .register-modal-header {
            padding: 1.5rem 1rem;
        }

        .register-modal-header h2 {
            font-size: 1.5rem;
        }

        .register-modal-body {
            padding: 1.5rem 1rem;
        }

        .register-form-group {
            margin-bottom: 1rem;
        }
    }
</style>

<div class="register-modal-overlay" id="register-modal" role="dialog" aria-modal="true" style="display:none;">
    <div class="register-modal-box" role="document">
        <button class="register-modal-close" aria-label="Close" onclick="closeRegisterModal()">&times;</button>

        <div class="register-modal-header">
            <h2>🌸 Daftar</h2>
            <p>Bergabunglah dengan Toko Bunga kami</p>
        </div>

        <div class="register-modal-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="register-form-group">
                    <label for="register-name" class="register-form-label">Nama Lengkap</label>
                    <input
                        id="register-name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Masukkan nama Anda"
                        required
                        autofocus
                        autocomplete="name"
                        class="register-form-input"
                    >
                    @error('name')
                        <span class="register-error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="register-form-group">
                    <label for="register-email" class="register-form-label">Email</label>
                    <input
                        id="register-email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Masukkan email Anda"
                        required
                        autocomplete="email"
                        class="register-form-input"
                    >
                    @error('email')
                        <span class="register-error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="register-form-group">
                    <label for="register-password" class="register-form-label">Password</label>
                    <input
                        id="register-password"
                        type="password"
                        name="password"
                        placeholder="Minimal 8 karakter"
                        required
                        autocomplete="new-password"
                        class="register-form-input"
                    >
                    @error('password')
                        <span class="register-error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="register-form-group">
                    <label for="register-password-confirm" class="register-form-label">Konfirmasi Password</label>
                    <input
                        id="register-password-confirm"
                        type="password"
                        name="password_confirmation"
                        placeholder="Ulangi password Anda"
                        required
                        autocomplete="new-password"
                        class="register-form-input"
                    >
                    @error('password_confirmation')
                        <span class="register-error-message">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="register-submit-button">
                    Daftar Sekarang
                </button>
            </form>

            <div class="register-login-link">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
            </div>
        </div>
    </div>
</div>

<script>
    function openRegisterModal() {
        document.getElementById('register-modal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeRegisterModal() {
        document.getElementById('register-modal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // Close modal jika klik overlay
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('register-modal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeRegisterModal();
                }
            });
        }
    });

    // Close modal dengan ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeRegisterModal();
        }
    });
</script>
