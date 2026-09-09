<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;
use Illuminate\Support\Facades\Route;

// ============ PRODUCT ROUTES ============
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/categories', [ProductController::class, 'categories']);

// ============ ORDER ROUTES ============
Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders', [OrderController::class, 'index']);
Route::get('/orders/{id}', [OrderController::class, 'show']);
Route::post('/webhook', [OrderController::class, 'webhook']);