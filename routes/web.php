<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserAddressController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home'); // opsional beri nama home

// Dashboard — hanya untuk user terautentikasi & terverifikasi
Route::get('/dashboard', function () {
    return view('dashboard'); // pastikan ada resources/views/dashboard.blade.php
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile (provided by ProfileController)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Public product routes
|--------------------------------------------------------------------------
| (Visitors can still view products without login)
*/
// Optional product routes…

/*
|--------------------------------------------------------------------------
| Protected Cart, Checkout & Address routes (require auth)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |----------------------------------------------------------------------
    | CART Routes
    |----------------------------------------------------------------------
    */
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

    /*
    |----------------------------------------------------------------------
    | DEBUG ROUTE (SEMENTARA!) — untuk menguji cart di checkout
    |----------------------------------------------------------------------
    | Buka: http://127.0.0.1:8000/test-add/1
    | Setelah berhasil dan cart muncul di checkout, route boleh dihapus.
    */
    Route::get('/test-add/{id}', function ($id) {
        $cart = session()->get('cart', []);
        $cart[$id] = [
            'id' => $id,
            'name' => 'Test Product #' . $id,
            'price' => 10000,
            'quantity' => 1,
            'subtotal' => 10000,
        ];
        session(['cart' => $cart]);
        return redirect()->route('checkout.index')
            ->with('success', 'Test product dimasukkan ke cart');
    })->name('test.add');

    /*
    |----------------------------------------------------------------------
    | CHECKOUT Routes
    |----------------------------------------------------------------------
    */
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

    /*
    |----------------------------------------------------------------------
    | ADDRESS Routes
    |----------------------------------------------------------------------
    */
    Route::resource('addresses', UserAddressController::class)->except(['show']);
    Route::post('addresses/{address}/set-default', [UserAddressController::class, 'setDefault'])
        ->name('addresses.set-default');
});
