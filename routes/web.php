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
    Route::resource('products', ProductController::class);

    // Sales routes
    Route::get('/sales/export', [SaleController::class, 'exportPage'])->name('sales.export.page');
    Route::post('/sales/export', [SaleController::class, 'export'])->name('sales.export');
    Route::post('/sales/preview', [SaleController::class, 'preview'])->name('sales.preview');
    Route::resource('sales', SaleController::class);
    Route::get('sales/{id}/struk', [SaleController::class, 'printStruk'])->name('sales.struk');

    // User management routes (admin only)
    Route::middleware('admin')->group(function () {
        Route::resource('users', UserController::class);
    });
});
