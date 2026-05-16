<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

Route::view('/', 'welcome')->name('home');
Route::view('/about', 'about')->name('about');
Route::get('/pricing', [PageController::class, 'pricing'])->name('pricing');
Route::get('/pages/{slug}', function (string $slug) {
    abort_unless(preg_match('/^[A-Za-z0-9-]+$/', $slug), 404);
    return view('page', compact('slug'));
})->name('pages.show');
Route::get('/quote', QuoteController::class)->name('quote');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/trashed', [ProductController::class, 'trashed'])->name('products.trashed');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{product}', [ProductController::class, 'show'])->whereNumber('product')->name('products.show');
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->whereNumber('product')->name('products.edit');
Route::patch('/products/{product}', [ProductController::class, 'update'])->whereNumber('product')->name('products.update');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->whereNumber('product')->name('products.destroy');
Route::post('/products/{id}/restore', [ProductController::class, 'restore'])->whereNumber('id')->name('products.restore');
Route::delete('/products/{id}/force', [ProductController::class, 'forceDestroy'])->whereNumber('id')->name('products.force-destroy');

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/{order}', [OrderController::class, 'show'])->whereNumber('order')->name('orders.show');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->whereNumber('order')->name('orders.edit');
    Route::patch('/orders/{order}', [OrderController::class, 'update'])->whereNumber('order')->name('orders.update');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->whereNumber('order')->name('orders.destroy');

    Route::get('/orders/trashed', [OrderController::class, 'trashed'])->name('orders.trashed');
    Route::post('/orders/{id}/restore', [OrderController::class, 'restore'])->whereNumber('id')->name('orders.restore');
    Route::delete('/orders/{id}/force', [OrderController::class, 'forceDestroy'])->whereNumber('id')->name('orders.force-destroy');
});

require __DIR__.'/auth.php';
