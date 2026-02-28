<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pos', [PosController::class, 'index']);

Route::get('/products', [ProductController::class, 'index'])->name('products.index');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware('auth');

Route::get('/admin', [AdminController::class, 'index'])
    ->middleware(['auth', 'admin']);

Route::get('/login', [AuthController::class, 'showLogin'])
    ->middleware('guest')
    ->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');
