<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartController;

Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);


Route::post('/cart', [CartController::class, 'addToCart']);
Route::get('/cart', [CartController::class, 'getCartItems']);
