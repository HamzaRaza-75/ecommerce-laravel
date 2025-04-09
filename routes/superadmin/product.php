<?php

use App\Http\Controllers\Admin\AdminProductController;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth', 'role:super-admin'])->prefix('super-admin')->name('superadmin.')->group(function () {
    // products controller
    Route::get('/products', [AdminProductController::class, 'index'])->name('product.index');
    // Route::post('/products', [AdminProductController::class, 'store'])->name('product.store');
    Route::get('/products/{id}', [AdminProductController::class, 'show'])->name('product.show');
    // Route::get('/products/{category}/edit', [AdminProductController::class, 'edit'])->name('product.edit');
    // Route::put('/products/{category}', [AdminProductController::class, 'update'])->name('product.update');
    // Route::delete('/products/{category}', [AdminProductController::class, 'destroy'])->name('product.destroy');
    // // products controller ends here
});
