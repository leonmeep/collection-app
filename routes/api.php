<?php

use App\Http\Controllers\QuoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(QuoteController::class)->group(function () {
    Route::get('/quotes', 'getAll');
    Route::get('/quotes/{id}', 'getSingle');

    //Route::get('/search?={search}', 'getAll');

    Route::post('/quotes/create', 'create');
    Route::put('/quotes/update/{id}', 'update');
    Route::delete('/quotes/delete/{id}', 'delete');
});
