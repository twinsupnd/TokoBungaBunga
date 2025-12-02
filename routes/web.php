<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\AdminController; // <-- Controller yang kamu pakai
use App\Http\Controllers\AdminManagementController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
// (Request is imported earlier)

// ====================
// Public Routes
// ====================
Route::get('/', [JenisController::class, 'landing']);
// Search products
Route::get('/search', [JenisController::class, 'search'])->name('search');

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

// Simple subscribe endpoint (store email in session & log)
Route::post('/subscribe', function (Request $request) {
    $data = $request->validate([
        'email' => 'required|email|max:255',
    ]);

    // for now store in session and log; in real app you'd persist to DB or send to mail service
    $subscribers = session()->get('subscribers', []);
    $subscribers[] = ['email' => $data['email'], 'created_at' => now()->toDateTimeString()];
    session()->put('subscribers', $subscribers);

    Log::info('New newsletter sign up: ' . $data['email']);

    session()->flash('subscribed', true);
    return redirect()->back();
})->name('subscribe');
// About page — attractive company information
Route::get('/tentang-kami', function () {
    return view('about.index');
})->name('about.index');
Route::get('/jenis/{jenis:slug}', [JenisController::class, 'show'])->name('jenis.show');
Route::get('/katalog', [JenisController::class, 'publicCatalog'])->name('catalog.index');
// Lightweight endpoint used by public catalog to check for updates
Route::get('/katalog/last-updated', [JenisController::class, 'publicCatalogLastUpdated'])->name('catalog.lastUpdated');

// Category routes
Route::get('/bunga/{type}', [App\Http\Controllers\CategoryController::class, 'showFlowerType'])->name('category.flower-type');
Route::get('/model/{model}', [App\Http\Controllers\CategoryController::class, 'showModel'])->name('category.flower-model');

// ====================
// Cart
// ====================
// Cart routes
Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->middleware(['auth', 'verified'])->name('cart');
Route::post('/cart/{cart}', [App\Http\Controllers\CartController::class, 'update'])->middleware(['auth', 'verified'])->name('cart.update');
Route::delete('/cart/{cart}', [App\Http\Controllers\CartController::class, 'destroy'])->middleware(['auth', 'verified'])->name('cart.destroy');
// Endpoint to sync client localStorage cart into DB (merge, avoid duplicates)
Route::post('/cart/sync', [App\Http\Controllers\CartController::class, 'sync'])->middleware(['auth', 'verified'])->name('cart.sync');

// ====================
// Dashboard
// ====================
Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// ====================
// Produk (Admin / Manager)
// ====================
Route::prefix('dashboard/jenis')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [JenisController::class, 'index'])->name('dashboard.jenis.index');
    Route::post('/', [JenisController::class, 'store'])->name('dashboard.jenis.store');
    // use slug-based model binding for admin routes so IDs and public slugs are consistent
    Route::get('/{jenis:slug}', [JenisController::class, 'adminShow'])->name('dashboard.jenis.show');
    Route::get('/{jenis:slug}/edit', [JenisController::class, 'edit'])->name('dashboard.jenis.edit');
    Route::put('/{jenis:slug}', [JenisController::class, 'update'])->name('dashboard.jenis.update');
    Route::delete('/{jenis:slug}', [JenisController::class, 'destroy'])->name('dashboard.jenis.destroy');
});

// ====================
// Catalog Preview (Admin / Manager)
// ====================
Route::get('/dashboard/catalog', [JenisController::class, 'catalog'])->middleware(['auth', 'verified'])->name('dashboard.catalog');

