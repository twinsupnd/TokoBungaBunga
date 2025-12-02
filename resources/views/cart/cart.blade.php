<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Whispering Flora (Pastel Bliss)</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Quicksand:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    <script src="https://unpkg.com/lucide@latest"></script>
 @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* --- Variabel Warna dan Font (Pastel Bliss) --- */
        :root {
            --color-pastel-bliss-1: #FFB5A7;
            /* Primer Pink */
            --color-pastel-bliss-2: #FCD5CE;
            /* Light Pink */
            --color-pastel-bliss-3: #F8EDEB;
            /* Off-White/Lightest Pink (Background) */
            --color-pastel-bliss-4: #F9DCC4;
            /* Light Peach (Accent Background) */
            --color-pastel-bliss-5: #FCD5CE;
            /* Peach/Soft Pink Tone */

            --color-text-dark: #5A4B4B;
            --color-text-light: #8C7878;
            --color-accent-strong: #ED3878;
            /* Deep Pink (CTA Utama dan Judul) */

            --font-display: 'Playfair Display', serif;
            --font-body: 'Quicksand', sans-serif;
            --font-nav: 'Instrument Sans', sans-serif;

            --color-button-secondary: #B2967D;
            /* Muted Brown untuk kupon */
            --color-bliss-success: #78C257;
            /* Success/Green tone */
        }

        body {
            background-color: var(--color-pastel-bliss-3);
            font-family: var(--font-body);
            color: var(--color-text-dark);
            min-height: 100vh;
        }

        .title-display {
            font-family: var(--font-display);
        }

        /* HEADER */
       
        .header-nav-link {
            font-family: var(--font-nav);
            font-weight: 500;
            font-size: 15px;
            color: var(--color-text-dark);
            transition: color 0.2s;
        }

        /* Input Kuantitas Disesuaikan */
        .quantity-control {
            border: 1px solid var(--color-pastel-bliss-2);
            border-radius: 8px;
            overflow: hidden;
            display: inline-flex;
            align-items: center;
        }

        .quantity-input {
            border: none;
            text-align: center;
            width: 32px;
            height: 32px;
            padding: 0 4px;
            color: var(--color-text-dark);
            -moz-appearance: textfield;
            background-color: var(--color-pastel-bliss-3);
        }

        .quantity-input::-webkit-outer-spin-button,
        .quantity-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .quantity-btn {
            background-color: white;
            border: none;
            width: 32px;
            height: 32px;
            cursor: pointer;
            color: var(--color-text-dark);
            transition: background-color 0.2s;
            font-size: 1.2rem;
            line-height: 1;
        }

        .quantity-btn:hover {
            background-color: var(--color-pastel-bliss-2);
        }

        .quantity-btn:active {
            background-color: var(--color-pastel-bliss-1);
            color: white;
        }

        /* Button Primary (Lanjut Checkout) */
        .btn-checkout {
            background-color: var(--color-accent-strong);
            transition: background-color 0.3s;
        }

        .btn-checkout:hover {
            background-color: #c92f65;
            box-shadow: 0 4px 15px rgba(237, 56, 120, 0.4);
        }

        /* Button Secondary (Gunakan Diskon) */
        .btn-coupon {
            background-color: var(--color-button-secondary);
            transition: background-color 0.3s;
        }

        .btn-coupon:hover {
            background-color: #9f866f;
        }

        /* Input umum */
        input[type="text"],
        input[type="number"] {
            border-color: var(--color-pastel-bliss-2);
        }

        input:focus {
            border-color: var(--color-pastel-bliss-1) !important;
            outline: none;
            box-shadow: 0 0 0 2px rgba(255, 181, 167, 0.5) !important;
        }

        /* Penyesuaian Responsif untuk Kolom Item */
        @media (max-width: 640px) {

            /* Sembunyikan kolom harga per unit di mobile */
            .cart-item-grid>div:nth-child(2) {
                display: none;
            }

            /* Jadikan teks subtotal lebih kecil */
            .cart-item-grid>div:nth-child(4) {
                font-size: 0.8rem;
            }

            /* Penyesuaian lebar kolom di mobile */
            .cart-item-grid>div:nth-child(1) {
                width: 60%;
            }

            /* Detail Produk */
            .cart-item-grid>div:nth-child(3) {
                width: 20%;
            }

            /* Kuantitas */
            .cart-item-grid>div:nth-child(4) {
                width: 20%;
            }

            /* Subtotal */
        }
    </style>

    <script>
        // Konfigurasi Tailwind (untuk memastikan variabel CSS diakui)
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'bliss-1': 'var(--color-pastel-bliss-1)',
                        'bliss-2': 'var(--color-pastel-bliss-2)',
                        'bliss-3': 'var(--color-pastel-bliss-3)',
                        'bliss-4': 'var(--color-pastel-bliss-4)',
                        'bliss-5': 'var(--color-pastel-bliss-5)',
                        'text-dark': 'var(--color-text-dark)',
                        'text-light': 'var(--color-text-light)',
                        'accent-strong': 'var(--color-accent-strong)',
                        'bliss-success': 'var(--color-bliss-success)',
                    }
                }
            }
        };

        // --- MODEL DATA SIMULASI CART ---
        // Try to load cart data from localStorage, fallback to demo data
        let cartData = {
            items: [],
            summary: {
                subtotal: 0,
                shipping: 50000,
                total: 0
            }
        };

        // Load from localStorage if exists
        let _savedCartRaw = null;
        try {
            _savedCartRaw = localStorage.getItem('whispering_flora_cart');
            if (_savedCartRaw) {
                const parsedCart = JSON.parse(_savedCartRaw);
                if (parsedCart && parsedCart.items && Array.isArray(parsedCart.items)) {
                    cartData = parsedCart;
                }
            }
        } catch (e) {
            console.log('Error loading cart from localStorage:', e);
        }

        // If no saved cart (browser has never had a cart) and no server items, use demo data for preview
        if ((!_savedCartRaw || _savedCartRaw === null) && cartData.items.length === 0) {
            cartData = {
                items: [{
                        id: 1,
                        name: 'Baby Blooms Bouquet',
                        price: 550000,
                        quantity: 2,
                        imageUrl: 'https://placehold.co/80x80/FFB5A7/5A4B4B?text=Pastel+Bouquet'
                    },
                    {
                        id: 2,
                        name: 'Satin Ribbon (Rose Gold)',
                        price: 89000,
                        quantity: 1,
                        imageUrl: 'https://placehold.co/80x80/FCD5CE/5A4B4B?text=Rose+Ribbon'
                    },
                    {
                        id: 3,
                        name: 'Aromatic Candle Set (Peony)',
                        price: 210000,
                        quantity: 3,
                        imageUrl: 'https://placehold.co/80x80/F9DCC4/5A4B4B?text=Aroma+Candle'
                    }
                ],
                summary: {
                    subtotal: 0,
                    shipping: 50000,
                    total: 0
                }
            };
        }

        // Determine whether the cart was rendered from server (authenticated user)
        const isServerCart = @json(isset($items) && count($items) > 0);

        // If server provided cart items (authenticated user), use them instead
        @if (isset($items) && count($items) > 0)
            cartData.items = [
                @foreach ($items as $it)
                    {
                        id: {{ $it->id }},
                        name: "{{ addslashes($it->jenis->name ?? 'Produk') }}",
                        price: {{ $it->price ?? (int) preg_replace('/[^0-9]/', '', $it->jenis->price ?? 0) }},
                        quantity: {{ $it->quantity }},
                        imageUrl: "{{ $it->jenis->image ? asset($it->jenis->image) . '?v=' . strtotime($it->jenis->updated_at) : asset('images/babybreath.jpg') }}"
                    },
                @endforeach
            ];
            cartData.summary = calculateSummaryLocally(cartData.items);
        @endif

        // --- FUNGSI HELPER ---

        // Memformat angka ke format Rupiah
        function formatRupiah(number) {
            if (typeof number === 'number') {
                return 'Rp' + number.toLocaleString('id-ID');
            }
            return 'Rp-,-';
        }

        // Menampilkan pesan notifikasi di UI
        function showMessage(message, type = 'success') {
            const msgBox = document.getElementById('message-box');
            msgBox.textContent = message;

            if (type === 'success') {
                msgBox.className = 'p-3 mb-4 rounded-lg bg-bliss-success/10 text-bliss-success font-medium';
            } else if (type === 'error') {
                msgBox.className = 'p-3 mb-4 rounded-lg bg-accent-strong/10 text-accent-strong font-medium';
            } else if (type === 'info') {
                msgBox.className = 'p-3 mb-4 rounded-lg bg-bliss-1/10 text-text-dark font-medium';
            }

            // Hapus pesan setelah 4 detik
            setTimeout(() => {
                msgBox.textContent = '';
                msgBox.className = '';
            }, 4000);
        }

        // Menghitung ulang ringkasan total (Subtotal, Total)
        function calculateSummaryLocally(items) {
            const subtotal = items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const shipping = subtotal > 1000000 ? 0 : 40000; // Contoh: Gratis ongkir jika subtotal di atas Rp1.000.000
            const total = subtotal + shipping;
            return {
                subtotal,
                shipping,
                total
            };
        }

        // --- LOGIKA CONTROLLER (Perubahan Data) ---

        // Fungsi utama untuk memperbarui kuantitas (dipanggil oleh button dan input onchange)
        async function updateQuantityOnServer(id, newQuantity) {
            const item = cartData.items.find(i => i.id === id);

            if (!item) {
                showMessage('Item tidak ditemukan.', 'error');
                return;
            }

            // Sanitasi input (wajib >= 1)
            newQuantity = parseInt(newQuantity);
            if (isNaN(newQuantity) || newQuantity < 1) {
                // Reset to item's current quantity if invalid
                document.querySelector(`input[data-id="${id}"]`).value = item.quantity;
                showMessage('Kuantitas harus minimal 1.', 'error');
                renderCart(); // Render ulang untuk memastikan input field kembali ke nilai yang benar
                return;
            }

            // Jika kuantitas kurang dari 1, kita bisa hapus atau reset ke 1
            if (newQuantity <= 0) {
                removeItem(id); // Hapus jika kuantitas di set ke 0
                return;
            }

            // Pastikan kuantitas tidak terlalu besar (simulasi batas stok)
            if (newQuantity > 99) {
                newQuantity = 99;
                document.querySelector(`input[data-id="${id}"]`).value = 99;
                showMessage('Kuantitas maksimum adalah 99.', 'info');
            }

            // Update locally first
            item.quantity = newQuantity;

            // Update Summary
            const newSummary = calculateSummaryLocally(cartData.items);
            cartData.summary = newSummary;

            // If this page is rendering a server-side cart (authenticated), notify server
            if (isServerCart) {
                try {
                    await fetch(`/cart/${id}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: new URLSearchParams({ quantity: String(newQuantity) })
                    });
                } catch (e) {
                    console.error('Failed to update cart on server', e);
                }
            } else {
                // Persist client-only cart to localStorage so changes survive refresh
                try { localStorage.setItem('whispering_flora_cart', JSON.stringify(cartData)); } catch (e) { }
            }

            showMessage('Keranjang berhasil diperbarui!', 'success');
            renderCart();
        }

        // Handler untuk tombol +/-
        function changeQuantity(id, delta) {
            const inputElement = document.querySelector(`input[data-id="${id}"]`);
            if (!inputElement) return;

            let currentQuantity = parseInt(inputElement.value);
            let newQuantity = currentQuantity + delta;

            // Langsung update di server
            updateQuantityOnServer(id, newQuantity);
        }

        // Fungsi untuk menghapus item
        async function removeItem(id) {
            const itemIndex = cartData.items.findIndex(item => item.id === id);

            if (itemIndex > -1) {
                // PENTING: Konfirmasi Hapus
                if (!confirm("Apakah Anda yakin ingin menghapus item ini dari keranjang?")) {
                    return;
                }

                // If this cart is server-rendered (authenticated), call server delete endpoint
                if (isServerCart) {
                    try {
                        const resp = await fetch(`/cart/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        });

                        // On success remove locally and re-render
                        if (resp.ok || resp.status === 302) {
                            cartData.items.splice(itemIndex, 1);
                            const newSummary = calculateSummaryLocally(cartData.items);
                            cartData.summary = newSummary;
                            showMessage('Item berhasil dihapus dari keranjang.', 'success');
                            renderCart();
                        } else {
                            showMessage('Gagal menghapus item di server.', 'error');
                        }
                    } catch (e) {
                        console.error('Delete cart error', e);
                        showMessage('Terjadi kesalahan saat menghapus item.', 'error');
                    }
                } else {
                    // Client-only cart: remove and persist to localStorage
                    cartData.items.splice(itemIndex, 1);
                    const newSummary = calculateSummaryLocally(cartData.items);
                    cartData.summary = newSummary;
                    try { localStorage.setItem('whispering_flora_cart', JSON.stringify(cartData)); } catch (e) {}
                    showMessage('Item berhasil dihapus dari keranjang.', 'success');
                    renderCart();
                }
            }
        }

        // Simulasikan penggunaan diskon
        function applyCoupon() {
            const couponInput = document.getElementById('coupon-input');
            const code = couponInput.value.trim().toUpperCase();

            if (cartData.items.length === 0) {
                showMessage('Keranjang kosong. Tidak bisa menggunakan diskon.', 'info');
                return;
            }

            if (code === 'FLORABESAR') {
                showMessage('Diskon 10% berhasil diterapkan!', 'success');
            } else if (code === 'FREEONGKIR') {
                showMessage('Voucher Free Ongkir berhasil diterapkan!', 'success');
            } else {
                showMessage('Kode diskon tidak valid.', 'error');
            }
            // Di lingkungan nyata, kita akan memanggil renderCart() untuk menampilkan diskon yang diterapkan.
        }


        // --- LOGIKA VIEW (Render UI) ---

        // Fungsi untuk merender ulang seluruh isi keranjang
        function renderCart() {
            const itemsContainer = document.getElementById('cart-items-container');
            const summary = calculateSummaryLocally(cartData.items);
            cartData.summary = summary; // Update summary data

            itemsContainer.innerHTML = '';

            if (cartData.items.length === 0) {
                itemsContainer.innerHTML =
                    '<p class="text-text-light py-8 text-center border border-bliss-2 rounded-lg bg-white mt-4">Keranjang Anda kosong. Yuk, cari produk lucu!</p>';
            }

            cartData.items.forEach(item => {
                const subtotalItem = item.price * item.quantity;

                const itemHtml = `
                    <div class="flex items-center border-b border-bliss-2 py-4 text-text-dark cart-item-grid">
                        <div class="w-full sm:w-1/2 flex items-center pr-2">
                            <button class="text-text-light mr-4 text-lg hover:text-accent-strong transition"
                                title="Hapus Item" onclick="removeItem(${item.id})">
                                <i data-lucide="x-circle" class="w-5 h-5"></i>
                            </button>
                            <img src="${item.imageUrl}"
                                onerror="this.onerror=null;this.src='https://placehold.co/80x80/FCD5CE/5A4B4B?text=Item'"
                                alt="${item.name}" class="w-16 h-16 object-cover rounded-lg mr-4 border border-bliss-2">
                            <span class="text-sm sm:text-base font-medium">${item.name}</span>
                        </div>

                        <div class="w-1/6 text-left font-light hidden sm:block">
                            ${formatRupiah(item.price)}
                        </div>

                        <div class="w-1/4 sm:w-1/6 text-center flex justify-center">
                            <div class="quantity-control">
                                <button class="quantity-btn" onclick="changeQuantity(${item.id}, -1)">-</button>
                                <input type="number" value="${item.quantity}" min="1" max="99" data-id="${item.id}"
                                    onchange="updateQuantityOnServer(${item.id}, parseInt(this.value))"
                                    class="quantity-input">
                                <button class="quantity-btn" onclick="changeQuantity(${item.id}, 1)">+</button>
                            </div>
                        </div>

                        <div class="w-1/2 sm:w-1/6 text-right font-semibold">
                            ${formatRupiah(subtotalItem)}
                        </div>
                    </div>
                `;
                itemsContainer.innerHTML += itemHtml;
            });

            // Render ulang ikon Lucide untuk item-item yang baru dibuat
            lucide.createIcons();

            // Update Ringkasan Total
            document.getElementById('subtotal-value').textContent = formatRupiah(summary.subtotal);
            document.getElementById('shipping-value').textContent = summary.shipping === 0 ? 'Gratis' : formatRupiah(summary
                .shipping);
            document.getElementById('shipping-value').classList.toggle('text-bliss-success', summary.shipping === 0);
            document.getElementById('total-value').textContent = formatRupiah(summary.total);

            // PENTING: Update Cart Count di Header! (Perbaikan)
            const cartCountElement = document.getElementById('cart-count');
            const cartBadgeElement = document.getElementById('cart-count-badge');
            const totalQuantity = cartData.items.reduce((sum, item) => sum + item.quantity, 0);
            if (cartCountElement) {
                cartCountElement.textContent = cartData.items.length;
            }
            if (cartBadgeElement) {
                cartBadgeElement.textContent = totalQuantity;
            }

            // Tampilkan/Sembunyikan summary
            const totalsCard = document.getElementById('cart-totals-card');
            if (totalsCard) {
                totalsCard.style.display = cartData.items.length > 0 ? 'block' : 'none';
            }

            // Persist client-only cart state so changes survive page refresh
            try {
                if (!isServerCart) {
                    localStorage.setItem('whispering_flora_cart', JSON.stringify(cartData));
                }
            } catch (e) {
                // ignore storage errors
            }
        }

        // Render awal saat halaman dimuat
        window.onload = function() {
            renderCart();
            // Ensure Lucide icons are rendered for static header elements
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        };
    </script>
