<?php

use App\Http\Controllers\Store\UtilsStoreController;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth', 'role:store-owner'])->prefix('store')->group(function () {
    Route::get('/store/notification/markasread', [UtilsStoreController::class,  'marknotificationasread'])->name('storeowner.notification.markasread');
    // List all shops
    // Route::get('/shop/create', [RegisterstoreController::class, 'create'])->name('shop.create'); // Show create form
    // Route::get('/shop/{shop}', [RegisterstoreController::class, 'show'])->name('shop.show'); // Show a single shop
    // Route::get('/shop/{shop}/edit', [RegisterstoreController::class, 'edit'])->name('shop.edit'); // Show edit form
    // Route::put('/shop/{shop}', [RegisterstoreController::class, 'update'])->name('shop.update'); // Update existing shop
    // Route::delete('/shop/{shop}', [RegisterstoreController::class, 'destroy'])->name('shop.destroy'); // Delete shop
});
