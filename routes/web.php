<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MovementController;


Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);
Route::resource('movements', MovementController::class);
Route::get('/report/stock', [ProductController::class, 'stockReport'])->name('report.stock');
Route::get('/report/top-exits', [ProductController::class, 'topExits'])->name('report.topExits');

Route::get('/', function () {
    return redirect()->route('products.index');
});
