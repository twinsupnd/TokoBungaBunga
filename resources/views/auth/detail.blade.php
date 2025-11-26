<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Pastel Bliss (View)</title>
    <!-- Load Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Load required fonts: Playfair Display for titles, Quicksand for body text, and Inter as fallback -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    
    <style>
        /* Variabel CSS untuk Palet Warna "Pastel Bliss" */
        :root {
            --color-pastel-bliss-1: #FFB5A7; 
            --color-pastel-bliss-2: #FCD5CE; 
            --color-pastel-bliss-3: #F8EDEB; 
            --color-pastel-bliss-5: #FEC89A; 
            --color-text-dark: #5A4B4B; 
            --color-text-light: #8C7878;
            --color-accent-strong: #ED3878;
            --color-bliss-success: #78C257; 
            --font-display: 'Playfair Display', serif;
            --font-body: 'Quicksand', sans-serif;
        }
        
        body {
            background-color: var(--color-pastel-bliss-3);
            font-family: var(--font-body), 'Inter', sans-serif;
            color: var(--color-text-dark);
        }
        
        .title-display {
            font-family: var(--font-display);
        }
        
        .quantity-input {
            border-color: var(--color-pastel-bliss-2);
            background-color: white;
            color: var(--color-text-dark);
            transition: border-color 0.3s;
        }

        .quantity-input:focus {
            border-color: var(--color-pastel-bliss-1);
            outline: none;
            box-shadow: 0 0 0 2px rgba(255, 181, 167, 0.4);
        }
        
        /* Message Box Styling (Pengganti alert/confirm) */
        #status-message-box {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.5s, transform 0.5s;
            transform: translateY(-20px);
            pointer-events: none;
        }
        #status-message-box.show {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }


        /* Penyesuaian Responsif */
        @media (max-width: 640px) {
            /* Sembunyikan Price di Mobile */
            .cart-item-grid > div:nth-child(2) { display: none; } 
            
            /* Atur lebar kolom di Mobile */
            .cart-item-grid > div:nth-child(1) { width: 60%; } /* Detail Item */
            .cart-item-grid > div:nth-child(3) { width: 20%; } /* Qty */
            .cart-item-grid > div:nth-child(4) { width: 20%; } /* Subtotal */
        }

    </style>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'bliss-1': 'var(--color-pastel-bliss-1)',
                        'bliss-5': 'var(--color-pastel-bliss-5)',
                        'text-dark': 'var(--color-text-dark)',
                        'text-light': 'var(--color-text-light)',
                        'accent-strong': 'var(--color-accent-strong)',
                        'bliss-success': 'var(--color-bliss-success)',
                        'accent-light-bg': 'rgba(237, 56, 120, 0.1)', 
                    }
                }
            }
        };

        // --- Data yang Seharusnya Diinjeksikan oleh Controller (PHP) ---
        /*
         * Dalam aplikasi PHP nyata, data ini akan dicetak dari $cartData:
         * const initialCartData = <?php echo json_encode($cartData); ?>;
         */
        
        // Data Simulasi (Fallback untuk pengujian View saja)
        let cartData = {
            items: [
                { id: 1, name: 'Natural Hand Cream (Rose)', price: 125000, quantity: 2 },
                { id: 2, name: 'Silk Sleep Mask (Peach)', price: 89000, quantity: 1 },
                { id: 3, name: 'Aromatic Candle Set', price: 210000, quantity: 3 }
            ],
            summary: { subtotal: 914000, shipping: 0, total: 914000 }
        };

        // Fungsi Helper untuk format Rupiah
        function formatRupiah(number) {
            if (typeof number === 'number') {
                return 'Rp' + number.toLocaleString('id-ID');
            }
            return 'Rp0';
        }
        
        // Fungsi pengganti alert/confirm
        function showStatusMessage(message, type = 'success') {
            console.log(`[STATUS ${type.toUpperCase()}]: ${message}`);
            const box = document.getElementById('status-message-box');
            box.textContent = message;
            box.className = 'p-4 rounded-lg shadow-xl text-white font-semibold transition-all duration-300';
            
            if (type === 'success') {
                box.classList.add('bg-bliss-success');
            } else if (type === 'error') {
                box.classList.add('bg-red-500');
            } else {
                box.classList.add('bg-bliss-5');
            }
            
            box.classList.add('show');
            setTimeout(() => {
                box.classList.remove('show');
            }, 3000);
        }


        // Fungsi untuk mengirim permintaan perubahan kuantitas ke Controller (Simulasi Fetch)
        async function updateQuantity(inputElement) {
            const id = parseInt(inputElement.getAttribute('data-id'));
            const newQuantity = parseInt(inputElement.value);

            if (newQuantity < 1 || isNaN(newQuantity)) {
                showStatusMessage('Kuantitas minimal adalah 1.', 'error');
                inputElement.value = 1;
                return;
            }

            // SIMULASI: Dalam lingkungan PHP, ini akan memanggil DetailController.php::updateQuantityApi
            // Karena ini hanya HTML, kita akan mensimulasikan respons sukses setelah 500ms
            showStatusMessage(`Memperbarui item ${id}...`, 'info');

            try {
                // Simulasi AJAX call ke Controller
                await new Promise(resolve => setTimeout(resolve, 500)); 

                // --- START Simulasi Respons Controller ---
                const itemIndex = cartData.items.findIndex(i => i.id === id);
                if (itemIndex > -1) {
                    cartData.items[itemIndex].quantity = newQuantity;
                    // Recalculate summary manually for simulation
                    let newSubtotal = cartData.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                    cartData.summary.subtotal = newSubtotal;
                    cartData.summary.total = newSubtotal + cartData.summary.shipping;

                    const result = { status: 'success', summary: cartData.summary };
                    // --- END Simulasi Respons Controller ---

                    if (result.status === 'success') {
                        cartData.summary = result.summary; 
                        renderCart();
                        showStatusMessage('Kuantitas berhasil diperbarui!', 'success');
                    } else {
                        showStatusMessage('Gagal memperbarui kuantitas: ' + result.message, 'error');
                    }
                } else {
                    showStatusMessage('Item tidak ditemukan.', 'error');
                }

            } catch (error) {
                console.error('Error saat update:', error);
                showStatusMessage('Terjadi kesalahan saat menghubungi server.', 'error');
            }
        }
        
        // Fungsi untuk mengirim permintaan penghapusan item ke Controller (Simulasi Fetch)
        async function removeItem(id) {
            // Pengganti window.confirm()
            if (!window.confirm('Anda yakin ingin menghapus item ini dari keranjang?')) return;
            
            showStatusMessage(`Menghapus item ${id}...`, 'info');
            
            try {
                // Simulasi AJAX call ke Controller
                await new Promise(resolve => setTimeout(resolve, 500)); 

                // --- START Simulasi Respons Controller ---
                const initialLength = cartData.items.length;
                cartData.items = cartData.items.filter(item => item.id !== id);
                
                if (cartData.items.length < initialLength) {
                    // Recalculate summary manually for simulation
                    let newSubtotal = cartData.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                    cartData.summary.subtotal = newSubtotal;
                    cartData.summary.total = newSubtotal + cartData.summary.shipping;

                    const result = { status: 'success', summary: cartData.summary };
                    // --- END Simulasi Respons Controller ---

                    if (result.status === 'success') {
                        cartData.summary = result.summary;
                        renderCart();
                        showStatusMessage('Item berhasil dihapus!', 'success');
                    } else {
                        showStatusMessage('Gagal menghapus item: ' + result.message, 'error');
                    }
                } else {
                    showStatusMessage('Item gagal dihapus (tidak ditemukan).', 'error');
                }
            } catch (error) {
                console.error('Error saat menghapus:', error);
                showStatusMessage('Terjadi kesalahan saat menghubungi server.', 'error');
            }
        }


        // Fungsi untuk merender ulang seluruh isi keranjang berdasarkan data 'cartData' saat ini
        function renderCart() {
            const itemsContainer = document.getElementById('cart-items-container');
            itemsContainer.innerHTML = ''; 

            if (cartData.items.length === 0) {
                itemsContainer.innerHTML = '<p class="text-text-light py-8 text-center border border-bliss-2 rounded-lg bg-white mt-4">Keranjang Anda kosong. Yuk, cari produk lucu!</p>';
            }

            cartData.items.forEach(item => {
                const subtotalItem = item.price * item.quantity;

                const itemHtml = `
                    <div class="flex items-center border-b border-bliss-2 py-4 text-text-dark cart-item-grid">
                        <!-- Detail Produk -->
                        <div class="w-full sm:w-1/2 flex items-center pr-2">
                            <button class="text-accent-strong mr-2 text-xl hover:opacity-75 transition focus:outline-none" 
                                title="Hapus Item" onclick="removeItem(${item.id})">&times;</button>
                            <img src="https://placehold.co/80x80/FFB5A7/5A4B4B?text=IMG" 
                                alt="${item.name}" class="w-16 h-16 sm:w-20 sm:h-20 object-cover rounded-lg mr-4 border border-bliss-2">
                            <span class="text-sm sm:text-base font-medium">${item.name}</span>
                        </div>

                        <!-- Harga (Sembunyi di Mobile) -->
                        <div class="w-1/6 text-left font-light hidden sm:block">
                            ${formatRupiah(item.price)}
                        </div>

                        <!-- Kuantitas (Quantity) -->
                        <div class="w-1/4 sm:w-1/6 text-center flex justify-center">
                            <input type="number" value="${item.quantity}" min="1" data-id="${item.id}"
                                onchange="updateQuantity(this)"
                                class="w-12 sm:w-16 quantity-input border rounded-lg text-center py-1 text-sm">
                        </div>
                        
                        <!-- Subtotal Item -->
                        <div class="w-1/2 sm:w-1/6 text-right font-semibold">
                            ${formatRupiah(subtotalItem)}
                        </div>
                    </div>
                `;
                itemsContainer.innerHTML += itemHtml;
            });

            // Update Ringkasan Total
            if (cartData.summary) {
                document.getElementById('subtotal-value').textContent = formatRupiah(cartData.summary.subtotal);
                document.getElementById('total-value').textContent = formatRupiah(cartData.summary.total);
            }
            
            // Tampilkan/Sembunyikan summary
            const totalsCard = document.getElementById('cart-totals-card');
            if (totalsCard) {
                 totalsCard.style.display = cartData.items.length > 0 ? 'block' : 'none';
            }
           
        }

        // Render awal saat halaman dimuat
        window.onload = renderCart;
    </script>
