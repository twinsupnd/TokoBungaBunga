<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }} - Login</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        @php
            $registerRoute = route('register');
        @endphp

        <div class="auth-container">
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

                        <button type="submit" class="auth-button login-button">
                            LOG IN
                        </button>
                        
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
                        
                        <p class="privacy-text">
                            Dengan melakukan pendaftaran, berarti kamu telah membaca dan menyetujui <a href="#" class="privacy-link">privacy policy.</a>
                        </p>

                        <button type="submit" class="auth-button register-button">
                            REGISTER
                        </button>
                    </form>
                </div>
                
            </div>
        </div>
    </body>
</html>