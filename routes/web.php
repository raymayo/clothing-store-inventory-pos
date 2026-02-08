<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pos', [PosController::class, 'index']);

Route::get('/products', [ProductController::class, 'index'])->name('products.index');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

Route::get('/dashboard', function () {
    return view('dashboard.index');
});