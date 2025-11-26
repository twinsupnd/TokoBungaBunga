<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Pastel Bliss</title>
    <!-- Load Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Load required fonts: Playfair Display for titles, Quicksand for body text, and Inter as fallback -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    
    <style>
        /* Variabel CSS untuk Palet Warna "Pastel Bliss" */
        :root {
            --color-pastel-bliss-1: #FFB5A7; /* Primer Pink - digunakan untuk tombol utama dan hover */
            --color-pastel-bliss-2: #FCD5CE; /* Light Pink - digunakan untuk garis pembatas */
            --color-pastel-bliss-3: #F8EDEB; /* Off-White/Lightest Pink (Background) */
            --color-pastel-bliss-4: #F9DCC4; /* Light Peach */
            --color-pastel-bliss-5: #FEC89A; /* Peach/Orange Tone (Accent) - digunakan untuk tombol Checkout */
            
            /* Warna tambahan untuk teks dan tombol agar kontras */
            --color-text-dark: #5A4B4B; /* Darker tone for readability */
            --color-text-light: #8C7878; /* Muted tone for sub-text */
            --color-button-primary: #B2967D; /* Muted Brown */
            --color-accent-strong: #ED3878; /* Deep Pink - digunakan untuk tombol hapus & link penekanan */
            
            --color-bliss-success: #78C257; /* Custom success/green tone */

            --font-display: 'Playfair Display', serif;
            --font-body: 'Quicksand', sans-serif;
        }
        
        /* Apply Custom Fonts and Background */
        body {
            background-color: var(--color-pastel-bliss-3);
            font-family: var(--font-body), 'Inter', sans-serif;
            color: var(--color-text-dark);
        }
        
        .title-display {
            font-family: var(--font-display);
        }
        
        /* Custom styles for the quantity input (to match aesthetic) */
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

        /* Responsive adjustments for mobile: hide price column and adjust font size */
        @media (max-width: 640px) {
            .cart-item-grid > div:nth-child(2) { 
                display: none; /* Hide Price on small screens */
            }
            .cart-item-grid > div:nth-child(4) { 
                font-size: 0.8rem; /* Make subtotal text smaller */
            }
            .cart-item-grid > div:nth-child(1) {
                 width: 60%; /* Make Product Name column wider */
            }
            .cart-item-grid > div:nth-child(3) {
                 width: 20%; /* Keep Qty column narrow */
            }
            .cart-item-grid > div:nth-child(4) {
                 width: 20%; /* Subtotal column width */
            }
        }

    </style>

    <script>
        // Tailwind Customization: Mapping CSS variables to utility classes
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        // Pastel Bliss Palette Mapping
                        'bliss-1': 'var(--color-pastel-bliss-1)',
                        'bliss-2': 'var(--color-pastel-bliss-2)',
                        'bliss-3': 'var(--color-pastel-bliss-3)',
                        'bliss-4': 'var(--color-pastel-bliss-4)',
                        'bliss-5': 'var(--color-pastel-bliss-5)',

                        // Semantic Colors
                        'text-dark': 'var(--color-text-dark)',
                        'text-light': 'var(--color-text-light)',
                        'accent-strong': 'var(--color-accent-strong)',
                        'button-primary': 'var(--color-button-primary)',
                        'bliss-success': 'var(--color-bliss-success)',
                        
                        // Custom hover/utility colors
                        'accent-light-bg': 'rgba(237, 56, 120, 0.1)', // Light tint of accent-strong for background hover
                    },
                    fontFamily: {
                        'display': ['Playfair Display', 'serif'],
                        'body': ['Quicksand', 'sans-serif'],
                    }
                }
            }
        }

        // --- Simulated Data and Logic (Menggantikan Backend/Blade) ---
        const cartData = {
            items: [
                { id: 1, name: 'Natural Hand Cream (Rose)', price: 125000, quantity: 2 },
                { id: 2, name: 'Silk Sleep Mask (Peach)', price: 89000, quantity: 1 },
                { id: 3, name: 'Aromatic Candle Set', price: 210000, quantity: 3 }
            ],
            subtotal: 0,
            total: 0
        };

        // Fungsi untuk menghitung total keranjang
        function calculateTotals() {
            let subtotal = 0;
            cartData.items.forEach(item => {
                subtotal += item.price * item.quantity;
            });
            cartData.subtotal = subtotal;
            // Di sini, kita asumsikan pengiriman gratis (Shipping = 0)
            cartData.total = subtotal; 
        }

        // Fungsi untuk memformat angka ke Rupiah
        function formatRupiah(number) {
            return 'Rp' + number.toLocaleString('id-ID');
        }

        // Fungsi untuk merender ulang seluruh isi keranjang
        function renderCart() {
            calculateTotals();

            const itemsContainer = document.getElementById('cart-items-container');
            itemsContainer.innerHTML = ''; // Hapus item lama

            if (cartData.items.length === 0) {
                 itemsContainer.innerHTML = '<p class="text-text-light py-8 text-center border border-bliss-2 rounded-lg bg-white mt-4">Keranjang Anda kosong. Yuk, cari produk lucu!</p>';
            }

            cartData.items.forEach(item => {
                const subtotalItem = item.price * item.quantity;

                const itemHtml = `
                    <div class="flex items-center border-b border-bliss-2 py-4 text-text-dark cart-item-grid">
                        <!-- Detail Produk (w-1/2 di desktop, w-full di mobile) -->
                        <div class="w-full sm:w-1/2 flex items-center pr-2">
                            <button class="text-accent-strong mr-2 text-xl hover:opacity-75 transition" 
                                title="Hapus Item" onclick="removeItem(${item.id})">&times;</button>
                            <img src="https://placehold.co/80x80/FCD5CE/5A4B4B?text=IMG" 
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

            // Update Totals Summary
            document.getElementById('subtotal-value').textContent = formatRupiah(cartData.subtotal);
            document.getElementById('total-value').textContent = formatRupiah(cartData.total);
            
            // Sembunyikan summary jika keranjang kosong
            const totalsCard = document.getElementById('cart-totals-card');
            totalsCard.style.display = cartData.items.length > 0 ? 'block' : 'none';
        }

        // Fungsi untuk memperbarui kuantitas
        function updateQuantity(inputElement) {
            const id = parseInt(inputElement.getAttribute('data-id'));
            const newQuantity = parseInt(inputElement.value);

            const itemIndex = cartData.items.findIndex(item => item.id === id);
            if (itemIndex > -1 && newQuantity > 0) {
                cartData.items[itemIndex].quantity = newQuantity;
                renderCart(); // Render ulang untuk update subtotal
            } else if (newQuantity < 1) {
                inputElement.value = 1; // Cegah kuantitas di bawah 1
            }
        }

        // Fungsi untuk menghapus item
        function removeItem(id) {
            cartData.items = cartData.items.filter(item => item.id !== id);
            renderCart();
        }

        // Render awal saat halaman dimuat
        window.onload = renderCart;
    </script>
</head>
<body class="min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        
        <!-- Judul dan Breadcrumb -->
        <h1 class="text-2xl sm:text-3xl title-display mb-8 font-light text-text-dark">
            Keranjang Belanja &gt; 
            <span class="font-semibold text-text-light">Detail Pemesanan</span> &gt; Pesanan Selesai
        </h1>
        
        <!-- Main Content Area: Dua Kolom (Produk dan Ringkasan Total) -->
        <div class="flex flex-wrap lg:flex-nowrap -mx-4">
            
            <!-- KOLOM KIRI: PRODUK DI KERANJANG (8/12 lebar) -->
            <div class="w-full lg:w-3/4 px-4">
                <h2 class="text-xs sm:text-sm font-bold tracking-wider uppercase text-text-light mb-4">PRODUCT</h2>
                
                <!-- Table Header (Hanya tampil di desktop/tablet) -->
                <div class="hidden sm:flex items-center text-xs font-semibold uppercase text-text-light border-b border-bliss-2 pb-2 mb-2">
                    <div class="w-1/2">Item</div>
                    <div class="w-1/6 text-left">Price</div>
                    <div class="w-1/6 text-center">Qty</div>
                    <div class="w-1/6 text-right">Subtotal</div>
                </div>

                <!-- Item List Container -->
                <div id="cart-items-container">
                    <!-- Items will be injected here by JavaScript -->
                </div>
                
                <!-- Tombol Lanjutkan Belanja -->
                <div class="mt-8">
                    <a href="#" class="inline-block px-6 py-2 border border-accent-strong text-accent-strong font-medium 
                                      tracking-wider uppercase text-sm rounded-lg transition duration-300 
                                      hover:bg-accent-light-bg hover:shadow-lg">
                        &larr; CONTINUE SHOPPING
                    </a>
                </div>
            </div> <!-- End Kolom Kiri -->
            
            <!-- KOLOM KANAN: RINGKASAN TOTAL (4/12 lebar) -->
            <div class="w-full lg:w-1/4 px-4 mt-10 lg:mt-0" id="cart-totals-card">
                <h2 class="text-xs sm:text-sm font-bold tracking-wider uppercase text-text-light mb-4">CART TOTALS</h2>
                
                <div class="bg-white p-6 border border-bliss-2 rounded-xl shadow-lg">
                    <!-- Subtotal -->
                    <div class="flex justify-between py-2 border-b border-bliss-2">
                        <span>Subtotal</span>
                        <span id="subtotal-value" class="font-semibold text-text-dark">Rp0</span>
                    </div>
                    
                    <!-- Shipping -->
                    <div class="py-2 border-b border-bliss-2">
                        <div class="flex justify-between">
                            <span>Shipping</span>
                            <span class="font-semibold text-bliss-success">Free shipping</span>
                        </div>
                        <div class="text-right text-xs text-text-light mt-1">
                            Shipping to DKI Jakarta. <a href="#" class="text-accent-strong underline hover:no-underline">Change address</a>
                        </div>
                    </div>
                    
                    <!-- Total -->
                    <div class="flex justify-between py-2 font-bold text-xl title-display mt-2">
                        <span>Total</span>
                        <span id="total-value" class="text-accent-strong">Rp0</span>
                    </div>
                    
                    <!-- Tombol Checkout -->
                    <a href="#" class="block text-center mt-6 px-6 py-3 bg-bliss-5 text-white font-bold uppercase 
                                      hover:bg-bliss-1 rounded-lg transition duration-300 shadow-md">
                        PROCEED TO CHECKOUT
                    </a>
                    
                    <!-- Coupon Code -->
                    <div class="mt-8 pt-4 border-t border-bliss-2">
                        <p class="text-sm text-text-dark mb-2 font-medium">Coupon</p>
                        <input type="text" placeholder="Coupon code" class="w-full p-2 border border-bliss-2 rounded-lg mb-3 quantity-input">
                        <button class="w-full p-2 bg-bliss-1 text-white font-bold uppercase rounded-lg 
                                       hover:bg-accent-strong transition duration-300 shadow-sm">
                            Apply coupon
                        </button>
                    </div>
                </div>
            </div> <!-- End Kolom Kanan -->
            
        </div> <!-- End Flex Wrapper -->
    </div>
</body>
</html>