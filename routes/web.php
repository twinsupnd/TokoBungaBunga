<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\AdminController; // <-- Controller yang kamu pakai
use App\Http\Controllers\AdminManagementController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// ====================
// Public Routes
// ====================
Route::get('/', [JenisController::class, 'landing']);
Route::get('/jenis/{jenis:slug}', [JenisController::class, 'show'])->name('jenis.show');

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


require __DIR__.'/auth.php';
