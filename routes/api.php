<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;  // <- Tambahkan ini
use Illuminate\Support\Facades\Route;

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

// Order routes (akan dilengkapi di Fase 2)
Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders/{id}', [OrderController::class, 'show']);
Route::post('/webhook', [OrderController::class, 'webhook']);