<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Store\RegisterstoreController;

// Route::middleware(['auth', 'role:super-admin'])->prefix('super-admin')->group(function () {
//     Route::get('/shop', [RegisterstoreController::class, 'index'])->name('shop.index'); // List all shops
//     Route::get('/shop/create', [RegisterstoreController::class, 'create'])->name('shop.create'); // Show create form
//     Route::get('/shop/{shop}', [RegisterstoreController::class, 'show'])->name('shop.show'); // Show a single shop
//     Route::get('/shop/{shop}/edit', [RegisterstoreController::class, 'edit'])->name('shop.edit'); // Show edit form
//     Route::put('/shop/{shop}', [RegisterstoreController::class, 'update'])->name('shop.update'); // Update existing shop
//     Route::delete('/shop/{shop}', [RegisterstoreController::class, 'destroy'])->name('shop.destroy'); // Delete shop
// });

Route::middleware(['auth', 'role:client'])->group(function () {
    Route::post('/store/regiester', [RegisterstoreController::class, 'store'])->name('store.register'); // Store new shop

});
