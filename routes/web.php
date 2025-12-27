<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\UsersController;
use App\Http\Controllers\Web\ProductsController;
use App\Http\Controllers\Web\SocialAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ---------- GOOGLE SOCIAL LOGIN (بدون middleware) ----------
Route::get('/auth/google/redirect', [SocialAuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);


// ---------- AUTH (Login / Register) ----------
Route::middleware('guest')->group(function () {

    Route::get('/login', [UsersController::class, 'login'])->name('login');
    Route::post('/login', [UsersController::class, 'doLogin'])->name('do_login');

    Route::get('/register', [UsersController::class, 'register'])->name('register');
    Route::post('/register', [UsersController::class, 'doRegister'])->name('do_register');
});


// ---------- PROTECTED PAGES (بعد الـ Login) ----------
Route::middleware('auth')->group(function () {

    // Home / Dashboard
    Route::get('/', [UsersController::class, 'home'])->name('home');

    // Logout
    Route::get('/logout', [UsersController::class, 'doLogout'])->name('do_logout');

    // ===== Supermarket Products =====
    Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductsController::class, 'create'])->name('products.create');
    Route::post('/products/save', [ProductsController::class, 'save'])->name('products.save');
    Route::get('/products/{product}/edit', [ProductsController::class, 'edit'])->name('products.edit');
    Route::get('/products/{product}/delete', [ProductsController::class, 'delete'])->name('products.delete');

    // ===== Users Management =====
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');
    Route::post('/users/save', [UsersController::class, 'save'])->name('users.save');
    Route::get('/users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
    Route::get('/users/{user}/delete', [UsersController::class, 'delete'])->name('users.delete');
    Route::get('/users/{user}/password', [UsersController::class, 'passwordForm'])->name('users.password_form');
    Route::post('/users/{user}/password', [UsersController::class, 'passwordSave'])->name('users.password_save');
});
