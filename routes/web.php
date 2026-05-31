<?php

use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Cart\DashboardController;
use App\Http\Controllers\Product\CategoryController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/{id}', [CartController::class, 'store'])->name('cart.store');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
});

Route::get('/', [DashboardController::class, 'index'])->name('welcome');

Route::get('/dashboard', [ProductController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/category', CategoryController::class)->names([
        'index' => 'category.index',
        'edit' => 'category.edit',
        'create' => 'category.create',
        'store' => 'category.store',
        // 'show' => 'product.show',
        // 'destroy' => 'product.destroy'
    ])->parameters(
        [
            'category' =>
            'id'
        ]
    );

    Route::resource('/product', ProductController::class)->names([
        'edit' => 'product.edit',
        'create' => 'product.create',
        'store' => 'product.store',
        'show' => 'product.show',
        'destroy' => 'product.destroy'
    ])->parameters(
        [
            'product' =>
            'id'
        ]
    );
});

Route::get('/{id}', [DashboardController::class, 'show'])->whereNumber('id')->name('show');

require __DIR__ . '/auth.php';
