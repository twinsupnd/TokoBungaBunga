<!-- Reusable Header Component -->
<header class="header" style="position: sticky; top: 0; z-index: 1000;">
    <style>
        /* Header small-scoped styling: keep font sizes consistent */
        .header nav, .header a, .header button { font-size: 15px; }
        .header nav { display:flex; gap:18px; align-items:center; }
        .nav-link, .nav-dropdown-btn { color: var(--ColorHeaderText, var(--color-text-dark)); text-decoration:none; font-weight:600; background:none; border:0; cursor:pointer; padding:6px 8px; border-radius:6px; }
        .nav-link:hover, .nav-dropdown-btn:hover { color: var(--color-accent-strong); background: rgba(237,56,120,0.04); }
        .nav-dropdown { position:relative; }
        .nav-dropdown-menu { position:absolute; top:calc(100% + 8px); left:0; display:none; background:#fff; border:1px solid #eee; border-radius:8px; box-shadow:0 8px 30px rgba(0,0,0,0.08); min-width:200px; z-index:1200; max-height:320px; overflow-y:auto; padding-right:6px; }
        /* Ensure user dropdown specifically can grow taller and be scrollable on small screens */
        #user-dropdown { max-height: 50vh; overflow-y: auto; padding-right: 8px; }
        /* Ensure logout button spans full width inside the dropdown */
        #user-dropdown form button { width: 100%; text-align: left; }
        .nav-dropdown-menu a { display:block; padding:10px 14px; color:var(--color-text-dark); }
        .nav-dropdown-menu a:hover { background:var(--color-pastel-bliss-3); color:var(--color-accent-strong); }
        .icon-inline { font-size:16px; }
        /* small adjustments for auth buttons/links */
        #open-auth-modal, .btn-register { font-size:15px; font-weight:700; }
    </style>

    <a href="/" style="display: flex; align-items: center; text-decoration: none;">
        <img src="{{ asset('images/logo.png') }}" alt="Whispering Flora Logo" style="height: 40px; width: auto;">
    </a>

    <nav>
        <!-- Search (icon + dropdown) -->
        <div style="position: relative; display: inline-block;">
            <button id="open-search-box" aria-haspopup="true" aria-expanded="false" aria-label="Cari"
                style="background:none;border:none;cursor:pointer;font-size:18px;padding:6px;color:var(--color-text-dark); display:flex; align-items:center; justify-content:center;">
                <!-- Monochrome magnifier icon (inherits current color) -->
                
            </button>
            <div id="header-search-dropdown"
                style="position: absolute; top: 100%; left: -40px; transform: translateY(8px); display: none; background: white; border-radius: 10px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); padding: 12px; z-index: 1200; min-width: 340px;">
                <form action="{{ route('search') }}" method="get" style="display:flex; gap:8px; align-items:center;">
                    <input type="search" name="q" placeholder="Cari Bunga..." aria-label="Cari bunga"
                        style="flex:1; padding:10px 12px; border-radius:999px; border:1px solid #eee;">
                    <button type="submit"
                        style="padding:8px 10px; border-radius:999px; background:#f9739c; color:white; border:none; font-weight:700;">Cari</button>
                </form>
            </div>
        </div>
        <a href="{{ route('catalog.index') }}"
            style="color: var(--color-text-dark); text-decoration: none; font-weight: 500; transition: color 0.3s;">Katalog</a>

        <!-- Jenis Bunga Dropdown -->
        <div class="nav-dropdown">
            <button class="nav-dropdown-btn" aria-haspopup="true" aria-expanded="false">Jenis Bunga <span style="font-size:12px">▼</span></button>
            <div class="nav-dropdown-menu">
                <a href="/bunga/mawar">Mawar</a>
                <a href="/bunga/lily">Lily</a>
                <a href="/bunga/tulip">Tulip</a>
                <a href="/bunga/matahari">Matahari</a>
                <a href="/bunga/baby-breath">Baby Breath</a>
            </div>
        </div>

        <!-- Model Bunga Dropdown -->
        <div class="nav-dropdown">
            <button class="nav-dropdown-btn" aria-haspopup="true" aria-expanded="false">Model Bunga <span style="font-size:12px">▼</span></button>
            <div class="nav-dropdown-menu">
                <a href="/model/asli">Bunga Asli</a>
                <a href="/model/tiruan">Bunga Tiruan</a>
            </div>
        </div>

        <a class="nav-link" href="{{ route('about.index') }}">Tentang Kami</a>

        @auth
            <div style="display:flex; align-items:center; gap:16px;">
                <!-- Cart Icon (SVG) -->
                <a href="{{ route('cart') }}" title="Keranjang Belanja" style="position:relative; display:inline-flex; align-items:center; color:var(--color-text-dark); text-decoration:none; padding:6px; border-radius:6px;">
                    <svg class="icon-inline" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="9" cy="20" r="1"></circle>
                        <circle cx="20" cy="20" r="1"></circle>
                        <path d="M1 1h4l2.6 13.4a2 2 0 0 0 2 1.6h8.8a2 2 0 0 0 2-1.6L23 6H6"></path>
                    </svg>
                    <span id="cart-count-badge" style="position:absolute; top:-6px; right:-6px; background:var(--color-accent-strong); color:#fff; border-radius:999px; min-width:18px; height:18px; display:inline-flex; align-items:center; justify-content:center; font-size:11px; font-weight:700; padding:0 6px;">0</span>
                </a>

                <!-- User Menu: click opens profile popup -->
                <div style="display:inline-block; position:relative;">
                    <button id="open-profile-popup" class="nav-dropdown-btn" aria-haspopup="true" aria-expanded="false" style="display:inline-flex; align-items:center; gap:8px;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 21v-2a4 4 0 0 0-3-3.87"></path><path d="M4 21v-2a4 4 0 0 1 3-3.87"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <span id="nav-username">{{ auth()->user()->name ?? '' }}</span>
                    </button>
                </div>
            </div>
        @else
                <button id="open-auth-modal" class="nav-link" style="padding:8px 14px; border-radius:20px; background:linear-gradient(135deg, var(--color-pastel-bliss-1), var(--color-accent-strong)); color:#fff; border:0; cursor:pointer;">Login / Register</button>
        @endauth
    </nav>
</header>

<!-- Profile popup modal -->
<div id="profile-modal" style="display:none; position:fixed; inset:0; align-items:center; justify-content:center; z-index:1400;">
    <div id="profile-modal-backdrop" style="position:absolute; inset:0; background:rgba(0,0,0,0.35);"></div>
    <div style="position:relative; z-index:1410; width:360px; max-width:92%;">
        <div style="background:white; border-radius:12px; padding:18px; box-shadow:0 20px 50px rgba(0,0,0,0.25);">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                <strong>Profil Saya</strong>
                <button id="profile-modal-close" style="background:none;border:0;font-size:18px;cursor:pointer;">✕</button>
            </div>
            <form id="profile-popup-form">
                @csrf
                <div style="display:flex; flex-direction:column; gap:8px;">
                    <label style="font-size:13px; font-weight:600;">Nama</label>
                    <input name="name" id="profile-name" type="text" required value="{{ auth()->user()->name ?? '' }}" style="padding:8px;border:1px solid #e5e7eb;border-radius:6px;">

                    <label style="font-size:13px; font-weight:600;">Role</label>
                    <input type="text" id="profile-role" value="{{ ucfirst(auth()->user()->role ?? 'user') }}" disabled style="padding:8px;border:1px solid #e5e7eb;border-radius:6px;background:#f9fafb;">

                    <div style="display:flex; gap:8px; margin-top:8px; align-items:center;">
                        <button type="submit" style="flex:1; padding:8px; border-radius:8px; border:0; background:var(--color-accent-strong); color:white; font-weight:700; cursor:pointer;">Simpan</button>
                        <button type="submit" form="logout-form" style="padding:8px; border-radius:8px; border:1px solid rgba(0,0,0,0.06); background:#fff; cursor:pointer;">Logout</button>
                    </div>
                </div>
            </form>

            <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">
                @csrf
            </form>
        </div>
    </div>
</div>

        <!-- Auth modal (Login / Register) for guests -->
        <div id="auth-modal" style="display:none; position:fixed; inset:0; align-items:center; justify-content:center; z-index:1500;">
            <div id="auth-modal-backdrop" style="position:absolute; inset:0; background:rgba(0,0,0,0.45);"></div>
            <div style="position:relative; z-index:1510; width:420px; max-width:94%;">
                <div style="background:white; border-radius:12px; padding:18px; box-shadow:0 20px 50px rgba(0,0,0,0.25);">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                        <strong id="auth-modal-title">Login</strong>
                        <button id="auth-modal-close" style="background:none;border:0;font-size:18px;cursor:pointer;">✕</button>
                    </div>

                    <div style="display:flex; gap:8px; margin-bottom:12px;">
                        <button id="auth-tab-login" class="auth-tab" style="flex:1; padding:8px; border-radius:8px; border:1px solid #eee; background:#fff; cursor:pointer;">Login</button>
                        <button id="auth-tab-register" class="auth-tab" style="flex:1; padding:8px; border-radius:8px; border:1px solid #eee; background:#fff; cursor:pointer;">Register</button>
                    </div>

                    <div id="auth-login" class="auth-pane">
                        <form method="POST" action="{{ route('login') }}" style="display:flex; flex-direction:column; gap:8px;">
                            @csrf
                            <label style="font-size:13px; font-weight:600;">Email:</label>
                            <input name="email" type="email" placeholder="Email" required style="padding:10px;border:1px solid #e5e7eb;border-radius:6px;"> 
                            <label style="font-size:13px; font-weight:600;">Password:</label>
                            <input name="password" type="password" placeholder="Password" required style="padding:10px;border:1px solid #e5e7eb;border-radius:6px;"> 
                            <div style="display:flex; align-items:center; justify-content:space-between;">
                                <label style="font-size:13px;"><input type="checkbox" name="remember"> Remember me</label>
                                <a href="{{ route('password.request') }}" style="font-size:13px; color:var(--color-accent-strong);">Lupa password?</a>
                            </div>
                            <div style="display:flex; gap:8px; margin-top:8px;">
                                <button type="submit" style="flex:1; padding:10px; border-radius:8px; border:0; background:var(--color-accent-strong); color:white; font-weight:700; cursor:pointer;">Masuk</button>
                            </div>
                            <div style="margin-top:8px; font-size:14px; text-align:center;">Belum punya akun? <a href="#" id="switch-to-register">Register di sini</a></div>
                        </form>
                    </div>

                    <div id="auth-register" class="auth-pane" style="display:none;">
                        <form method="POST" action="{{ route('register') }}" style="display:flex; flex-direction:column; gap:8px;">
                            @csrf
                            <label style="font-size:13px; font-weight:600;">Nama Lengkap:</label>
                            <input name="name" type="text" placeholder="Nama lengkap" required style="padding:10px;border:1px solid #e5e7eb;border-radius:6px;"> 
                            <label style="font-size:13px; font-weight:600;">Email:</label>
                            <input name="email" type="email" placeholder="Email" required style="padding:10px;border:1px solid #e5e7eb;border-radius:6px;"> 
                            <label style="font-size:13px; font-weight:600;">Password:</label>
                            <input name="password" type="password" placeholder="Password" required style="padding:10px;border:1px solid #e5e7eb;border-radius:6px;"> 
                            <label style="font-size:13px; font-weight:600;">Konfirmasi Password:</label>
                            <input name="password_confirmation" type="password" placeholder="Konfirmasi Password" required style="padding:10px;border:1px solid #e5e7eb;border-radius:6px;"> 
                            <div style="display:flex; gap:8px; margin-top:8px;">
                                <button type="submit" style="flex:1; padding:10px; border-radius:8px; border:0; background:var(--color-accent-strong); color:white; font-weight:700; cursor:pointer;">Daftar</button>
                            </div>
                            <div style="margin-top:8px; font-size:14px; text-align:center;">Sudah punya akun? <a href="#" id="switch-to-login">Masuk di sini</a></div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

<script>
    // Update cart count badge from localStorage
    function updateCartBadge() {
        try {
            const savedCart = localStorage.getItem('whispering_flora_cart');
            if (savedCart) {
                const cartData = JSON.parse(savedCart);
                const totalItems = cartData.items.reduce((sum, item) => sum + item.quantity, 0);
                const badge = document.getElementById('cart-count-badge');
                if (badge) {
                    badge.textContent = totalItems;
                }
            }
        } catch (e) {
            console.log('Error loading cart:', e);
        }
    }

    // Improved dropdown behaviour (aria + close on outside click, Escape key)
    (function() {
        const dropdownToggles = Array.from(document.querySelectorAll('.nav-dropdown-btn'));

        function closeAllDropdowns() {
            document.querySelectorAll('.nav-dropdown-menu').forEach(m => {
                m.style.display = 'none';
                const btn = m.previousElementSibling;
                if (btn && btn.classList && btn.classList.contains('nav-dropdown-btn')) btn.setAttribute('aria-expanded', 'false');
            });
        }

        dropdownToggles.forEach(btn => {
            const menu = btn.nextElementSibling;
            if (!menu) return;
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const isOpen = menu.style.display === 'block';
                closeAllDropdowns();
                if (!isOpen) {
                    menu.style.display = 'block';
                    btn.setAttribute('aria-expanded', 'true');
                }
            });
        });

        document.addEventListener('click', (e) => {
            if (!e.target.closest('.nav-dropdown') && !e.target.closest('.nav-dropdown-btn') && !e.target.closest('#open-search-box') && !e.target.closest('#header-search-dropdown')) {
                closeAllDropdowns();
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeAllDropdowns();
        });
    })();

    // Profile popup behavior (open modal, submit via AJAX)
    (function(){
        const openBtn = document.getElementById('open-profile-popup');
        const modal = document.getElementById('profile-modal');
        const modalBackdrop = document.getElementById('profile-modal-backdrop');
        const modalClose = document.getElementById('profile-modal-close');
        const form = document.getElementById('profile-popup-form');
        const nameInput = document.getElementById('profile-name');
        // role is display-only now, do not send from client
        const navUsername = document.getElementById('nav-username');
        const csrfToken = '{{ csrf_token() }}';

        function openModal(){ if(modal) modal.style.display = 'flex'; }
        function closeModal(){ if(modal) modal.style.display = 'none'; }

        openBtn?.addEventListener('click', function(e){ e.preventDefault(); openModal(); });
        modalClose?.addEventListener('click', function(e){ e.preventDefault(); closeModal(); });
        modalBackdrop?.addEventListener('click', closeModal);

        document.addEventListener('keydown', function(e){ if(e.key === 'Escape') closeModal(); });

        form?.addEventListener('submit', function(e){
            e.preventDefault();
            const payload = { name: nameInput.value };
            fetch("{{ route('profile.popup.update') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            }).then(async r => {
                if (r.ok) {
                    const data = await r.json();
                    if(data && data.status === 'ok'){
                        if(navUsername) navUsername.textContent = data.user.name;
                        closeModal();
                        return;
                    }
                    alert('Profil tersimpan, namun respons tak terduga.');
                    return;
                }

                // handle errors
                let errBody;
                try { errBody = await r.json(); } catch (ex) { errBody = await r.text(); }
                console.error('Profile save failed', r.status, errBody);
                if (r.status === 419) {
                    alert('Sesi Anda berakhir. Silakan refresh halaman dan login kembali.');
                } else if (r.status === 422 && errBody && errBody.errors) {
                    // collect validation messages
                    const messages = Object.values(errBody.errors).flat().join('\n');
                    alert(messages || 'Validasi gagal.');
                } else if (errBody && errBody.message) {
                    alert(errBody.message);
                } else {
                    alert('Gagal menyimpan profil. Periksa console untuk detail.');
                }
            }).catch(err => { console.error(err); alert('Terjadi kesalahan saat menyimpan.'); });
        });
    })();

    // Header search dropdown
    const searchToggle = document.getElementById('open-search-box');
    const searchDropdown = document.getElementById('header-search-dropdown');
    if (searchToggle && searchDropdown) {
        searchToggle.addEventListener('click', (e) => {
            e.preventDefault();
            const isOpen = searchDropdown.style.display === 'block';
            searchDropdown.style.display = isOpen ? 'none' : 'block';
            searchToggle.setAttribute('aria-expanded', String(!isOpen));
            if (!isOpen) {
                const input = searchDropdown.querySelector('input[name="q"]');
                if (input) setTimeout(() => input.focus(), 30);
            }
        });

        document.addEventListener('click', (e) => {
            if (!e.target.closest('#open-search-box') && !e.target.closest('#header-search-dropdown')) {
                searchDropdown.style.display = 'none';
                searchToggle.setAttribute('aria-expanded', 'false');
            }
        });
    }

    window.addEventListener('load', updateCartBadge);
    window.addEventListener('storage', updateCartBadge);

    // Small, themed scrollbar for dropdown menus (WebKit + Firefox fallback)
    (function(){
        const style = document.createElement('style');
        style.innerHTML = `
            .nav-dropdown-menu::-webkit-scrollbar { width: 8px; }
            .nav-dropdown-menu::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.12); border-radius: 6px; }
            .nav-dropdown-menu::-webkit-scrollbar-track { background: transparent; }

            /* Firefox */
            .nav-dropdown-menu { scrollbar-width: thin; scrollbar-color: rgba(0,0,0,0.12) transparent; }
        `;
        document.head.appendChild(style);
    })();

    // If user is authenticated, try to sync any localStorage cart into server-side DB once
    (function() {
        const isAuth = @json(auth()->check());
        const authId = @json(auth()->id());
        if (!isAuth) return;

        try {
            const saved = localStorage.getItem('whispering_flora_cart');
            const syncedFlag = localStorage.getItem('whispering_flora_cart_synced');
            // Only sync if there's a saved cart and we haven't synced for this user id yet
            if (saved && syncedFlag !== String(authId)) {
                const parsed = JSON.parse(saved);
                if (parsed && Array.isArray(parsed.items) && parsed.items.length > 0) {
                    // Automatically sync browser cart into user's account (silent, non-blocking).
                    // This avoids showing a blocking native confirm dialog.
                    fetch("{{ route('cart.sync') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ items: parsed.items })
                    }).then(r => r.json()).then(function(resp) {
                        if (resp && resp.status === 'ok') {
                            // mark as synced for this user and remove local cart to avoid duplication
                            localStorage.removeItem('whispering_flora_cart');
                            localStorage.setItem('whispering_flora_cart_synced', String(authId));
                            updateCartBadge();
                        }
                    }).catch(function(e){
                        // Do not interrupt the user; log failure silently.
                        console.error('Cart sync failed', e);
                    });
                }
            }
        } catch (e) {
            console.error('Cart sync error', e);
        }
    })();

    // Auth modal: open/close and switch panes
    (function(){
        const openAuth = document.getElementById('open-auth-modal');
        const authModal = document.getElementById('auth-modal');
        const authBackdrop = document.getElementById('auth-modal-backdrop');
        const authClose = document.getElementById('auth-modal-close');
        const tabLogin = document.getElementById('auth-tab-login');
        const tabRegister = document.getElementById('auth-tab-register');
        const paneLogin = document.getElementById('auth-login');
        const paneRegister = document.getElementById('auth-register');
        const switchToRegister = document.getElementById('switch-to-register');
        const switchToLogin = document.getElementById('switch-to-login');
        const authTitle = document.getElementById('auth-modal-title');

        function showAuthModal(){ if(authModal) authModal.style.display = 'flex'; }
        function hideAuthModal(){ if(authModal) authModal.style.display = 'none'; }
        function showLogin(){ if(paneLogin) paneLogin.style.display = 'block'; if(paneRegister) paneRegister.style.display = 'none'; if(authTitle) authTitle.textContent = 'Login'; }
        function showRegister(){ if(paneLogin) paneLogin.style.display = 'none'; if(paneRegister) paneRegister.style.display = 'block'; if(authTitle) authTitle.textContent = 'Register'; }

        openAuth?.addEventListener('click', function(e){ e.preventDefault(); showAuthModal(); showLogin(); });
        authClose?.addEventListener('click', function(){ hideAuthModal(); });
        authBackdrop?.addEventListener('click', function(){ hideAuthModal(); });

        tabLogin?.addEventListener('click', function(e){ e.preventDefault(); showLogin(); });
        tabRegister?.addEventListener('click', function(e){ e.preventDefault(); showRegister(); });
        switchToRegister?.addEventListener('click', function(e){ e.preventDefault(); showRegister(); });
        switchToLogin?.addEventListener('click', function(e){ e.preventDefault(); showLogin(); });
        document.addEventListener('keydown', function(e){ if(e.key === 'Escape') hideAuthModal(); });
    })();
</script>
