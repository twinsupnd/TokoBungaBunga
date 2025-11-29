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

        // --- MODEL DATA SIMULASI CHECKOUT ---
        // Data ini biasanya diambil dari sesi atau database setelah konfirmasi keranjang
        let checkoutData = {
            items: [
                { id: 1, name: 'Baby Blooms Bouquet', price: 550000, quantity: 2, imageUrl: 'https://placehold.co/80x80/FFB5A7/5A4B4B?text=Bouquet' },
                { id: 2, name: 'Aromatic Candle Set (Peony)', price: 210000, quantity: 3, imageUrl: 'https://placehold.co/80x80/F9DCC4/5A4B4B?text=Candle' }
            ],
            shipping: 40000, // Simulasi Ongkir
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

        function proceedToPayment(event) {
            event.preventDefault(); // Mencegah form submit default

            // 1. Validasi Formulir (Simulasi)
            const name = document.getElementById('name').value;
            const phone = document.getElementById('phone').value;
            const address = document.getElementById('address').value;

            if (!name || !phone || !address) {
                alert("Mohon lengkapi semua data pelanggan dan pengiriman!");
                return;
            }

            // 2. Simulasi Proses Pembayaran
            alert(`Berhasil! Pesanan untuk ${name} (Total: ${formatRupiah(checkoutData.total)}) siap diproses ke Pembayaran. (Simulasi selesai)`);
            
            // Di lingkungan nyata, Anda akan:
            // a. Mengirim data form dan cart ke server.
            // b. Menerima token pembayaran dari gateway (Midtrans/Xendit).
            // c. Redirect ke halaman pembayaran atau membuka modal pembayaran.
        }


        // Render awal saat halaman dimuat
        window.onload = function() {
            renderDetails();
            lucide.createIcons();
        };
    </script>
</head>
<body class="min-h-screen">

    <header class="header container mx-auto px-4 max-w-7xl">
        <a href="#" class="logo-container">
            <div class="text-2xl font-bold title-display text-accent-strong">Whispering Flora</div>
        </a>
        <nav class="hidden md:flex space-x-8 text-sm font-medium">
            <a href="#" class="header-nav-link">KATALOG</a>
            <a href="#" class="header-nav-link">TENTANG KAMI</a>
            <a href="#" class="header-nav-link">HUBUNGI KAMI</a>
        </nav>
        <div class="flex items-center space-x-6">
            <i data-lucide="heart" class="w-5 h-5 text-text-light cursor-pointer hover:text-accent-strong"></i>
            <i data-lucide="user" class="w-5 h-5 text-text-light cursor-pointer hover:text-accent-strong"></i>
            <div class="relative">
                <i data-lucide="shopping-bag" class="w-5 h-5 text-text-dark cursor-pointer"></i>
                <span class="absolute -top-3 -right-3 text-xs bg-accent-strong text-white rounded-full h-5 w-5 flex items-center justify-center font-bold">
                    ${checkoutData.items.reduce((sum, item) => sum + item.quantity, 0)} 
                </span>
            </div>
        </div>
    </header>


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
                        
                        <div class="payment-option p-4 flex items-center gap-4 hover:border-accent-strong/50" 
                            onclick="selectPaymentMethod(this, 'Bank Transfer')">
                            <i data-lucide="credit-card" class="w-6 h-6 text-text-dark"></i>
                            <span class="font-medium">Transfer Bank (BCA / Mandiri)</span>
                        </div>
                        
                        <div class="payment-option p-4 flex items-center gap-4 hover:border-accent-strong/50" 
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

</body>
</html>