</head>

<body class="min-h-screen">

    @include('components.header')


    <div class="container mx-auto px-4 py-8 max-w-7xl">

        <h1 class="text-2xl sm:text-3xl title-display mb-10 font-medium text-text-dark">
            Keranjang Belanja
            <span class="font-light text-text-light text-xl">&gt; Detail Pemesanan &gt; Pesanan Selesai</span>
        </h1>

        <div id="message-box" role="alert"></div>

        <div class="flex flex-wrap lg:flex-nowrap -mx-4">

            <div class="w-full lg:w-3/4 px-4">

                <div
                    class="flex items-center text-xs font-semibold tracking-wider uppercase text-text-dark border-b-2 border-bliss-2 pb-2 mb-2">
                    <div class="w-full sm:w-1/2">Produk</div>
                    <div class="w-1/6 text-left hidden sm:block">Harga</div>
                    <div class="w-1/6 text-center">Kuantitas</div>
                    <div class="w-1/6 text-right">Subtotal</div>
                </div>

                <div id="cart-items-container">
                </div>

                <div class="mt-8">
                    <a href="#"
                        class="inline-block px-6 py-2 border border-accent-strong text-accent-strong font-medium
                                             tracking-wider uppercase text-sm rounded-lg transition duration-300
                                             hover:bg-accent-strong/10 hover:shadow-lg">
                        &larr; LANJUTKAN BELANJA
                    </a>
                </div>
            </div>
            <div class="w-full lg:w-1/4 px-4 mt-10 lg:mt-0" id="cart-totals-card">
                <h2 class="text-xs sm:text-sm font-bold tracking-wider uppercase text-text-light mb-4">RINGKASAN BELANJA
                </h2>

                <div class="bg-white p-6 border border-bliss-2 rounded-xl shadow-lg">
                    <div class="flex justify-between py-2 border-b border-bliss-2">
                        <span>Subtotal</span>
                        <span id="subtotal-value" class="font-semibold text-text-dark">Rp-,-</span>
                    </div>

                    <div class="py-2 border-b border-bliss-2">
                        <div class="flex justify-between">
                            <span>Pengiriman</span>
                            <span id="shipping-value" class="font-semibold text-bliss-success">Gratis</span>
                        </div>
                        <div class="text-right text-xs text-text-light mt-1">
                            Pengiriman ke DKI Jakarta. <a href="/pesanan"
                                class="text-accent-strong underline hover:no-underline">Ubah alamat</a>
                        </div>
                    </div>

                    <div class="flex justify-between py-2 font-bold text-xl title-display mt-2">
                        <span>TOTAL</span>
                        <span id="total-value" class="text-accent-strong">Rp-,-</span>
                    </div>

                    <a href="/pesanan"
                        class="btn-checkout block text-center mt-6 px-6 py-3 text-white font-bold uppercase
                                             rounded-lg transition duration-300 shadow-md">
                        LANJUT KE CHECKOUT
                    </a>

                    <div class="mt-8 pt-4 border-t border-bliss-2">
                        <p class="text-sm text-text-dark mb-2 font-medium">Voucher/Diskon</p>
                        <input type="text" id="coupon-input" placeholder="Kode voucher atau diskon"
                            class="w-full p-2 border rounded-lg mb-3">
                        <button onclick="applyCoupon()"
                            class="btn-coupon w-full p-2 text-white font-bold uppercase rounded-lg
                                             transition duration-300 shadow-sm">
                            GUNAKAN DISKON
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    @include('auth._login-modal')
</body>

</html>