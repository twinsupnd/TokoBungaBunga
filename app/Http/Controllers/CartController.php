<?php
/**
 * CartController.php
 * Menangani permintaan HTTP untuk keranjang belanja.
 */

// Sertakan CartModel
require_once 'cart_model.php';

class CartController
{
    private $cartModel;
    private $currentUserId = 1; // Asumsi ID pengguna terotentikasi

    public function __construct()
    {
        $this->cartModel = new CartModel();
    }

    /**
     * Fungsi utama untuk menampilkan halaman keranjang.
     * Biasanya dipanggil melalui route GET /cart.
     */
    public function index()
    {
        // 1. Panggil Model untuk mendapatkan data
        $items = $this->cartModel->getItems($this->currentUserId);
        $summary = $this->cartModel->calculateSummary($items);

        // 2. Load View (Dalam framework nyata, ini akan me-render file HTML)
        // Di sini kita hanya mensimulasikan data yang diteruskan ke View
        $cartData = [
            'items' => $items,
            'summary' => $summary,
            'totalItems' => count($items)
        ];

        // Memuat file HTML (cart_view.html) dan menginjeksikan data.
        // return $this->renderView('cart_view.html', $cartData);
        
        // Output ringkasan data yang siap dikirim ke View
        echo "Data Siap untuk View (cart_view.html):\n";
        print_r($cartData);
    }

    /**
     * Menangani permintaan API untuk memperbarui kuantitas item.
     * Biasanya dipanggil melalui route PUT /api/cart/{itemId}.
     */
    public function updateQuantityApi(int $itemId, int $newQuantity)
    {
        // 1. Panggil Model untuk memperbarui data
        $success = $this->cartModel->updateQuantity($this->currentUserId, $itemId, $newQuantity);

        // 2. Beri respons JSON
        if ($success) {
            // Setelah update, ambil summary terbaru
            $items = $this->cartModel->getItems($this->currentUserId);
            $summary = $this->cartModel->calculateSummary($items);
            
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'success', 
                'summary' => $summary,
                'message' => 'Kuantitas berhasil diperbarui.'
            ]);
        } else {
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui kuantitas.']);
        }
    }
    
    // ... Fungsi lain seperti removeItemApi(), applyCouponApi(), dll.
}

// Contoh Penggunaan (Simulasi Route Index)
// $controller = new CartController();
// $controller->index();