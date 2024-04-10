<?php

use App\Http\Controllers\PreOrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('pre-order')->group(function () {
    Route::get('/select-meal', [PreOrderController::class, 'selectMeal'])->name('get_meal');
    Route::post('/select-meal', [PreOrderController::class, 'selectPostMeal'])->name('post_meal');

    Route::get('/select-restaurant', [PreOrderController::class, 'selectRestaurant'])->name('get_restaurant');
    Route::post('/select-restaurant', [PreOrderController::class, 'selectPostRestaurant'])->name('post_restaurant');
    
    Route::get('/select-dish', [PreOrderController::class, 'selectDish'])->name('get_dish');
    Route::post('/select-dish', [PreOrderController::class, 'selectPostDish'])->name('post_dish');
    
    Route::get('/review', [PreOrderController::class, 'review'])->name('review');
});

