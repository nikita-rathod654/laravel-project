<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

// Redirect root to Product Management or Dashboard
Route::redirect('/', '/products');

// --- Authentication Routes (Signup, Login, Logout) ---
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// --- User Profile Routes ---
Route::middleware('auth')->group(function () {
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

// --- Enterprise Suite Core Modules ---
// 1. Dashboard Overview
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

// 2. Product Management (CRUD & helpers)
Route::post('products/generate-sku', [ProductController::class, 'generateSku'])->name('products.generate-sku');
Route::post('products/bulk', [ProductController::class, 'bulk'])->name('products.bulk');
Route::get('products/export', [ProductController::class, 'export'])->name('products.export');
Route::resource('products', ProductController::class);

// 3. Store Management
Route::resource('stores', StoreController::class)->except(['create', 'show', 'edit']);

// 4. Orders Management
Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

// 5. Vendor Management
Route::resource('vendors', VendorController::class)->except(['create', 'show', 'edit']);

// 6. Promotions
Route::resource('promotions', PromotionController::class)->except(['create', 'show', 'edit']);

// 7. Marketing Management
Route::resource('marketing', MarketingController::class)->except(['create', 'show', 'edit']);

// 8. POS (Point of Sale) Terminal
Route::get('pos', [PosController::class, 'index'])->name('pos.index');
Route::post('pos/checkout', [PosController::class, 'checkout'])->name('pos.checkout');
