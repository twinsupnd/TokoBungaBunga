<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JenisController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', [JenisController::class, 'landing']);
Route::get('/jenis/{jenis:slug}', [JenisController::class, 'show'])->name('jenis.show');

// Cart route
Route::get('/cart', function () {
    return view('cart.cart');
})->middleware(['auth', 'verified'])->name('cart');

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin/manager routes to manage Jenis (products)
Route::prefix('dashboard/jenis')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [App\Http\Controllers\JenisController::class, 'index'])->name('dashboard.jenis.index');
    Route::post('/', [App\Http\Controllers\JenisController::class, 'store'])->name('dashboard.jenis.store');
    Route::get('/{id}', [App\Http\Controllers\JenisController::class, 'adminShow'])->name('dashboard.jenis.show');
});

// Manager dashboard (only accessible to manager role)
Route::get('/manager', function () {
    if (! Auth::check() || Auth::user()->role !== 'manager') {
        abort(403);
    }

    // Load admin users for manager to manage
    $admins = App\Models\User::where('role', 'admin')->get();
    return view('dashboard.manager', compact('admins'));
})->middleware(['auth', 'verified'])->name('manager.dashboard');

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

// Temporary route to preview order details view
Route::get('/pesanan', function () {
    return view('auth.detail');
})->name('pesanan.preview');


require __DIR__.'/auth.php';
