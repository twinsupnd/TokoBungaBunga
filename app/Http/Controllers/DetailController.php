<?php
/**
 * DetailController.php
 * Menangani permintaan HTTP untuk keranjang belanja (sebagai Controller utama).
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

        // 2. Siapkan data untuk View
        $cartData = [
            'items' => $items,
            'summary' => $summary,
        ];

        // 3. Memuat file View (cart_view.php)
        // Di lingkungan nyata, ini akan me-render file dan menginjeksikan $cartData
        require 'cart_view.php';
    }

    /**
     * Menangani permintaan API untuk memperbarui kuantitas item.
     * Biasanya dipanggil melalui route PUT /api/cart/{itemId}/update.
     */
    public function updateQuantityApi(int $itemId, int $newQuantity)
    {
        // Set header untuk respons JSON
        header('Content-Type: application/json');

        // 1. Panggil Model untuk memperbarui data
        $success = $this->cartModel->updateQuantity($this->currentUserId, $itemId, $newQuantity);

        // 2. Beri respons JSON
        if ($success) {
            // Setelah update, ambil summary terbaru
            $items = $this->cartModel->getItems($this->currentUserId);
            $summary = $this->cartModel->calculateSummary($items);
            
            echo json_encode([
                'status' => 'success', 
                'summary' => $summary,
                'message' => 'Kuantitas berhasil diperbarui.'
            ]);
        } else {
            // HTTP/1.1 400 Bad Request jika gagal (misalnya item tidak ada atau quantity < 1)
            http_response_code(400); 
            echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui kuantitas. Pastikan ID item dan kuantitas valid.']);
        }
    }
    
    /**
     * Menangani permintaan API untuk menghapus item.
     * Biasanya dipanggil melalui route DELETE /api/cart/{itemId}/delete.
     */
    public function removeItemApi(int $itemId)
    {
        // Set header untuk respons JSON
        header('Content-Type: application/json');

        // 1. Panggil Model untuk menghapus item
        $success = $this->cartModel->removeItem($this->currentUserId, $itemId);

        // 2. Beri respons JSON
        if ($success) {
            // Setelah delete, ambil summary terbaru
            $items = $this->cartModel->getItems($this->currentUserId);
            $summary = $this->cartModel->calculateSummary($items);

            echo json_encode([
                'status' => 'success', 
                'summary' => $summary,
                'message' => 'Item berhasil dihapus.'
            ]);
        } else {
            http_response_code(400); 
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus item. Item tidak ditemukan.']);
        }
    }
    
    // Catatan: Dalam framework nyata, Anda akan memiliki Router yang memanggil fungsi 
    // updateQuantityApi atau removeItemApi berdasarkan URL dan metode HTTP (PUT/DELETE).
}
/*
// Contoh Penggunaan (Simulasi Route Index - UNCOMMENT di lingkungan PHP)
// $controller = new CartController();
// $controller->index();
*/
?>