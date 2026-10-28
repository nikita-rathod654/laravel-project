<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Redirect root to Product Management dashboard
Route::redirect('/', '/products');

// Additional helper endpoints before resource route
Route::post('products/generate-sku', [ProductController::class, 'generateSku'])->name('products.generate-sku');
Route::post('products/bulk', [ProductController::class, 'bulk'])->name('products.bulk');
Route::get('products/export', [ProductController::class, 'export'])->name('products.export');

// Core Product Resource Routes (CRUD)
Route::resource('products', ProductController::class);

// Navigation placeholders for sidebar items
Route::get('dashboard', function () {
    return redirect()->route('products.index');
})->name('dashboard');

Route::get('store-management', function () {
    return redirect()->route('products.index')->with('info', 'Store Management module placeholder.');
})->name('stores.index');

Route::get('orders', function () {
    return redirect()->route('products.index')->with('info', 'Orders module placeholder.');
})->name('orders.index');

Route::get('vendor-management', function () {
    return redirect()->route('products.index')->with('info', 'Vendor Management module placeholder.');
})->name('vendors.index');

Route::get('promotions', function () {
    return redirect()->route('products.index')->with('info', 'Promotions module placeholder.');
})->name('promotions.index');

Route::get('marketing', function () {
    return redirect()->route('products.index')->with('info', 'Marketing Management module placeholder.');
})->name('marketing.index');

Route::get('pos', function () {
    return redirect()->route('products.index')->with('info', 'POS module placeholder.');
})->name('pos.index');
