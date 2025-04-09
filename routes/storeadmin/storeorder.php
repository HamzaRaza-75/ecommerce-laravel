<?php

use App\Http\Controllers\Store\OrderController;
use App\Http\Controllers\Store\StoreOwnerController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:store-owner'])->prefix('store')->group(function () {

    Route::get('/orders', [OrderController::class, 'index'])->name('store.orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'store'])->name('store.orders.store');
});
