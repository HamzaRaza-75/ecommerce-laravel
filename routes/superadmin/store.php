<?php

use App\Http\Controllers\Admin\AdminStoreController;
use App\Http\Controllers\Admin\AdminUtilsController;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth', 'role:super-admin'])->prefix('super-admin')->group(function () {

    Route::get('/stores/request', [AdminStoreController::class, 'index'])->name('superadmin.store');
    Route::get('/store/approve/{storeid}', [AdminUtilsController::class, 'approvestore'])->name('superadmin.store.approve');
    Route::get('/store/reject/{storeid}', [AdminUtilsController::class, 'rejectstore'])->name('superadmin.store.reject');
    // List all shops
    // Route::get('/shop/create', [RegisterstoreController::class, 'create'])->name('shop.create'); // Show create form
    // Route::get('/shop/{shop}', [RegisterstoreController::class, 'show'])->name('shop.show'); // Show a single shop
    // Route::get('/shop/{shop}/edit', [RegisterstoreController::class, 'edit'])->name('shop.edit'); // Show edit form
    // Route::put('/shop/{shop}', [RegisterstoreController::class, 'update'])->name('shop.update'); // Update existing shop
    // Route::delete('/shop/{shop}', [RegisterstoreController::class, 'destroy'])->name('shop.destroy'); // Delete shop
});