</head>
<body class="min-h-screen">
    <div id="status-message-box"></div>

    <div class="container mx-auto px-4 py-8 max-w-7xl">
        
        <!-- Judul dan Breadcrumb -->
        <h1 class="text-2xl sm:text-3xl title-display mb-8 font-light text-text-dark">
            Keranjang Belanja &gt; 
            <span class="font-semibold text-text-light">Detail Pemesanan</span> &gt; Pesanan Selesai
        </h1>
        
        <!-- Main Content Area: Dua Kolom -->
        <div class="flex flex-wrap lg:flex-nowrap -mx-4">
            
            <!-- KOLOM KIRI: PRODUK DI KERANJANG -->
            <div class="w-full lg:w-3/4 px-4">
                <h2 class="text-xs sm:text-sm font-bold tracking-wider uppercase text-text-light mb-4">PRODUCT</h2>
                
                <!-- Table Header -->
                <div class="hidden sm:flex items-center text-xs font-semibold uppercase text-text-light border-b border-bliss-2 pb-2 mb-2">
                    <div class="w-1/2">Item</div>
                    <div class="w-1/6 text-left">Price</div>
                    <div class="w-1/6 text-center">Qty</div>
                    <div class="w-1/6 text-right">Subtotal</div>
                </div>

                <!-- Item List Container -->
                <div id="cart-items-container">
                    <!-- Item akan dirender di sini oleh JavaScript -->
                </div>
                
                <!-- Tombol Lanjutkan Belanja -->
                <div class="mt-8">
                    <a href="#" class="inline-block px-6 py-2 border border-accent-strong text-accent-strong font-medium 
                                 tracking-wider uppercase text-sm rounded-lg transition duration-300 
                                 hover:bg-accent-light-bg hover:shadow-lg">
                        &larr; LANJUTKAN BELANJA
                    </a>
                </div>
            </div> <!-- End Kolom Kiri -->
            
            <!-- KOLOM KANAN: RINGKASAN TOTAL -->
            <div class="w-full lg:w-1/4 px-4 mt-10 lg:mt-0" id="cart-totals-card">
                <h2 class="text-xs sm:text-sm font-bold tracking-wider uppercase text-text-light mb-4">RINGKASAN</h2>
                
                <div class="bg-white p-6 border border-bliss-2 rounded-xl shadow-lg">
                    <!-- Subtotal -->
                    <div class="flex justify-between py-2 border-b border-bliss-2">
                        <span>Subtotal</span>
                        <span id="subtotal-value" class="font-semibold text-text-dark">Rp-,-</span>
                    </div>
                    
                    <!-- Shipping -->
                    <div class="py-2 border-b border-bliss-2">
                        <div class="flex justify-between">
                            <span>Pengiriman</span>
                            <span class="font-semibold text-bliss-success">Gratis</span>
                        </div>
                        <div class="text-right text-xs text-text-light mt-1">
                            Pengiriman ke DKI Jakarta. <a href="#" class="text-accent-strong underline hover:no-underline">Ubah alamat</a>
                        </div>
                    </div>
                    
                    <!-- Total -->
                    <div class="flex justify-between py-2 font-bold text-xl title-display mt-2">
                        <span>TOTAL</span>
                        <span id="total-value" class="text-accent-strong">Rp-,-</span>
                    </div>
                    
                    <!-- Tombol Checkout -->
                    <a href="#" class="block text-center mt-6 px-6 py-3 bg-bliss-5 text-white font-bold uppercase 
                                 hover:bg-bliss-1 rounded-lg transition duration-300 shadow-md">
                        LANJUT KE CHECKOUT
                    </a>
                    
                    <!-- Coupon Code -->
                    <div class="mt-8 pt-4 border-t border-bliss-2">
                        <p class="text-sm text-text-dark mb-2 font-medium">Kupon</p>
                        <input type="text" placeholder="Kode kupon" class="w-full p-2 border border-bliss-2 rounded-lg mb-3 quantity-input">
                        <button class="w-full p-2 bg-bliss-1 text-white font-bold uppercase rounded-lg 
                                         hover:bg-accent-strong transition duration-300 shadow-sm">
                            Gunakan Kupon
                        </button>
                    </div>
                </div>
            </div> <!-- End Kolom Kanan -->
            
        </div> <!-- End Flex Wrapper -->
    </div>
</body>
</html>