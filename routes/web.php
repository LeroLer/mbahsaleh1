<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

// Redirect root ke login
Route::get('/', function () {
    return redirect('/login');
});

// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    // Dashboard route
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // Product routes
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::middleware('admin')->group(function () {
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    });

    // Sales routes
    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
    Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');
    Route::get('sales/{id}/struk', [SaleController::class, 'printStruk'])->name('sales.struk');
    Route::get('sales/{id}/struk/thermal', [SaleController::class, 'printStrukThermal'])->name('sales.struk.thermal');
    Route::get('sales/{id}/struk/a4', [SaleController::class, 'printStrukA4'])->name('sales.struk.a4');
    Route::get('sales/{id}/struk/select', [SaleController::class, 'strukSelector'])->name('sales.struk.select');

    // Sales routes yang memerlukan admin
    Route::middleware('admin')->group(function () {
        Route::get('/sales/export', [SaleController::class, 'exportPage'])->name('sales.export.page');
        Route::post('/sales/export', [SaleController::class, 'export'])->name('sales.export');
        Route::get('/sales/{sale}/edit', [SaleController::class, 'edit'])->name('sales.edit');
        Route::put('/sales/{sale}', [SaleController::class, 'update'])->name('sales.update');
        Route::delete('/sales/{sale}', [SaleController::class, 'destroy'])->name('sales.destroy');
    });

    // User management routes (admin only)
    Route::middleware('admin')->group(function () {
        Route::resource('users', UserController::class);
    });
});
