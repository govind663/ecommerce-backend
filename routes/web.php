<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;


// Show all products
Route::get('/', [ProductController::class, 'index'])->name('products.index');

// Show form to create new product
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

// Store product and images
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

// Show cart list in CMS
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
