<?php

use App\Http\Controllers\Shop\CartController;
use App\Http\Controllers\Shop\LandingShopController;
use App\Http\Controllers\Shop\OrderController;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Route;




Route::get('/ecommerce-shop', [LandingShopController::class, 'index'])->middleware(['auth', 'role:client|store-owner'])->name('dashboard');

Route::middleware(['auth', 'role:client|store-owner'])->prefix('ecommerce-shop')->name('shop.')->group(function () {
    Route::get('/products', [LandingShopController::class, 'allShop'])->name('product');
    Route::get('/product/{id}', [LandingShopController::class, 'show'])->name('product.view');


    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/order/create', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');


    // Route::get('/products/add-to-cart/{id}', [CartController::class, 'create'])->name('cart.create');
    Route::post('/add-to-cart/{id}', [CartController::class, 'store'])->name('cart.store');
    Route::get('/remove-from-cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::get('/cart-view', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart-update', [CartController::class, 'update'])->name('cart.update');


    Route::get('/about', [LandingShopController::class, 'aboutshop'])->name('about');


    Route::post('/review/{product}', [OrderController::class, 'reviewstore'])->name('product.review');
});


require __DIR__ . '/storeregister.php';
