<?php

use App\Http\Controllers\GownController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return redirect()->route(
        auth()->check() ? 'dashboard' : 'login'
    );
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [
        AuthController::class, 'showRegister'
    ])->name('register');

    Route::post('/register', [
        AuthController::class, 'register'
    ])->name('register.store');

    Route::get('/login', [
        AuthController::class, 'showLogin'
    ])->name('login');

    Route::post('/login', [
        AuthController::class, 'login'
    ])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [
        DashboardController::class, 'index'
    ])->name('dashboard');

    Route::post('/logout', [
        AuthController::class, 'logout'
    ])->name('logout');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    })->name('dashboard');
});

// Customer clothing shop
Route::get('/shop', [GownController::class, 'shop'])
    ->name('shop');

Route::get('/shop/{gown}', [GownController::class, 'showProduct'])
    ->name('shop.show');

// Admin product management
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('gowns', GownController::class);
    });

    // Customer shopping cart
Route::get('/cart', [GownController::class, 'cart'])->name('cart.index');
Route::post('/cart/add/{gown}', [GownController::class, 'addToCart'])
    ->name('cart.add');
Route::patch('/cart/{gown}', [GownController::class, 'updateCart'])
    ->name('cart.update');
Route::delete('/cart/{gown}', [GownController::class, 'removeFromCart'])
    ->name('cart.remove');

// Checkout
Route::get('/checkout', [GownController::class, 'checkout'])
    ->name('checkout.index');
Route::post('/checkout', [GownController::class, 'processCheckout'])
    ->name('checkout.process');
    Route::post('/cart/add/{gown}', [GownController::class, 'addToCart'])
    ->name('cart.add');

Route::get('/cart', [GownController::class, 'cart'])
    ->name('cart.index');

Route::patch('/cart/{gown}', [GownController::class, 'updateCart'])
    ->name('cart.update');

Route::delete('/cart/{gown}', [GownController::class, 'removeFromCart'])
    ->name('cart.remove');

Route::get('/checkout', [GownController::class, 'checkout'])
    ->name('checkout.index');

Route::post('/checkout', [GownController::class, 'processCheckout'])
    ->name('checkout.process');

    Route::get('/shop', [GownController::class, 'shop'])->name('shop');
Route::get('/shop/{gown}', [GownController::class, 'showProduct'])->name('shop.show');

Route::get('/cart', [GownController::class, 'cart'])->name('cart.index');
Route::post('/cart/add/{gown}', [GownController::class, 'addToCart'])->name('cart.add');
Route::patch('/cart/update/{gown}', [GownController::class, 'updateCart'])->name('cart.update');
Route::delete('/cart/remove/{gown}', [GownController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/checkout', [GownController::class, 'checkout'])->name('checkout.index');