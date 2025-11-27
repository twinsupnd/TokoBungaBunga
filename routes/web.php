<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Temporary route to preview order details view
Route::get('/pesanan', function () {
    return view('auth.detail');
})->name('pesanan.preview');

// Route to preview cart view
Route::get('/cart', function () {
    return view('auth.cart');
})->name('cart.preview');

require __DIR__.'/auth.php';
