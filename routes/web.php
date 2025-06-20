<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;

// Redirect root ke dashboard
Route::get('/', function () {
    return view('welcome');
});

// Dashboard route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('products', ProductController::class);
Route::resource('sales', SaleController::class);

// Route cetak struk penjualan
Route::get('sales/{id}/struk', [SaleController::class, 'printStruk'])->name('sales.struk');