// ====================
// Profil
// ====================
Route::get('/dashboard/profil', [ProfileController::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard.profile');

// Analytics route
Route::get('/dashboard/analitik', [App\Http\Controllers\AnalyticsController::class, 'financialAnalytics'])->middleware(['auth', 'verified'])->name('dashboard.analytics');

// Laporan (Reports) route
Route::get('/dashboard/laporan', [App\Http\Controllers\ReportController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard.laporan');
Route::post('/dashboard/laporan', [App\Http\Controllers\ReportController::class, 'store'])->middleware(['auth', 'verified'])->name('dashboard.laporan.store');
Route::delete('/dashboard/laporan/{review}', [App\Http\Controllers\ReportController::class, 'destroy'])->middleware(['auth', 'verified'])->name('dashboard.laporan.destroy');

// (calendar removed) — no dashboard/admin routes defined

// ====================
// Manager Dashboard
// ====================
Route::get('/manager', [App\Http\Controllers\EventController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:manager'])
    ->name('manager.dashboard');

// Manager access to profile and analytics (same pages as dashboard)
Route::middleware(['auth', 'verified', 'role:manager'])->group(function () {
    Route::get('/manager/profil', [ProfileController::class, 'show'])->name('manager.profile');
    Route::get('/manager/analitik', [App\Http\Controllers\AnalyticsController::class, 'financialAnalytics'])->name('manager.analytics');
});

// ====================
// Kelola Admin (Manager Only)
// ====================
Route::middleware(['auth', 'verified', 'role:manager'])->group(function () {
    Route::prefix('manager/kelola-admin')->name('manager.kelola.')->group(function () {
        // GET /manager/kelola-admin
        Route::get('/', [AdminController::class, 'index'])->name('index');

        // GET /manager/kelola-admin/create
        Route::get('/create', [AdminController::class, 'create'])->name('create');

        // GET /manager/kelola-admin/export
        Route::get('/export', [AdminController::class, 'export'])->name('export');

        // POST /manager/kelola-admin
        Route::post('/', [AdminController::class, 'store'])->name('store');

        // GET /manager/kelola-admin/{admin}/edit
        Route::get('/{admin}/edit', [AdminController::class, 'edit'])->name('edit');

        // PUT/PATCH /manager/kelola-admin/{admin}
        Route::put('/{admin}', [AdminController::class, 'update'])->name('update');

        // POST /manager/kelola-admin/{admin}/toggle-status
        Route::post('/{admin}/toggle-status', [AdminController::class, 'toggleStatus'])->name('toggleStatus');

        // DELETE /manager/kelola-admin/{admin}
        Route::delete('/{admin}', [AdminController::class, 'destroy'])->name('destroy');
    });

    // Calendar / Events management for Manager
    Route::prefix('manager/calendar')->name('manager.calendar.')->group(function () {
        Route::get('/', [App\Http\Controllers\EventController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\EventController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\EventController::class, 'store'])->name('store');
        Route::get('/{event}/edit', [App\Http\Controllers\EventController::class, 'edit'])->name('edit');
        Route::put('/{event}', [App\Http\Controllers\EventController::class, 'update'])->name('update');
        Route::delete('/{event}', [App\Http\Controllers\EventController::class, 'destroy'])->name('destroy');
    });

    // Backwards-compatible routes that used the old URL structure
    Route::prefix('dashboard/manage-admins')->name('dashboard.manage-admins.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/create', [AdminController::class, 'create'])->name('create');
        Route::post('/', [AdminController::class, 'store'])->name('store');
        Route::get('/{admin}/edit', [AdminController::class, 'edit'])->name('edit');
        Route::put('/{admin}', [AdminController::class, 'update'])->name('update');
        Route::delete('/{admin}', [AdminController::class, 'destroy'])->name('destroy');
    });
});

// ====================
// Profile & Logout
// ====================
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/photo', [ProfileController::class, 'uploadPhoto'])->name('profile.uploadPhoto');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // If a user (or a browser) visits /logout via GET (e.g., old bookmark),
    // just redirect them to the public welcome page instead of returning 419.
    Route::get('/logout', function () {
        return redirect('/');
    });

    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    })->name('logout');
});

// ====================
// Dummy Preview
// ====================
Route::get('/pesanan', function () {
    return view('auth.detail');
})->name('pesanan.preview');

// Checkout process (Midtrans)
Route::post('/checkout/process', [App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process')->middleware('auth');

// Simple confirmation landing after payment redirect
Route::get('/pesanan/konfirmasi', function (\Illuminate\Http\Request $request) {
    $status = $request->query('status', 'success');
    return view('pesanan.confirmation', ['status' => $status]);
})->name('pesanan.confirmation');


require __DIR__ . '/auth.php';
