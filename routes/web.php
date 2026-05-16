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
Route::resource('products', ProductController::class)
    ->names('products');

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

    // ゴミ箱・復元・完全削除
    Route::get('/orders/trashed', [OrderController::class, 'trashed'])->name('orders.trashed');
    Route::post('/orders/{id}/restore', [OrderController::class, 'restore'])->whereNumber('id')->name('orders.restore');
    Route::delete('/orders/{id}/force', [OrderController::class, 'forceDestroy'])->whereNumber('id')->name('orders.force-destroy');
});

require __DIR__.'/auth.php';
