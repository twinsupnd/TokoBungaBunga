<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Keranjang Belanja</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />

    <style>
        :root {
            /* Definisi Dummy untuk Variabel Tema "Pastel Bliss" */
            --font-body: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            --font-display: 'Georgia', serif;
            --color-text-dark: #333;
            --color-accent-strong: #DE5C88; /* Merah Muda Kuat */
            --color-button-primary: #8D497A; /* Ungu Gelap */
            --color-pastel-bliss-1: #FDD7E4; /* Pastel Sangat Muda */
            --color-pastel-bliss-2: #FCE1E7; /* Pastel Muda */
            --color-pastel-bliss-5: #E794B2; /* Pastel Sedang */
        }
    </style>

    <style>
        /* Wrapper utama halaman (mengganti .cart-container) */
        .card-custom {
            max-width: 1100px;
            margin: 120px auto 80px;
            padding: 30px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.05);
            font-family: var(--font-body);
            color: var(--color-text-dark);
        }
        
        /* Judul halaman (menggunakan class Bootstrap h4/fw-bold) */
        .cart-title-custom {
            font-family: var(--font-display);
            font-size: 36px;
            color: var(--color-accent-strong);
            text-align: center;
            margin-bottom: 35px;
        }

        /* Tabel item keranjang (mengganti cart-table, fokus pada item-nya) */
        .cart-item-custom {
            transition: all 0.2s;
            border-bottom: 1px solid #f1dada !important; /* Overwrite Bootstrap border */
            padding: 20px 0 !important;
        }

        .cart-item-custom:hover {
            background: var(--color-pastel-bliss-1);
        }

        /* Gambar produk (mengganti .cart-item-image) */
        .cart-img-custom {
            width: 90px;
            height: 90px;
            border-radius: 12px;
            object-fit: cover;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        }

        /* ================================
           BUTTON QUANTITY (+) & (–)
           ================================ */
        /* Mengoverride Bootstrap button style */
        .quantity-box button {
            width: 35px !important;
            height: 35px !important;
            background-color: var(--color-pastel-bliss-2) !important;
            border: none !important;
            border-radius: 8px !important;
            font-size: 20px !important;
            font-weight: 700 !important;
            cursor: pointer;
            transition: all 0.25s !important;
            color: var(--color-text-dark) !important;
            padding: 0 !important;
        }

        .quantity-box button:hover {
            background-color: var(--color-pastel-bliss-1) !important;
            transform: translateY(-2px);
        }
        
        /* ================================
           TOTAL & CHECKOUT BOX (mengganti .cart-summary)
           ================================ */

        .summary-custom {
            background-color: var(--color-pastel-bliss-2) !important;
            padding: 25px 30px !important;
            border-radius: 20px !important;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05) !important;
        }

        /* Tombol Checkout (mengganti .checkout-btn) */
        .checkout-btn-custom {
            width: 100%;
            padding: 15px;
            font-size: 18px;
            font-weight: 700;
            border: none;
            border-radius: 15px;
            color: white;
            cursor: pointer;
            margin-top: 20px;
            /* Gradient dari CSS kustom Anda */
            background-image: linear-gradient(
                45deg, 
                var(--color-pastel-bliss-5) 0%, 
                var(--color-accent-strong) 50%, 
                var(--color-button-primary) 100%
            );
            background-size: 200% 100%;
            background-position: right bottom;
            transition: all 0.4s ease-in-out;
            box-shadow: 0 6px 20px rgba(237, 56, 120, 0.35);
        }

        .checkout-btn-custom:hover {
            background-position: left bottom;
            transform: translateY(-2px);
        }

        /* Gaya Tombol Lanjutkan Belanja */
        .back-shopping-link {
            display: inline-block;
            margin-top: 15px;
            font-size: 16px;
            color: var(--color-accent-strong);
            font-weight: 600;
            text-decoration: underline;
            transition: color 0.3s;
        }

        .back-shopping-link:hover {
            color: var(--color-button-primary);
        }

        /* Gaya untuk menyembunyikan elemen summary jika kosong (ditangani oleh JS) */
        .hidden-summary-detail {
            display: none !important;
        }
    </style>
</head>

<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16" style="vertical-align: middle;">
                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607.64 1.749A.5.5 0 0 1 .5 1.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
            </svg>
        </a>
    </div>
</nav>

