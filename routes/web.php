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
    Route::get('/{id}', [JenisController::class, 'adminShow'])->name('dashboard.jenis.show');
});

// ====================
// Profil
// ====================
Route::get('/dashboard/profil', [ProfileController::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard.profile');

// Analytics route
Route::get('/dashboard/analitik', [App\Http\Controllers\AnalyticsController::class, 'financialAnalytics'])->middleware(['auth', 'verified'])->name('dashboard.analytics');

// (calendar removed) — no dashboard/admin routes defined

// ====================
// Manager Dashboard
// ====================
Route::get('/manager', function () {

    if (! Auth::check() || Auth::user()->role !== 'manager') {
        abort(403);
    }

    $admins = App\Models\User::where('role', 'admin')->get();
    return view('dashboard.manager', compact('admins'));

})->middleware(['auth', 'verified'])->name('manager.dashboard');

// ====================
// Kelola Admin (Manager Only)
// ====================
Route::middleware(['auth', 'verified', 'role:manager'])->group(function () {
    Route::prefix('manager/kelola-admin')->name('manager.kelola.')->group(function () {
        // GET /manager/kelola-admin
        Route::get('/', [AdminController::class, 'index'])->name('index');

        // GET /manager/kelola-admin/create
        Route::get('/create', [AdminController::class, 'create'])->name('create');

        // POST /manager/kelola-admin
        Route::post('/', [AdminController::class, 'store'])->name('store');

        // GET /manager/kelola-admin/{admin}/edit
        Route::get('/{admin}/edit', [AdminController::class, 'edit'])->name('edit');

        // PUT/PATCH /manager/kelola-admin/{admin}
        Route::put('/{admin}', [AdminController::class, 'update'])->name('update');

        // DELETE /manager/kelola-admin/{admin}
        Route::delete('/{admin}', [AdminController::class, 'destroy'])->name('destroy');
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
