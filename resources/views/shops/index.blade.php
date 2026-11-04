
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GownController;

/*
|--------------------------------------------------------------------------
| Gown Image Route
|--------------------------------------------------------------------------
*/

Route::get('/gown-images/{filename}', function ($filename) {

    $filename = basename($filename);

    $imagePath = storage_path('app/public/gowns/' . $filename);

    abort_unless(is_file($imagePath), 404);

    return response()->file($imagePath, [
        'Cache-Control' => 'public, max-age=86400',
    ]);

})->where('filename', '[A-Za-z0-9._-]+')
  ->name('gown.images');


/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route(
        auth()->check() ? 'dashboard' : 'login'
    );
});


/*
|--------------------------------------------------------------------------
| Guest Routes: Registration and Login
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.store');

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.store');

});


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', function () {
            return redirect()->route('dashboard');
        })->name('dashboard');

        Route::resource('gowns', GownController::class);

    });


/*
|--------------------------------------------------------------------------
| Customer Shop Routes
|--------------------------------------------------------------------------
*/

Route::get('/shop', [GownController::class, 'shop'])
    ->name('shop');

Route::get('/shop/{gown}', [GownController::class, 'showProduct'])
    ->name('shop.show');


/*
|--------------------------------------------------------------------------
| Shopping Cart Routes
|--------------------------------------------------------------------------
*/

Route::get('/cart', [GownController::class, 'cart'])
    ->name('cart.index');

Route::post('/cart/add/{gown}', [GownController::class, 'addToCart'])
    ->name('cart.add');

Route::patch('/cart/{gown}', [GownController::class, 'updateCart'])
    ->name('cart.update');

Route::delete('/cart/{gown}', [GownController::class, 'removeFromCart'])
    ->name('cart.remove');


/*
|--------------------------------------------------------------------------
| Checkout Routes
|--------------------------------------------------------------------------
*/

Route::get('/checkout', [GownController::class, 'checkout'])
    ->name('checkout.index');

Route::post('/checkout', [GownController::class, 'processCheckout'])
    ->name('checkout.process');
