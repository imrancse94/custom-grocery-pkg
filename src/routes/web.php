<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Imrancse94\Grocery\app\Http\Controllers\PreorderController;

//Route::get('grocery', function () {
//    return view('grocery::app');
//});

Route::get('/grocery/{vue_capture?}', function () {
    return view('grocery::app');
})->where('vue_capture', '[\/\w\.-]*');

//Route::middleware('auth')->group(function () {
//    Route::get('/pre-orders', [PreOrderController::class, 'index'])->middleware('role:admin,manager');
//    Route::post('/pre-orders', [PreOrderController::class, 'store']);
//});
