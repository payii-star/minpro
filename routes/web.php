<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $products = Product::with('category')
        ->where('is_active', true)
        ->latest()
        ->get();

    return view('welcome', compact('products'));
})->name('home');


/*
|--------------------------------------------------------------------------
| Public product routes (visitor can view product detail without login)
|--------------------------------------------------------------------------
*/
Route::get('/products/{product}', [ProductController::class, 'show'])
    ->name('products.show');

/*
|--------------------------------------------------------------------------
| Dashboard — hanya untuk user terautentikasi & terverifikasi
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Protected Cart, Checkout & Address routes (require auth)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // CART
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

    // DEBUG CART (opsional, boleh dihapus nanti)
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

    // CHECKOUT
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

    // ADDRESSES
    Route::resource('addresses', UserAddressController::class)->except(['show']);
    Route::post('addresses/{address}/set-default', [UserAddressController::class, 'setDefault'])
        ->name('addresses.set-default');
});
