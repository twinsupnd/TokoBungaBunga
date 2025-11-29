@php
    $registerRoute = route('register');
@endphp

<style>
    /* Modal overlay and box */
    .modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,0.55);display:flex;align-items:center;justify-content:center;z-index:1000;padding:20px}
    .modal-box{background:#fff;border-radius:16px;box-shadow:0 18px 40px rgba(0,0,0,.35);max-width:980px;width:100%;overflow:hidden;position:relative}
    .modal-close{position:absolute;right:18px;top:14px;background:transparent;border:none;font-size:26px;line-height:1;color:#666;cursor:pointer;transition:all 0.3s}
    .modal-close:hover{color:#FFB5A7;transform:rotate(90deg)}

    .auth-wrapper{display:flex;flex-direction:row;background:linear-gradient(135deg, rgba(255,181,167,0.05) 0%, rgba(254,200,154,0.05) 100%)}
    .auth-column{width:50%;box-sizing:border-box;padding:40px}
    .login-column{background:linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(248,237,235,0.95) 100%)}
    .register-column{border-left:1px solid #FCD5CE;background:linear-gradient(135deg, rgba(255,255,255,0.98) 0%, rgba(253,213,206,0.95) 100%)}
    .column-title{color:#ED3878;font-size:22px;font-weight:700;margin:0 0 18px;letter-spacing:0.5px}

    .form-group{margin-bottom:18px}
    .form-group label{display:block;margin-bottom:8px;color:#5A4B4B;font-weight:600;font-size:12px;text-transform:uppercase}
    .form-input{width:100%;padding:12px;border:2px solid #FCD5CE;background:#fff;border-radius:8px;transition:all 0.3s;font-size:14px}
    .form-input:focus{outline:none;border-color:#FFB5A7;box-shadow:0 0 0 3px rgba(255,181,167,0.15)}
    .form-checkbox{width:16px;height:16px;margin-right:8px;accent-color:#ED3878}
    .checkbox-group{display:flex;align-items:center;gap:8px}

    .auth-button{display:inline-block;padding:12px 20px;border:none;border-radius:8px;cursor:pointer;margin-top:8px;font-weight:700;transition:all 0.3s;text-transform:uppercase;font-size:13px;letter-spacing:0.5px}
    .login-button{background:linear-gradient(135deg, #FFB5A7 0%, #FCD5CE 100%);color:#fff;box-shadow:0 4px 15px rgba(255,181,167,0.3)}
    .login-button:hover{transform:translateY(-2px);box-shadow:0 8px 25px rgba(237,56,120,0.4)}
    .register-button{background:linear-gradient(135deg, #FFB5A7 0%, #FCD5CE 100%);color:#fff;box-shadow:0 4px 15px rgba(255,181,167,0.3)}
    .register-button:hover{transform:translateY(-2px);box-shadow:0 8px 25px rgba(237,56,120,0.4)}
    .forgot-password-link{display:block;margin-top:12px;color:#ED3878;font-weight:600;transition:color 0.3s}
    .forgot-password-link:hover{color:#FFB5A7}
    .privacy-text{color:#8C7878;font-size:12px;line-height:1.5}
    .privacy-link{color:#ED3878;font-weight:600}

    @media (max-width:800px){
        .auth-wrapper{flex-direction:column}
        .auth-column{width:100%;padding:24px}
        .register-column{border-left:none;border-top:1px solid #FCD5CE}
    }
</style>

<div class="modal-overlay" id="auth-modal" role="dialog" aria-modal="true" style="display:none;">
    <div class="modal-box" role="document">
        <button class="modal-close" aria-label="Close">&times;</button>

        <div class="auth-wrapper">
            <div class="auth-column login-column">
                <h1 class="column-title">LOGIN</h1>

                <form class="auth-form" id="signin-form" method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="signin-email">Username or email address *</label>
                        <input id="signin-email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="form-input">
                        @error('email') <span class="text-danger error-message">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="signin-password">Password *</label>
                        <input id="signin-password" type="password" name="password" required autocomplete="current-password" class="form-input">
                        @error('password') <span class="text-danger error-message">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group checkbox-group">
                        <input id="remember_me" type="checkbox" name="remember" class="form-checkbox">
                        <label for="remember_me" class="checkbox-label">Remember me</label>
                    </div>

                    <button type="submit" class="auth-button login-button">LOG IN</button>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-password-link">Lost your password?</a>
                    @endif
                </form>
            </div>

            <div class="auth-column register-column">
                <h1 class="column-title">REGISTER</h1>

                <form class="auth-form" id="signup-form" method="POST" action="{{ $registerRoute }}">
                    @csrf

                    <div class="form-group">
                        <label for="signup-email">Email address *</label>
                        <input id="signup-email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" class="form-input">
                        @error('email') <span class="text-danger error-message">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="signup-password">Password *</label>
                        <input id="signup-password" type="password" name="password" required autocomplete="new-password" class="form-input">
                        @error('password') <span class="text-danger error-message">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group checkbox-group">
                        <input id="newsletter" type="checkbox" name="newsletter" class="form-checkbox" checked>
                        <label for="newsletter" class="checkbox-label">Berlangganan newsletter</label>
                    </div>

                    <p class="privacy-text">Dengan melakukan pendaftaran, berarti kamu telah membaca dan menyetujui <a href="#" class="privacy-link">privacy policy.</a></p>

                    <button type="submit" class="auth-button register-button">REGISTER</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    (function(){
        function openAuthModal(){
            var overlay = document.getElementById('auth-modal');
            if(!overlay) return;
            overlay.style.display = 'flex';
            // focus first input
            var e = overlay.querySelector('input[type="email"]'); if(e) e.focus();
        }
        function closeAuthModal(){
            var overlay = document.getElementById('auth-modal');
            if(!overlay) return;
            overlay.style.display = 'none';
        }

        document.addEventListener('DOMContentLoaded', function(){
            // open modal when elements with `.open-auth-modal` are clicked
            document.querySelectorAll('.open-auth-modal').forEach(function(btn){
                btn.addEventListener('click', function(e){ e.preventDefault(); openAuthModal(); });
            });

            // optional id trigger
            var trigger = document.getElementById('open-auth-modal');
            if(trigger){ trigger.addEventListener('click', function(e){ e.preventDefault(); openAuthModal(); }); }

            var overlay = document.getElementById('auth-modal');
            if(!overlay) return;
            var closeBtn = overlay.querySelector('.modal-close');
            if(closeBtn) closeBtn.addEventListener('click', closeAuthModal);

            overlay.addEventListener('click', function(e){ if(e.target === overlay) closeAuthModal(); });
            document.addEventListener('keydown', function(e){ if(e.key === 'Escape') closeAuthModal(); });
        });

        // expose for manual control if needed
        window.openAuthModal = openAuthModal;
        window.closeAuthModal = closeAuthModal;
    })();
</script>