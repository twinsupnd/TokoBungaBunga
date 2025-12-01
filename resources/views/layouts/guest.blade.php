<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <!-- Font Awesome for icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-kuPH0XG8fN2b6Z1Y1s1q3Q1Yq8VQmA6s0Y5Z6Gk6b1eW1JYq2f3V6Qe3h6Z1a9Q1pXK1lG8V1y3Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
    </head>
    
    <body>
        <div class="split-auth-container">
            
            <div class="auth-image-panel" 
                 style="background-image: url('{{ asset('images/bunga.jpg') }}');">
                <div class="auth-image-panel-content">
                    <h2 class="auth-image-panel-title">WHISPERING FLORA</h2>
                    <p>Saat kata tak cukup, biar bunga yang bicara.</p>
                </div>
            </div>

            <div class="auth-form-panel">
                
                <h1 class="welcome-title">Welcome to Whispering Flora!</h1> 
                
                <div class="auth-tabs">
                    <button class="auth-tab-button" data-tab="signin">Sign In</button>
                    <button class="auth-tab-button" data-tab="signup">Sign Up</button>
                </div>

                <div class="auth-form-wrapper">
                    {{ $slot }}
                </div>
            </div>
            
        </div>
        
        <script>
            const authFormWrapper = document.querySelector('.auth-form-wrapper');
            const signInTab = document.querySelector('[data-tab="signin"]');
            const signUpTab = document.querySelector('[data-tab="signup"]');
            
            function updateFormWrapperHeight() {
                const activeForm = document.querySelector('.auth-form.active');
                if (activeForm) {
                    authFormWrapper.style.height = activeForm.offsetHeight + 'px';
                }
            }

            function showTab(tabName) {
                const signInForm = document.getElementById('signin-form');
                const signUpForm = document.getElementById('signup-form');
                
                // Pastikan elemen form sudah ada
                if (!signInForm || !signUpForm) return; 

                // Update kelas aktif pada tab
                signInTab.classList.toggle('active', tabName === 'signin');
                signUpTab.classList.toggle('active', tabName === 'signup');
                
                // Update kelas aktif pada form
                signInForm.classList.toggle('active', tabName === 'signin');
                signUpForm.classList.toggle('active', tabName === 'signup');

                // Update URL tanpa reload (untuk konsistensi saat refresh)
                const newPath = tabName === 'signin' ? '{{ route("login") }}' : '{{ route("register") }}';
                history.pushState(null, '', newPath);

                // Update tinggi wrapper setelah transisi
                setTimeout(updateFormWrapperHeight, 50); 
            }

            signInTab.addEventListener('click', () => showTab('signin'));
            signUpTab.addEventListener('click', () => showTab('signup'));

            // Inisialisasi saat halaman dimuat (memeriksa URL saat ini)
            window.addEventListener('load', () => {
                const currentPath = window.location.pathname;
                if (currentPath.includes('register')) {
                    showTab('signup');
                } else {
                    showTab('signin');
                }
            });
            
            // Perlu update tinggi saat form pertama kali dimuat
            setTimeout(updateFormWrapperHeight, 100);
            window.addEventListener('resize', updateFormWrapperHeight);
        </script>
    </body>
</html>