<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MovementController;


Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);
Route::resource('movements', MovementController::class);

Route::get('/', function () {
    return view('welcome');
});
