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
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" role="img"
                    aria-hidden="true" focusable="false"
                    style="display:block; fill: none; stroke: currentColor; stroke-width:1.6; stroke-linecap:round; stroke-linejoin:round;">
                    <title>Search</title>
                    <circle cx="11" cy="11" r="7"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
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
                <!-- Cart Icon -->
                <a href="{{ route('cart') }}" title="Keranjang Belanja" style="position:relative; display:inline-flex; align-items:center; color:var(--color-text-dark); text-decoration:none; padding:6px; border-radius:6px;">
                    <span class="icon-inline">🛒</span>
                    <span id="cart-count-badge" style="position:absolute; top:-6px; right:-6px; background:var(--color-accent-strong); color:#fff; border-radius:999px; min-width:18px; height:18px; display:inline-flex; align-items:center; justify-content:center; font-size:11px; font-weight:700; padding:0 6px;">0</span>
                </a>

                <!-- User Menu -->
                <div class="nav-dropdown" style="display:inline-block; position:relative;">
                    <button id="user-menu-toggle" class="nav-dropdown-btn" aria-haspopup="true" aria-expanded="false">👤 {{ auth()->user()->name }}</button>
                    <div id="user-dropdown" class="nav-dropdown-menu" style="right:0; left:auto;">
                        <a href="{{ route('profile.show') }}">Profil Saya</a>
                        <a href="{{ route('profile.edit') }}">Edit Profil</a>
                        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                            @csrf
                            <button type="submit" style="width:100%; text-align:left; padding:10px 14px; background:none; border:none;">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <a href="#" id="open-auth-modal" class="nav-link" style="padding:8px 14px; border-radius:20px; background:linear-gradient(135deg, var(--color-pastel-bliss-1), var(--color-accent-strong)); color:#fff;">Login</a>
            <a href="{{ route('register') }}" class="nav-link" style="padding:6px 10px;">Register</a>
        @endauth
    </nav>
</header>

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

    // User menu dropdown
    const userMenuBtn = document.getElementById('user-menu-toggle');
    const userDropdown = document.getElementById('user-dropdown');

    if (userMenuBtn && userDropdown) {
        userMenuBtn.addEventListener('click', (e) => {
            e.preventDefault();
            const isOpen = window.getComputedStyle(userDropdown).display === 'block';
            // close other dropdowns first
            document.querySelectorAll('.nav-dropdown-menu').forEach(m => m.style.display = 'none');
            userDropdown.style.display = isOpen ? 'none' : 'block';
            userMenuBtn.setAttribute('aria-expanded', String(!isOpen));
        });

        // Close when clicking outside any .nav-dropdown
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.nav-dropdown') && userDropdown) {
                userDropdown.style.display = 'none';
                userMenuBtn.setAttribute('aria-expanded', 'false');
            }
        });
    }

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
                    // Ask user before syncing — prevents unexpected merges when browser cart
                    // contains demo/test items or stale data.
                    try {
                        const ok = confirm('Kami menemukan item di keranjang browser Anda. Sinkronkan ke akun Anda sekarang? Tekan OK untuk mengonfirmasi.');
                        if (!ok) {
                            // User declined — do not auto-sync now.
                            return;
                        }
                    } catch (e) {
                        // If confirm is not available for some reason, proceed to sync.
                    }

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
                    }).catch(function(e){ console.error('Cart sync failed', e); });
                }
            }
        } catch (e) {
            console.error('Cart sync error', e);
        }
    })();
</script>
