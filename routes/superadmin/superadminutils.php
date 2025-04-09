<?php

use App\Http\Controllers\Admin\AdminUtilsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:super-admin'])->prefix('super-admin')->group(function () {

    Route::post('/user/unblock/', [AdminUtilsController::class, 'blockuser'])->name('superadmin.user.approve');
    Route::post('/user/block/', [AdminUtilsController::class, 'unblockuser'])->name('superadmin.user.reject');
    Route::get('/request/markallasread', [AdminUtilsController::class, 'readnotification'])->name('superadmin.notification.read');
    // List all shops
    // Route::get('/shop/create', [RegisterstoreController::class, 'create'])->name('shop.create'); // Show create form
    // Route::get('/shop/{shop}', [RegisterstoreController::class, 'show'])->name('shop.show'); // Show a single shop
    // Route::get('/shop/{shop}/edit', [RegisterstoreController::class, 'edit'])->name('shop.edit'); // Show edit form
    // Route::put('/shop/{shop}', [RegisterstoreController::class, 'update'])->name('shop.update'); // Update existing shop
    // Route::delete('/shop/{shop}', [RegisterstoreController::class, 'destroy'])->name('shop.destroy'); // Delete shop
});
