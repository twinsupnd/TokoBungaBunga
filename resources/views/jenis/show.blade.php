<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $jenis->name ?? 'Produk' }} - Whispering Flora</title>
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/css/product-detail.css'])
</head>
<body>
    @include('components.header')

    <div class="product-detail-container">
        <a href="/" class="product-back-link">← Kembali ke Beranda</a>
    </div>

    <div class="product-detail-container">
        <div class="product-detail-grid">
            <div class="product-detail-image">
                <img src="{{ asset('images/' . ($jenis->image ?? 'babybreath.jpg')) }}" alt="{{ $jenis->name }}">
            </div>

            <div class="product-detail-info">
                <h1>{{ $jenis->name ?? 'Produk' }}</h1>
                <p class="product-detail-price">{{ $jenis->price ?? '-' }}</p>

                <p class="product-detail-description">
                    {{ $jenis->description ?? 'Deskripsi produk tidak tersedia.' }}
                </p>

                <label class="product-date-label">Tanggal Pengiriman <span>*</span></label>
                <input type="date" class="product-date-input" placeholder="Pilih Tanggal Pengiriman Bunga">

                <div class="product-qty-box">
                    <button class="product-qty-btn qty-minus">−</button>
                    <input type="number" class="product-qty-input qty-input" value="2" min="1">
                    <button class="product-qty-btn qty-plus">+</button>
                </div>

                <button class="product-add-cart-btn">ADD TO CART</button>

                <div class="product-meta-section">
                    <div class="product-meta-row">
                        <div class="product-meta-label">SKU</div>
                        <div class="product-meta-value">JNS-{{ str_pad($jenis->id ?? 0, 4, '0', STR_PAD_LEFT) }}</div>
                    </div>

                    <div class="product-meta-row">
                        <div class="product-meta-label">Categories</div>
                        <div class="product-meta-value">
                            <a href="#">Buket Bunga Tulip</a>, <a href="#">Bunga Meja</a>
                        </div>
                    </div>

                    <div class="product-meta-row">
                        <div class="product-meta-label">Tags</div>
                        <div class="product-meta-value">
                            <a href="#">Get Well Soon</a>, <a href="#">Rangkaian Bunga</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fungsi helper untuk format Rupiah (sama seperti di cart.blade.php)
        function formatRupiah(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(amount);
        }

        // Parse harga dari string "Rp X.XXX.XXX" ke number
        function parsePriceFromText(priceText) {
            const cleanedPrice = priceText.replace(/[^\d]/g, '');
            return parseInt(cleanedPrice) || 0;
        }

        // Quantity increment/decrement
        const qtyInput = document.querySelector('.qty-input');
        const btnMinus = document.querySelector('.qty-minus');
        const btnPlus = document.querySelector('.qty-plus');

        btnMinus.addEventListener('click', () => {
            let val = parseInt(qtyInput.value);
            if (val > 1) qtyInput.value = val - 1;
        });

        btnPlus.addEventListener('click', () => {
            qtyInput.value = parseInt(qtyInput.value) + 1;
        });

        // Add to cart button - connect dengan cart system
        document.querySelector('.product-add-cart-btn').addEventListener('click', () => {
            // Get form data
            const productName = document.querySelector('.product-detail-info h1').textContent;
            const priceText = document.querySelector('.product-detail-price').textContent;
            const productPrice = parsePriceFromText(priceText);
            const quantity = parseInt(qtyInput.value) || 1;
            const deliveryDate = document.querySelector('.product-date-input').value;
            const imageUrl = document.querySelector('.product-detail-image img').src;

            // Validate delivery date
            if (!deliveryDate) {
                alert('Mohon pilih tanggal pengiriman!');
                return;
            }

            // Create product object matching cart structure
            const newProduct = {
                id: {{ $jenis->id ?? 'Date.now()' }},
                name: productName,
                price: productPrice,
                quantity: quantity,
                imageUrl: imageUrl,
                deliveryDate: deliveryDate
            };

            // Initialize cartData if doesn't exist
            if (typeof window.cartData === 'undefined') {
                window.cartData = {
                    items: [],
                    summary: { subtotal: 0, shipping: 50000, discount: 0, total: 0 }
                };
            }

            // Check if product already in cart - update quantity or add new
            const existingItem = window.cartData.items.find(item => 
                item.id === newProduct.id && item.deliveryDate === deliveryDate
            );
            
            if (existingItem) {
                existingItem.quantity += quantity;
            } else {
                window.cartData.items.push(newProduct);
            }

            // Update cart count in header
            const cartCountBadge = document.getElementById('cart-count-badge');
            if (cartCountBadge) {
                const totalItems = window.cartData.items.reduce((sum, item) => sum + item.quantity, 0);
                cartCountBadge.textContent = totalItems;
            }

            // Save to localStorage for persistence
            try {
                localStorage.setItem('whispering_flora_cart', JSON.stringify(window.cartData));
            } catch (e) {
                console.log('localStorage tidak tersedia:', e);
            }

            // Redirect to cart immediately
            @auth
                window.location.href = '{{ route("cart") }}';
            @else
                // If not logged in, show login modal or redirect to login
                window.location.href = '{{ route("login") }}';
            @endauth
        });

        // Load cart from localStorage on page load
        window.addEventListener('load', () => {
            try {
                const savedCart = localStorage.getItem('whispering_flora_cart');
                if (savedCart) {
                    window.cartData = JSON.parse(savedCart);
                }
            } catch (e) {
                console.log('Error loading cart from localStorage:', e);
            }
        });
    </script>
</body>
</html>
