<?php

use App\Http\Controllers\Store\ProductController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'role:store-owner'])->prefix('store')->group(function () {
    Route::get('product', [ProductController::class, 'index'])->name('store.product.index');
    Route::get('product/create', [ProductController::class, 'create'])->name('store.product.create');
    Route::post('product', [ProductController::class, 'store'])->name('store.product.store');
    Route::get('product/{id}', [ProductController::class, 'show'])->name('store.product.show');
    Route::get('product/{product}/edit', [ProductController::class, 'edit'])->name('store.product.edit');
    Route::put('product/{product}', [ProductController::class, 'update'])->name('store.product.update');
    Route::delete('product/{product}', [ProductController::class, 'destroy'])->name('store.product.destroy');
});
