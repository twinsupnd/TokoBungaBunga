<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Checkout</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    
    <script src="https://unpkg.com/lucide@latest"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        /* --- Variabel Warna dan Font (Pastel Bliss) --- */
        :root {
            --color-pastel-bliss-1: #FFB5A7; /* Primer Pink */
            --color-pastel-bliss-2: #FCD5CE; /* Light Pink */
            --color-pastel-bliss-3: #F8EDEB; /* Off-White/Lightest Pink (Background) */
            --color-pastel-bliss-4: #F9DCC4; /* Light Peach (Accent Background) */
            --color-pastel-bliss-5: #FCD5CE; /* Peach/Soft Pink Tone */
            
            --color-text-dark: #5A4B4B; 
            --color-text-light: #8C7878; 
            --color-accent-strong: #ED3878; /* Deep Pink (CTA Utama dan Judul) */

            --font-display: 'Playfair Display', serif;
            --font-body: 'Quicksand', sans-serif;
            --font-nav: 'Instrument Sans', sans-serif; 

            --color-button-secondary: #B2967D; /* Muted Brown */
            --color-bliss-success: #78C257; /* Success/Green tone */
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
        
        /* HEADER - Gunakan gaya yang sama dengan cart.blade.php */
        .header {
            background-color: white;
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-nav-link {
            font-family: var(--font-nav);
            font-weight: 500;
            font-size: 15px;
            color: var(--color-text-dark);
            transition: color 0.2s;
        }
        .header-nav-link:hover {
            color: var(--color-accent-strong);
        }

        /* Input Form Checkout */
        .form-input-bliss {
            border-color: var(--color-pastel-bliss-2);
            padding: 10px 15px;
            border-radius: 8px;
            width: 100%;
            transition: all 0.2s;
        }
        .form-input-bliss:focus {
            border-color: var(--color-pastel-bliss-1) !important;
            outline: none;
            box-shadow: 0 0 0 2px rgba(255, 181, 167, 0.5) !important;
        }
        
        /* Button Primary (Lanjut Pembayaran) */
        .btn-payment {
            background-color: var(--color-accent-strong);
            transition: background-color 0.3s;
        }
        .btn-payment:hover {
            background-color: #c92f65; 
            box-shadow: 0 4px 15px rgba(237, 56, 120, 0.4);
        }
        
        /* Opsi Pembayaran */
        .payment-option {
            cursor: pointer;
            border: 2px solid var(--color-pastel-bliss-2);
            transition: all 0.2s;
            border-radius: 10px;
        }
        .payment-option.active {
            border-color: var(--color-accent-strong);
            box-shadow: 0 0 0 1px var(--color-accent-strong);
            background-color: var(--color-pastel-bliss-2);
        }

        /* Global loading overlay (spinner similar to payment gateway) */
        #global-loading {
            position: fixed;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            background: rgba(0,0,0,0.45);
            z-index: 9999;
        }
        .loader {
            width: 84px;
            height: 84px;
            border-radius: 50%;
            border: 8px solid rgba(255,255,255,0.18);
            border-top-color: var(--color-accent-strong);
            animation: spin 1s linear infinite;
            box-shadow: 0 6px 18px rgba(0,0,0,0.25);
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Enhanced payment-style spinner */
        .payment-spinner {
            display:flex;
            flex-direction:column;
            align-items:center;
            gap:12px;
            color: #fff;
        }
        .spinner-svg { width:120px; height:120px; }
        .spinner-svg .ring { fill:none; stroke-width:8; stroke-linecap:round; }
        .spinner-svg .ring-1 { stroke: rgba(255,255,255,0.14); }
        .spinner-svg .ring-2 { stroke: var(--color-accent-strong); stroke-dasharray: 80 120; stroke-dashoffset: 0; transform-origin: 50% 50%; animation: spin-slow 1.6s linear infinite; }
        .spinner-svg .ring-3 { stroke: rgba(255,255,255,0.3); stroke-dasharray: 40 160; animation: spin-reverse 1.9s linear infinite; }

        @keyframes spin-slow { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        @keyframes spin-reverse { from { transform: rotate(360deg); } to { transform: rotate(0deg); } }

        .spinner-logo { width:46px; height:46px; border-radius:10px; background: #fff; display:flex; align-items:center; justify-content:center; box-shadow: 0 6px 18px rgba(0,0,0,0.12); }
        .spinner-logo .mark { font-weight:700; color: var(--color-accent-strong); font-family: var(--font-display); }

        .spinner-text { font-size:14px; color: #fff; opacity:0.98; font-weight:600; }

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

        // --- MODEL DATA CHECKOUT ---
        // Prefer server-provided items (passed from CheckoutController::show).
        // If server cart is empty, we will fallback to client `localStorage` below.
        let checkoutData = {
            items: @json($items ?? []),
            shipping: @json($shipping ?? 40000), // default ongkir if not passed from controller
            subtotal: 0,
            total: 0,
            discount: 0
        };

        // --- FUNGSI HELPER ---

        // Memformat angka ke format Rupiah
        function formatRupiah(number) {
            if (typeof number === 'number') {
                return 'Rp' + number.toLocaleString('id-ID');
            }
            return 'Rp-,-';
        }

        // Menghitung ulang ringkasan total
        function calculateSummary(items, shipping, discount) {
            const subtotal = items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const total = subtotal + shipping - discount;
            return { subtotal, total };
        }

        // --- LOGIKA VIEW (Render UI) ---

        function renderDetails() {
            const itemsContainer = document.getElementById('item-details-container');
            const summary = calculateSummary(checkoutData.items, checkoutData.shipping, checkoutData.discount);
            
            checkoutData.subtotal = summary.subtotal;
            checkoutData.total = summary.total;

            itemsContainer.innerHTML = ''; 

            checkoutData.items.forEach(item => {
                const subtotalItem = item.price * item.quantity;

                itemsContainer.innerHTML += `
                    <div class="flex justify-between items-center py-3 border-b border-bliss-2/50 text-sm">
                        <div class="flex items-center gap-3">
                            <img src="${item.imageUrl}" class="w-10 h-10 object-cover rounded-md border border-bliss-2" alt="${item.name}">
                            <span class="font-medium">${item.name} (${item.quantity}x)</span>
                        </div>
                        <span class="font-semibold">${formatRupiah(subtotalItem)}</span>
                    </div>
                `;
            });

            // Update Ringkasan Total
            document.getElementById('subtotal-value').textContent = formatRupiah(checkoutData.subtotal);
            document.getElementById('shipping-value').textContent = checkoutData.shipping === 0 ? 'Gratis' : formatRupiah(checkoutData.shipping);
            document.getElementById('discount-value').textContent = formatRupiah(checkoutData.discount);
            document.getElementById('total-value').textContent = formatRupiah(checkoutData.total);
            document.getElementById('total-value-cta').textContent = formatRupiah(checkoutData.total);
            
            // Render ulang ikon Lucide
            lucide.createIcons();
        }
        
        // --- LOGIKA INTERAKSI ---
        
        function selectPaymentMethod(element, method) {
            // Hapus kelas 'active' dari semua opsi
            document.querySelectorAll('.payment-option').forEach(opt => {
                opt.classList.remove('active');
            });
            // Tambahkan kelas 'active' pada opsi yang diklik
            element.classList.add('active');
            
            // Di sini Anda dapat menyimpan metode pembayaran yang dipilih (method)
            console.log("Metode pembayaran dipilih:", method);
        }

        // Show a global loading overlay (spinner)
        function showLoading() {
            const el = document.getElementById('global-loading');
            if (el) el.style.display = 'flex';
            // disable the main submit button to prevent duplicate clicks
            const btn = document.querySelector('button[type="submit"].btn-payment');
            if (btn) {
                // store original content so we can restore it
                if (!btn.dataset.origHtml) btn.dataset.origHtml = btn.innerHTML;
                btn.disabled = true;
                btn.setAttribute('aria-busy', 'true');
                // show compact label while processing
                btn.innerHTML = '<span style="display:inline-block;margin-right:10px;vertical-align:middle;">Memproses...</span>';
            }
        }

        function hideLoading() {
            const el = document.getElementById('global-loading');
            if (el) el.style.display = 'none';
            const btn = document.querySelector('button[type="submit"].btn-payment');
            if (btn) {
                btn.disabled = false;
                btn.removeAttribute('aria-busy');
                if (btn.dataset.origHtml) {
                    btn.innerHTML = btn.dataset.origHtml;
                    delete btn.dataset.origHtml;
                }
            }
        }

        async function proceedToPayment(event) {
            event.preventDefault(); // Mencegah form submit default

            // Validate form
            const name = document.getElementById('name').value;
            const phone = document.getElementById('phone').value;
            const address = document.getElementById('address').value;
            const active = document.querySelector('.payment-option.active');
            const payment_method = active ? (active.getAttribute('data-method') || active.textContent.trim()) : null;

            if (!name || !phone || !address) {
                alert("Mohon lengkapi semua data pelanggan dan pengiriman!");
                return;
            }

            if (!payment_method) {
                alert('Pilih metode pembayaran terlebih dahulu.');
                return;
            }

            const token = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';

            // If there is a browser cart that hasn't been synced yet, attempt to sync it first.
            let parsedCart = null;
            let syncSucceeded = false;

            // show global loading spinner for the checkout flow
            showLoading();

            try {
                try {
                    const savedRaw = localStorage.getItem('whispering_flora_cart');
                    const syncedFlag = localStorage.getItem('whispering_flora_cart_synced');
                    const authId = @json(auth()->id());

                    if (savedRaw && syncedFlag !== String(authId)) {
                        parsedCart = JSON.parse(savedRaw);
                        if (parsedCart && Array.isArray(parsedCart.items) && parsedCart.items.length > 0) {
                            // Attempt silent sync and wait for result before checkout
                            try {
                                const syncResp = await fetch("{{ route('cart.sync') }}", {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': token,
                                        'Accept': 'application/json'
                                    },
                                    credentials: 'same-origin',
                                    body: JSON.stringify({ items: parsedCart.items })
                                });

                                const syncJson = await syncResp.json();
                                if (syncJson && syncJson.status === 'ok') {
                                    // mark as synced locally to avoid duplicate attempts
                                    localStorage.removeItem('whispering_flora_cart');
                                    localStorage.setItem('whispering_flora_cart_synced', String(authId));
                                    syncSucceeded = true;
                                    // update UI badge if present
                                    try { updateCartBadge(); } catch (e) {}
                                }
                            } catch (e) {
                                console.warn('Silent cart sync failed, will include local items in checkout payload as fallback.', e);
                                // continue to checkout attempt — include local items as fallback
                            }
                        }
                    }
                } catch (e) {
                    console.warn('Error checking local cart before checkout', e);
                }

                // Prepare payload for checkout (server uses DB cart for authenticated users)
                const payload = {
                    name: name,
                    phone: phone,
                    address: address,
                    payment_method: payment_method
                };

                // If we still have local cart items that weren't synced, include them as fallback
                if (!syncSucceeded && parsedCart && Array.isArray(parsedCart.items) && parsedCart.items.length > 0) {
                    // Normalize local cart items before sending to server.
                    // Some pages may store `price` as formatted strings (eg "Rp190.000").
                    // Ensure we always send numeric prices (in cents/IDR integer) so server
                    // doesn't cast formatted strings to 0.
                    payload.items = parsedCart.items.map(p => {
                        const rawPrice = p.price !== undefined && p.price !== null ? p.price : (p.jenis_price || p.price_text || 0);
                        const normalizedPrice = (typeof rawPrice === 'number') ? rawPrice : (parseInt(String(rawPrice).replace(/[^0-9]/g, '')) || 0);
                        return {
                            id: p.id ?? p.jenis_id ?? null,
                            name: p.name ?? p.title ?? 'Produk',
                            price: normalizedPrice,
                            quantity: p.quantity || 1,
                            imageUrl: p.imageUrl || p.image || (p.image_path ? '/storage/'+p.image_path : 'https://placehold.co/80x80/F9DCC4/5A4B4B?text=Produk')
                        };
                    });
                }

                // Send to server to create a local order (no Midtrans)
                const resp = await fetch("{{ route('checkout.process') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify(payload)
                });

                const json = await resp.json();
                console.log('checkout.process response', resp.status, json);

                // If server returned non-2xx, show error message and don't open modal
                if (!resp.ok) {
                    const msg = json && (json.error || json.message || JSON.stringify(json)) || 'Unknown error';
                    alert('Gagal membuat pesanan: ' + msg);
                    return;
                }

                // Server returned 200; ensure we have an order id and total
                if (!json.order_id) {
                    alert('Gagal membuat pesanan: server tidak mengembalikan ID pesanan.\nResponse: ' + JSON.stringify(json));
                    return;
                }

                // Show a Midtrans-like payment popup (user will click Complete to finish)
                hideLoading();
                openPaymentModal(json.order_id, json.total || 0);
            } catch (err) {
                console.error(err);
                alert('Terjadi kesalahan saat mencoba proses pembayaran.');
            } finally {
                // always hide loading spinner when finished (whether success or error)
                hideLoading();
            }
        }


        // Render awal saat halaman dimuat
        window.onload = function() {
            // If server didn't provide items, try to populate from localStorage cart
            try {
                if ((!checkoutData.items || checkoutData.items.length === 0)) {
                    const raw = localStorage.getItem('whispering_flora_cart');
                    if (raw) {
                        const parsed = JSON.parse(raw);
                        if (parsed && Array.isArray(parsed.items) && parsed.items.length > 0) {
                            checkoutData.items = parsed.items.map(p => {
                                // Normalize fields: accept either `price` numeric or string formats
                                let price = 0;
                                if (p.price !== undefined && p.price !== null) {
                                    price = typeof p.price === 'number' ? p.price : parseInt(String(p.price).replace(/[^0-9]/g, '')) || 0;
                                }
                                return {
                                    id: p.id ?? p.jenis_id ?? null,
                                    name: p.name ?? p.title ?? 'Produk',
                                    price: price,
                                    quantity: p.quantity || 1,
                                    imageUrl: p.imageUrl || p.image || (p.image_path ? '/storage/'+p.image_path : 'https://placehold.co/80x80/F9DCC4/5A4B4B?text=Produk')
                                };
                            });
                        }
                    }
                }
            } catch (e) {
                console.warn('Could not load local cart for checkout summary', e);
            }

            renderDetails();
            lucide.createIcons();
        };
    </script>
</head>
<body class="min-h-screen">

    @include('components.header')


    <div class="container mx-auto px-4 py-12 max-w-7xl">
        
        <h1 class="text-2xl sm:text-3xl title-display mb-10 font-medium text-text-dark">
            <a href="/cart" class="text-text-light hover:text-accent-strong transition">Keranjang Belanja</a> 
            <span class="font-bold text-accent-strong text-xl">&gt; Detail Pemesanan</span> 
            <span class="font-light text-text-light text-xl">&gt; Pesanan Selesai</span>
        </h1>

        <form onsubmit="proceedToPayment(event)" class="flex flex-wrap lg:flex-nowrap -mx-4">
            
            <div class="w-full lg:w-2/3 px-4">
                
                <div class="bg-white p-6 md:p-10 border border-bliss-2 rounded-xl shadow-lg mb-8">
                    <h2 class="text-xl font-bold title-display mb-6 text-accent-strong">1. Data Pelanggan & Pengiriman</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium mb-2">Nama Lengkap</label>
                            <input type="text" id="name" required class="form-input-bliss border" placeholder="Masukkan nama Anda">
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium mb-2">Nomor Telepon (WhatsApp)</label>
                            <input type="tel" id="phone" required class="form-input-bliss border" placeholder="Contoh: 0812...">
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="address" class="block text-sm font-medium mb-2">Alamat Lengkap Pengiriman</label>
                        <textarea id="address" rows="3" required class="form-input-bliss border" placeholder="Jalan, Nomor Rumah, RT/RW, Kecamatan, Kota"></textarea>
                    </div>
                    
                    <div class="mt-6">
                        <label for="notes" class="block text-sm font-medium mb-2">Catatan Tambahan (Opsional)</label>
                        <textarea id="notes" rows="2" class="form-input-bliss border" placeholder="Contoh: Pesan untuk florist, waktu pengiriman yang diinginkan"></textarea>
                    </div>

                </div>

                <div class="bg-white p-6 md:p-10 border border-bliss-2 rounded-xl shadow-lg">
                    <h2 class="text-xl font-bold title-display mb-6 text-accent-strong">2. Metode Pembayaran</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        
                        <div class="payment-option p-4 flex items-center gap-4 hover:border-accent-strong/50" data-method="bank_transfer"
                            onclick="selectPaymentMethod(this, 'Bank Transfer')">
                            <i data-lucide="credit-card" class="w-6 h-6 text-text-dark"></i>
                            <span class="font-medium">Transfer Bank (BCA / Mandiri)</span>
                        </div>
                        
                        <div class="payment-option p-4 flex items-center gap-4 hover:border-accent-strong/50" data-method="e_wallet"
                            onclick="selectPaymentMethod(this, 'E-Wallet')">
                            <i data-lucide="smartphone" class="w-6 h-6 text-text-dark"></i>
                            <span class="font-medium">E-Wallet (Gopay / OVO / Dana)</span>
                        </div>

                    </div>
                    
                    <p class="text-sm text-text-light mt-4">Anda akan diarahkan ke halaman pembayaran setelah mengklik tombol 'Bayar Sekarang'.</p>
                </div>
            </div> <div class="w-full lg:w-1/3 px-4 mt-10 lg:mt-0">
                <div class="bg-white p-6 border border-bliss-2 rounded-xl shadow-lg">
                    <h2 class="text-lg font-bold title-display mb-4 text-accent-strong">Ringkasan Pesanan</h2>

                    <div id="item-details-container" class="mb-4">
                        </div>
                    
                    <div class="space-y-2 py-4 border-t border-bliss-2">
                        <div class="flex justify-between text-sm">
                            <span>Subtotal Produk:</span>
                            <span id="subtotal-value" class="font-medium">Rp-,-</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span>Diskon:</span>
                            <span id="discount-value" class="font-medium text-red-500">- Rp0</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span>Biaya Pengiriman:</span>
                            <span id="shipping-value" class="font-medium text-bliss-success">Rp-,-</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between pt-4 font-bold text-xl title-display border-t border-text-dark/20 mt-2">
                        <span>TOTAL AKHIR</span>
                        <span id="total-value" class="text-accent-strong">Rp-,-</span>
                    </div>
                    
                    <button type="submit" class="btn-payment w-full text-center mt-6 px-6 py-3 text-white font-bold uppercase 
                                             rounded-lg transition duration-300 shadow-md">
                        BAYAR SEKARANG 
                        (<span id="total-value-cta">Rp-,-</span>)
                    </button>
                    
                    <p class="text-xs text-center text-text-light mt-4">
                        Dengan menekan tombol ini, Anda menyetujui <a href="#" class="underline hover:no-underline text-accent-strong">Syarat & Ketentuan</a> kami.
                    </p>
                </div>
            </div> </form> </div>

    <!-- Simulated payment removed: we redirect directly to confirmation on success -->

    </body>

</html>

    <!-- Midtrans-like payment popup (simplified) -->
    <div id="midtrans-popup" class="fixed inset-0 z-60 hidden items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-lg p-6 m-4">
            <div class="flex items-start justify-between">
                <h3 class="text-xl font-bold text-accent-strong">Pembayaran Selesai</h3>
                <button id="midtrans-close" class="text-text-light">×</button>
            </div>

            <div class="mt-4">
                <p class="text-sm text-text-dark">Pembayaran berhasil diproses. Detail pesanan:</p>

                <div class="mt-4 border rounded-lg p-4 bg-bliss-3">
                    <div class="flex justify-between mb-2"><strong>Order ID</strong><span id="mt-order-id">-</span></div>
                    <div class="flex justify-between"><strong>Total</strong><span id="mt-order-total">Rp-,-</span></div>
                </div>
            </div>

            <div class="mt-6 flex gap-3 justify-end">
                <button id="mt-complete" class="bg-accent-strong text-white px-4 py-2 rounded-md font-bold">Complete</button>
                <button id="mt-close-btn" class="px-4 py-2 rounded-md border">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        function openPaymentModal(orderId, total) {
            const popup = document.getElementById('midtrans-popup');
            if (!popup) return;
            document.getElementById('mt-order-id').textContent = orderId || '-';
            document.getElementById('mt-order-total').textContent = formatRupiah(total || 0);
            popup.classList.remove('hidden');
            popup.classList.add('flex');

            // handlers
            document.getElementById('midtrans-close').onclick = closePopup;
            document.getElementById('mt-close-btn').onclick = closePopup;

            // store info on popup element to avoid closure/scope pitfalls
            popup.dataset.orderNumber = orderId || '';
            popup.dataset.orderTotal = total || 0;

            const completeBtn = document.getElementById('mt-complete');
            completeBtn.onclick = async function(){
                // disable button while processing
                completeBtn.disabled = true;
                const orderNumber = popup.dataset.orderNumber || orderId || '';
                try {
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const resp = await fetch("{{ route('pesanan.complete') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json'
                        },
                            credentials: 'same-origin',
                        body: JSON.stringify({ order_number: orderNumber })
                    });

                    let j = null;
                    try {
                        j = await resp.json();
                    } catch (parseErr) {
                        const text = await resp.text();
                        console.error('Non-JSON response from /pesanan/complete:', resp.status, text);
                        alert('Gagal menyelesaikan pembayaran: Server returned non-JSON response (see console)');
                        return;
                    }

                    console.log('Complete response', resp.status, j);
                    if (resp.ok && j.status === 'ok') {
                        closePopup();
                        window.location = "{{ route('pesanan.confirmation') }}?status=success&order_id=" + encodeURIComponent(orderNumber || '');
                        return;
                    }

                    // show error message returned by server, if any
                    alert('Gagal menyelesaikan pembayaran: ' + (j.error || JSON.stringify(j)));
                } catch (e) {
                    console.error(e);
                    alert('Terjadi kesalahan saat menyelesaikan pembayaran (cek console).');
                } finally {
                    completeBtn.disabled = false;
                }
            };

            function closePopup(){
                popup.classList.add('hidden');
                popup.classList.remove('flex');
            }
        }
    </script>