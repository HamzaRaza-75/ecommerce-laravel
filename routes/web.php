<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // dd(request());
    // echo __DIR__ . '\superadmin/superadmin.php';
    return view('welcome');
})->name('home');

Route::get('/create-roles', [RegisteredUserController::class, 'roles'])->name('roles.register');

Route::get('/super-admin', function () {
    return view('admin.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/utils.php';
require __DIR__ . '\superadmin/superadmin.php';
require __DIR__ . '\storeadmin/storeadmin.php';
require __DIR__ . '\shop/store.php';
