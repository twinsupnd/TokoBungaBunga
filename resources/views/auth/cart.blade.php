<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Keranjang</title>

    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />

    <!-- CSS EMERGENCY / KHUSUS HALAMAN INI -->
    @stack('styles')

    <!-- ======= CSS EKSTERNAL (VITE) ======= -->
    @vite(['resources/css/cart.css'])
</head>

<body class="bg-light">

<!-- HEADER -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">Keranjang</a>
    </div>
</nav>

<div class="container my-5">
    <div class="card p-4 shadow-sm">
        <h4 class="mb-4 fw-bold">Daftar Belanja</h4>
        <div id="cartList"></div>

        <!-- TOTAL -->
        <div class="mt-4 text-end">
            <h5><strong>Total: </strong> <span id="cartTotal">Rp0</span></h5>
        </div>

        <!-- Tombol Lanjutkan Belanja -->
        <div class="mt-4 d-flex justify-content-between">
            <a href="/" class="btn btn-outline-primary">Lanjutkan Belanja</a>
            <button class="btn btn-success" onclick="checkout()">Checkout</button>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Gaya Khusus Cart */
    .cart-item {
        transition: 0.2s;
    }

    .cart-item:hover {
        background: #f8f9fa;
    }

    .cart-img {
        width: 70px;
        height: 70px;
        border-radius: 8px;
        object-fit: cover;
    }

    .quantity-box button {
        width: 32px;
        height: 32px;
        padding: 0;
    }
</style>
@endpush

<script>
// ==============================
//  INITIALISASI DATA KERANJANG
// ==============================
let cart = JSON.parse(localStorage.getItem('cartItems')) || [];

// ==============================
//  SIMPAN KE LOCALSTORAGE
// ==============================
function saveCart() {
    localStorage.setItem('cartItems', JSON.stringify(cart));
}

// ==============================
//  FORMAT RUPIAH
// ==============================
function formatRupiah(num) {
    return "Rp" + num.toLocaleString('id-ID');
}

// ==============================
//  RENDER KERANJANG
// ==============================
function renderCart() {
    let list = document.getElementById('cartList');
    list.innerHTML = '';

    if (cart.length === 0) {
        list.innerHTML = `<p class='text-center text-muted'>Keranjang kosong.</p>`;
        document.getElementById('cartTotal').innerText = "Rp0";
        return;
    }

    let total = 0;

    cart.forEach((item, index) => {
        total += item.price * item.qty;

        list.innerHTML += `
            <div class="d-flex justify-content-between align-items-center border-bottom py-3 cart-item">
                <div class="d-flex align-items-center gap-3">
                    <img src="${item.image}" alt="${item.name}" class="cart-img" />
                    <div>
                        <h6 class="fw-bold">${item.name}</h6>
                        <p class="text-muted mb-1">${formatRupiah(item.price)}</p>
                    </div>
                </div>

                <div class="quantity-box">
                    <button class="btn btn-outline-secondary" onclick="updateQty(${index}, -1)">-</button>
                    <span class="px-2">${item.qty}</span>
                    <button class="btn btn-outline-secondary" onclick="updateQty(${index}, 1)">+</button>
                </div>

                <h6>${formatRupiah(item.price * item.qty)}</h6>

                <button class="btn btn-danger btn-sm" onclick="removeItem(${index})">Hapus</button>
            </div>
        `;
    });

    document.getElementById('cartTotal').innerText = formatRupiah(total);
}

// ==============================
//  UPDATE KUANTITAS
// ==============================
function updateQty(index, change) {
    cart[index].qty += change;
    if (cart[index].qty <= 0) cart[index].qty = 1;

    saveCart();
    renderCart();
}

// ==============================
//  HAPUS ITEM
// ==============================
function removeItem(index) {
    cart.splice(index, 1);
    saveCart();
    renderCart();
}

// ==============================
//  CHECKOUT (DUMMY)
// ==============================
function checkout() {
    alert('Checkout berhasil! (simulasi)');
}

// ==============================
//  LOAD DATA AWAL
// ==============================
renderCart();
</script>

</body>
</html>
