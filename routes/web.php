<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MovementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('products.index');
})->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('movements', MovementController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/report/stock', [ProductController::class, 'stockReport'])->name('report.stock');
    Route::get('/report/top-exits', [ProductController::class, 'topExits'])->name('report.topExits');
    Route::get('/stock-report/pdf', [ProductController::class, 'downloadPdf'])->name('stock-report.pdf');
});

require __DIR__.'/auth.php';
