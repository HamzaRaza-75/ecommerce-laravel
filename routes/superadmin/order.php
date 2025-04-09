<?php

use App\Http\Controllers\Admin\OrderController;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth', 'role:super-admin'])->prefix('super-admin')->name('superadmin.')->group(function () {
    // orders controller
    Route::get('/orders', [OrderController::class, 'index'])->name('order.index');
    // Route::post('/orders', [OrderController::class, 'store'])->name('order.store');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('order.show');
    // Route::get('/orders/{category}/edit', [OrderController::class, 'edit'])->name('order.edit');
    // Route::put('/orders/{category}', [OrderController::class, 'update'])->name('order.update');
    // Route::delete('/orders/{category}', [OrderController::class, 'destroy'])->name('order.destroy');
    // // orders controller ends here
});
