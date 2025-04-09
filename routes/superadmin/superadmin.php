<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:super-admin'])->prefix('super-admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('superadmin.dashboard');
    // List all shops
    // Route::get('/shop/create', [RegisterstoreController::class, 'create'])->name('shop.create'); // Show create form
    // Route::get('/shop/{shop}', [RegisterstoreController::class, 'show'])->name('shop.show'); // Show a single shop
    // Route::get('/shop/{shop}/edit', [RegisterstoreController::class, 'edit'])->name('shop.edit'); // Show edit form
    // Route::put('/shop/{shop}', [RegisterstoreController::class, 'update'])->name('shop.update'); // Update existing shop
    // Route::delete('/shop/{shop}', [RegisterstoreController::class, 'destroy'])->name('shop.destroy'); // Delete shop
});


require __DIR__ . '/superadminutils.php';
require __DIR__ . '/store.php';
require __DIR__ . '/category.php';
require __DIR__ . '/order.php';
require __DIR__ . '/product.php';