<div class="container my-5">
    <div class="card p-4 shadow-sm card-custom"> 
        <h4 class="mb-4 fw-bold cart-title-custom">Daftar Belanja Anda</h4>
        <div id="cartList">
            </div>

        <div id="summaryBox" class="mt-4 summary-custom">
            <div id="summaryDetails"> 
                <h5 class="summary-title mb-3">Ringkasan Pesanan</h5>
                
                <div class="summary-row" id="subtotalRow">
                    <span>Subtotal Item</span>
                    <span id="subTotal">Rp0</span>
                </div>
                
                <div class="summary-row" id="totalRow" style="border-top: 1px solid rgba(0,0,0,0.1); padding-top: 12px;">
                    <span class="summary-total">Total Keseluruhan</span>
                    <span id="cartTotal" class="summary-total">Rp0</span>
                </div>
            </div>
            
            <button class="checkout-btn-custom" onclick="checkout()">Checkout</button>
            
            <a href="/" class="back-shopping-link d-block text-center">← Lanjutkan Belanja</a>
        </div>
    </div>
</div>

<script>
// ==============================
//  INITIALISASI DATA KERANJANG
// ==============================
let cart = JSON.parse(localStorage.getItem('cartItems')) || [];

// ==============================
//  SIMPAN KE LOCALSTORAGE
// ==============================
function saveCart() {
    localStorage.setItem('cartItems', JSON.stringify(cart));
}

// ==============================
//  FORMAT RUPIAH
// ==============================
function formatRupiah(num) {
    if (isNaN(num)) return "Rp0";
    return "Rp" + num.toLocaleString('id-ID');
}

// ==============================
//  RENDER KERANJANG
// ==============================
function renderCart() {
    let list = document.getElementById('cartList');
    list.innerHTML = '';

    const summaryDetails = document.getElementById('summaryDetails');

    if (cart.length === 0) {
        list.innerHTML = `<p class='text-center text-muted p-5'>Keranjang kosong. Yuk, cari produk lucu!</p>`;
        
        // Sembunyikan detail total/subtotal jika keranjang kosong
        if (summaryDetails) summaryDetails.classList.add('hidden-summary-detail');
        
        return;
    }

    // Tampilkan kembali detail total/subtotal jika ada item
    if (summaryDetails) summaryDetails.classList.remove('hidden-summary-detail');

    let total = 0;

    cart.forEach((item, index) => {
        const itemTotal = item.price * item.qty;
        total += itemTotal;

        list.innerHTML += `
            <div class="d-flex justify-content-between align-items-center cart-item-custom">
                <div class="d-flex align-items-center gap-3" style="width: 40%;">
                    <img src="${item.image}" alt="${item.name}" class="cart-img-custom" />
                    <div>
                        <h6 class="cart-item-name fw-bold mb-0">${item.name}</h6>
                        <p class="cart-item-price mb-0">${formatRupiah(item.price)}</p>
                    </div>
                </div>

                <div class="quantity-box d-flex align-items-center gap-2">
                    <button class="qty-btn" onclick="updateQty(${index}, -1)">-</button>
                    <input type="text" value="${item.qty}" class="qty-input text-center" readonly style="width: 40px;"/>
                    <button class="qty-btn" onclick="updateQty(${index}, 1)">+</button>
                </div>

                <div style="width: 15%; text-align: right;">
                    <h6 class="fw-bold mb-0">${formatRupiah(itemTotal)}</h6>
                </div>
                
                <button class="delete-btn" onclick="removeItem(${index})" title="Hapus Item">
                    &times;
                </button>
            </div>
        `;
    });

    document.getElementById('cartTotal').innerText = formatRupiah(total);
    document.getElementById('subTotal').innerText = formatRupiah(total);
}

// ==============================
//  UPDATE KUANTITAS
// ==============================
function updateQty(index, change) {
    cart[index].qty += change;
    if (cart[index].qty <= 0) cart[index].qty = 1; 

    saveCart();
    renderCart();
}

// ==============================
//  HAPUS ITEM
// ==============================
function removeItem(index) {
    if (confirm(`Yakin ingin menghapus ${cart[index].name} dari keranjang?`)) {
        cart.splice(index, 1);
        saveCart();
        renderCart();
    }
}

// ==============================
//  CHECKOUT (DUMMY)
// ==============================
function checkout() {
    if (cart.length === 0) {
        alert('Keranjang Anda kosong!');
        return;
    }
    
    cart = [];
    saveCart();
    renderCart();
    alert('Checkout berhasil! Terima kasih telah berbelanja. (Simulasi selesai)');
}

// ==============================
//  LOAD DATA AWAL
// ==============================
renderCart();
</script>

</body>
</html>