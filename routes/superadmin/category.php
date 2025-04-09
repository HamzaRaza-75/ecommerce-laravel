<?php

use App\Http\Controllers\Admin\AdminCategoryController;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth', 'role:super-admin'])->prefix('super-admin')->group(function () {
    // categories controller
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('superadmin.category.index');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('superadmin.category.store');
    Route::get('/categories/{category}', [AdminCategoryController::class, 'show'])->name('superadmin.category.show');
    Route::get('/categories/{category}/edit', [AdminCategoryController::class, 'edit'])->name('superadmin.category.edit');
    Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('superadmin.category.update');
    Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('superadmin.category.destroy');
    // categories controller ends here
});
