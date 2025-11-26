// cart_model.js

/**
 * Kelas representasi model untuk satu Item dalam Keranjang Belanja.
 * Kelas ini memastikan setiap item memiliki struktur data yang konsisten.
 */
class CartItem {
    constructor(id, name, price, quantity, imageUrl) {
        if (!id || !name || typeof price !== 'number' || typeof quantity !== 'number') {
            throw new Error("CartItem harus memiliki ID, nama, harga, dan kuantitas yang valid.");
        }

        this.id = id;
        this.name = name;
        this.price = price; // Harga per unit
        this.quantity = quantity;
        this.imageUrl = imageUrl || 'https://placehold.co/80x80/cccccc/000?text=Item';
    }

    /**
     * Menghitung subtotal untuk item ini (Harga * Kuantitas).
     * @returns {number} Subtotal item.
     */
    calculateSubtotal() {
        return this.price * this.quantity;
    }
}

/**
 * Kelas representasi model utama untuk Keranjang Belanja.
 * Kelas ini mengelola koleksi item dan menghitung ringkasan total.
 */
class CartModel {
    constructor(initialItems = []) {
        this.items = [];
        this.shipping = 0; // Simulasi biaya pengiriman, diasumsikan 0 (Gratis)
        this.discount = 0; // Simulasi diskon
        
        // Memuat item awal, memastikan semuanya adalah instance CartItem
        initialItems.forEach(item => {
            try {
                this.items.push(new CartItem(item.id, item.name, item.price, item.quantity, item.imageUrl));
            } catch (e) {
                console.error("Gagal menambahkan item ke CartModel:", e.message);
            }
        });
    }

    /**
     * Menambahkan item baru atau memperbarui kuantitas jika item sudah ada.
     * @param {object} itemData - Data item (id, name, price, quantity, imageUrl).
     */
    addItem(itemData) {
        const existingItem = this.items.find(item => item.id === itemData.id);

        if (existingItem) {
            existingItem.quantity += itemData.quantity || 1;
        } else {
            this.items.push(new CartItem(
                itemData.id,
                itemData.name,
                itemData.price,
                itemData.quantity || 1,
                itemData.imageUrl
            ));
        }
    }

    /**
     * Mengubah kuantitas item berdasarkan ID.
     * @param {number} id - ID item.
     * @param {number} newQuantity - Kuantitas baru.
     */
    updateQuantity(id, newQuantity) {
        const item = this.items.find(i => i.id === id);
        if (item) {
            item.quantity = Math.max(0, newQuantity);
        }
    }

    /**
     * Menghapus item dari keranjang berdasarkan ID.
     * @param {number} id - ID item.
     */
    removeItem(id) {
        this.items = this.items.filter(item => item.id !== id);
    }

    /**
     * Menghitung ringkasan total keranjang.
     * @returns {object} Objek yang berisi subtotal, pengiriman, diskon, dan total.
     */
    getSummary() {
        // 1. Hitung Subtotal (Total harga semua item)
        const subtotal = this.items.reduce((sum, item) => sum + item.calculateSubtotal(), 0);

        // 2. Terapkan Diskon (Jika ada)
        const totalAfterDiscount = subtotal - this.discount;

        // 3. Tambahkan Biaya Pengiriman
        const total = totalAfterDiscount + this.shipping;

        return {
            subtotal: subtotal,
            shipping: this.shipping,
            discount: this.discount,
            total: Math.max(0, total) // Total tidak boleh negatif
        };
    }
}

// --- Contoh Penggunaan Model ---

// Data simulasi (sesuai dengan yang ada di HTML Anda)
const initialCartData = [
    { id: 1, name: 'Baby Blooms Bouquet', price: 550000, quantity: 2, imageUrl: '...' },
    { id: 2, name: 'Satin Ribbon (Rose Gold)', price: 89000, quantity: 1, imageUrl: '...' },
    { id: 3, name: 'Aromatic Candle Set (Peony)', price: 210000, quantity: 3, imageUrl: '...' }
];

const myCart = new CartModel(initialCartData);

// Simulasi aksi:
// myCart.updateQuantity(2, 5);
// myCart.removeItem(1);
// myCart.addItem({ id: 4, name: 'Flower Food Sachets', price: 15000, quantity: 1 });

console.log("Item saat ini:", myCart.items.map(i => ({ name: i.name, qty: i.quantity, sub: i.calculateSubtotal() })));
console.log("Ringkasan Total:", myCart.getSummary());

// (Dalam aplikasi nyata, instance myCart ini akan digunakan oleh logika JavaScript di halaman Anda.)