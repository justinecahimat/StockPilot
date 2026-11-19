<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\LowStockAlertController;
use App\Http\Controllers\PurchaseRequestController;
use App\Http\Controllers\InventoryHistoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InventoryReportController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/global-search', [DashboardController::class, 'globalSearch'])->name('global.search');

    Route::get('/ingredients', [IngredientController::class, 'index'])->name('ingredients.index');
    Route::post('/ingredients', [IngredientController::class, 'store'])->name('ingredients.store');
    Route::get('/ingredients/export-csv', [IngredientController::class, 'exportCsv'])->name('ingredients.export-csv');
    Route::get('/ingredients/export-pdf', [IngredientController::class, 'exportPdf'])->name('ingredients.export-pdf');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');

    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');

    Route::get('/stock-in', [StockInController::class, 'create'])->name('stock-in.create');
    Route::post('/stock-in', [StockInController::class, 'store'])->name('stock-in.store');

    Route::get('/stock-out', [StockOutController::class, 'create'])->name('stock-out.create');
    Route::post('/stock-out', [StockOutController::class, 'store'])->name('stock-out.store');

    Route::get('/low-stock-alert', [LowStockAlertController::class, 'index'])->name('low-stock-alert');
    Route::get('/low-stock-alert/export-csv', [LowStockAlertController::class, 'exportCsv'])->name('low-stock-alert.export-csv');
    Route::get('/low-stock-alert/export-pdf', [LowStockAlertController::class, 'exportPdf'])->name('low-stock-alert.export-pdf');

    Route::get('/purchase-requests', [PurchaseRequestController::class, 'index'])->name('purchase-request');
    Route::get('/purchase-request/{id}', [PurchaseRequestController::class, 'show'])->name('purchase-request.show');
    Route::post('/purchase-requests', [PurchaseRequestController::class, 'store'])->name('purchase-request.store');
    Route::patch('/purchase-request/{id}/approve', [PurchaseRequestController::class, 'approve'])->name('purchase-request.approve');

    Route::get('/inventory-history', [InventoryHistoryController::class, 'index'])->name('inventory.history');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/reports', [InventoryReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/generate', [InventoryReportController::class, 'generate'])->name('reports.generate');
});

Route::get('/ingredients/{id}', [IngredientController::class, 'show'])->name('ingredients.show');