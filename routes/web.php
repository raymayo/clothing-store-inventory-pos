<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PosController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pos', [PosController::class, 'index']);