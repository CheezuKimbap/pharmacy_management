<?php

use Illuminate\Support\Facades\Route;
use App\Domains\Auth\Controllers\API\UserController;
use App\Domains\Pharmacy\Controllers\API\ProductController;

    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    Route::prefix('products')->controller(ProductController::class)->group(function () {
        Route::get('/', 'index');         // GET all products
        Route::post('/', 'store');        // POST create a product
        Route::get('{id}', 'show');       // GET single product
        Route::put('{id}', 'update');     // PUT update product
        Route::delete('{id}', 'destroy'); // DELETE product
    });
