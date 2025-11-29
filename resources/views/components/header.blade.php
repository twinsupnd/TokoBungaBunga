<!-- Reusable Header Component -->
<header class="header" style="background-color: white; padding: 15px 40px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.04); position: sticky; top: 0; z-index: 1000;">
    <a href="/" style="display: flex; align-items: center; text-decoration: none;">
        <img src="{{ asset('images/logo.png') }}" alt="Whispering Flora Logo" style="height: 40px; width: auto;">
    </a>

    <nav style="display: flex; gap: 30px; align-items: center;">
        <a href="/" style="color: var(--color-text-dark); text-decoration: none; font-weight: 500; transition: color 0.3s;">Katalog</a>
        
        <!-- Jenis Bunga Dropdown -->
        <div style="position: relative; display: inline-block;">
            <button class="nav-dropdown-btn" style="background: none; border: none; cursor: pointer; color: var(--color-text-dark); text-decoration: none; font-weight: 500; transition: color 0.3s; display: flex; align-items: center; gap: 6px; padding: 0;">
                JENIS BUNGA <span style="font-size: 12px;">▼</span>
            </button>
            <div class="nav-dropdown-menu" style="position: absolute; top: 100%; left: 0; background: white; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); min-width: 200px; display: none; z-index: 1001; margin-top: 8px;">
                <a href="/bunga/mawar" style="display: block; padding: 12px 16px; color: var(--color-text-dark); text-decoration: none; border-bottom: 1px solid #eee; transition: background 0.2s;">🌹 Mawar</a>
                <a href="/bunga/lily" style="display: block; padding: 12px 16px; color: var(--color-text-dark); text-decoration: none; border-bottom: 1px solid #eee; transition: background 0.2s;">🌺 Lily</a>
                <a href="/bunga/tulip" style="display: block; padding: 12px 16px; color: var(--color-text-dark); text-decoration: none; border-bottom: 1px solid #eee; transition: background 0.2s;">🌷 Tulip</a>
                <a href="/bunga/matahari" style="display: block; padding: 12px 16px; color: var(--color-text-dark); text-decoration: none; border-bottom: 1px solid #eee; transition: background 0.2s;">🌻 Matahari</a>
                <a href="/bunga/baby-breath" style="display: block; padding: 12px 16px; color: var(--color-text-dark); text-decoration: none; transition: background 0.2s;">👶 Baby Breath</a>
            </div>
        </div>

        <!-- Model Bunga Dropdown -->
        <div style="position: relative; display: inline-block;">
            <button class="nav-dropdown-btn" style="background: none; border: none; cursor: pointer; color: var(--color-text-dark); text-decoration: none; font-weight: 500; transition: color 0.3s; display: flex; align-items: center; gap: 6px; padding: 0;">
                MODEL BUNGA <span style="font-size: 12px;">▼</span>
            </button>
            <div class="nav-dropdown-menu" style="position: absolute; top: 100%; left: 0; background: white; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); min-width: 200px; display: none; z-index: 1001; margin-top: 8px;">
                <a href="/model/asli" style="display: block; padding: 12px 16px; color: var(--color-text-dark); text-decoration: none; border-bottom: 1px solid #eee; transition: background 0.2s;">🌸 Bunga Asli</a>
                <a href="/model/tiruan" style="display: block; padding: 12px 16px; color: var(--color-text-dark); text-decoration: none; transition: background 0.2s;">🎀 Bunga Tiruan</a>
            </div>
        </div>

        <a href="#about" style="color: var(--color-text-dark); text-decoration: none; font-weight: 500; transition: color 0.3s;">Tentang Kami</a>

        @auth
            <div style="display: flex; align-items: center; gap: 20px;">
                <!-- Cart Icon -->
                <a href="{{ route('cart') }}" style="position: relative; display: flex; align-items: center; text-decoration: none; color: var(--color-text-dark); transition: color 0.3s; font-size: 20px;" title="Keranjang Belanja">
                    🛒
                    <span id="cart-count-badge" style="position: absolute; top: -8px; right: -10px; background: var(--color-accent-strong); color: white; border-radius: 999px; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; min-width: 20px;">0</span>
                </a>

                <!-- User Menu -->
                <div style="position: relative; display: inline-block;">
                    <button id="user-menu-toggle" style="background: none; border: none; cursor: pointer; color: var(--color-text-dark); font-weight: 600; padding: 0; font-size: 15px; display: flex; align-items: center; gap: 8px;">
                        👤 {{ auth()->user()->name }}
                    </button>
                    <div id="user-dropdown" style="position: absolute; top: 100%; right: 0; background: white; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); min-width: 200px; display: none; z-index: 1001;">
                        <a href="{{ route('profile.show') }}" style="display: block; padding: 12px 16px; color: var(--color-text-dark); text-decoration: none; border-bottom: 1px solid #eee; transition: background 0.2s;">
                            👤 Profil Saya
                        </a>
                        <a href="{{ route('profile.edit') }}" style="display: block; padding: 12px 16px; color: var(--color-text-dark); text-decoration: none; border-bottom: 1px solid #eee; transition: background 0.2s;">
                            ✏️ Edit Profil
                        </a>
                        <form method="POST" action="{{ route('logout') }}" style="display: block;">
                            @csrf
                            <button type="submit" style="width: 100%; text-align: left; padding: 12px 16px; background: none; border: none; cursor: pointer; color: var(--color-text-dark); text-decoration: none; transition: background 0.2s;">
                                🚪 Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <a href="#" id="open-auth-modal" style="color: var(--color-button-primary); font-weight: 600; text-decoration: none; padding: 10px 20px; border-radius: 25px; background: linear-gradient(45deg, var(--color-pastel-bliss-5), var(--color-accent-strong), var(--color-button-primary)); background-size: 200% 100%; background-position: right; color: white; transition: all 0.3s;">
                Login
            </a>
            <a href="{{ route('register') }}" style="color: var(--color-accent-strong); font-weight: 600; text-decoration: none;">
                Register
            </a>
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

    // Navigation dropdown menus
    document.querySelectorAll('.nav-dropdown-btn').forEach(btn => {
        const menu = btn.nextElementSibling;
        if (menu && menu.classList.contains('nav-dropdown-menu')) {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
            });
        }
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', (e) => {
        if (!e.target.closest('div[style*="position: relative"]')) {
            document.querySelectorAll('.nav-dropdown-menu').forEach(menu => {
                menu.style.display = 'none';
            });
        }
    });

    // User menu dropdown
    const userMenuBtn = document.getElementById('user-menu-toggle');
    const userDropdown = document.getElementById('user-dropdown');

    if (userMenuBtn && userDropdown) {
        userMenuBtn.addEventListener('click', (e) => {
            e.preventDefault();
            userDropdown.style.display = userDropdown.style.display === 'none' ? 'block' : 'none';
        });

        document.addEventListener('click', (e) => {
            if (!e.target.closest('[style*="position: relative"]') && userDropdown) {
                userDropdown.style.display = 'none';
            }
        });
    }

    window.addEventListener('load', updateCartBadge);
    window.addEventListener('storage', updateCartBadge);
</script>
