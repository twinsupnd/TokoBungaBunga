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

// ====================
// Cart
// ====================
Route::get('/cart', function () {
    return view('cart.cart');
})->middleware(['auth', 'verified'])->name('cart');

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

// ====================
// Analitik
// ====================
Route::get('/dashboard/analitik', [App\Http\Controllers\AnalyticsController::class, 'financialAnalytics'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard.analytics');

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
// Kelola Admin (Manager Only) — FIXED
// ====================
Route::middleware(['auth', 'verified', 'role:manager'])->group(function () {

    // Inilah route yang kamu mau
    Route::get('/dashboard/manage-admins', [AdminController::class, 'index'])
        ->name('manager.kelolaAdmin');

    // CRUD for admins (Manager only)
    Route::get('/dashboard/manage-admins/create', [AdminController::class, 'create'])
        ->name('manager.kelola.create');
    Route::post('/dashboard/manage-admins', [AdminController::class, 'store'])
        ->name('manager.kelola.store');
    Route::get('/dashboard/manage-admins/{user}/edit', [AdminController::class, 'edit'])
        ->name('manager.kelola.edit');
    Route::put('/dashboard/manage-admins/{user}', [AdminController::class, 'update'])
        ->name('manager.kelola.update');
    Route::delete('/dashboard/manage-admins/{user}', [AdminController::class, 'destroy'])
        ->name('manager.kelola.destroy');

    // (Laporan route removed per request)

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
