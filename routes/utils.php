<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Store\StoreController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/check-dashboard', [RegisteredUserController::class, 'redirectToDashboard'])->name('check.dashboard');
});
