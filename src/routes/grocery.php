<?php

use Illuminate\Support\Facades\Route;
use Imrancse94\Grocery\app\Http\Controllers\AuthController;
use Imrancse94\Grocery\app\Http\Controllers\PreorderController;
use Imrancse94\Grocery\app\Http\Controllers\ProductController;


Route::prefix('grocery')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/refresh-token', [AuthController::class, 'refreshToken']);
    Route::get('/products', [ProductController::class, 'getProducts']);

    Route::middleware(['groceryAuth'])->group(function () {
        Route::get('/user', [AuthController::class, 'getAuthenticatedUser']);
    });

    Route::controller(PreorderController::class)
        ->prefix('preorder')
        ->name('preorder.')
        ->group(function () {

            //throttle:10,1 => Maximum 10 times submit within 1 minute
            Route::post('create', 'store')->middleware('throttle:10,1');
            Route::middleware(['groceryAuth', 'permission'])->group(function () {
                Route::get('list', 'index')->name('list');
                Route::delete('delete/{id}', 'removePreOrder')->name('delete');
            });

        });
});
