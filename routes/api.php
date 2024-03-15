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
    Route::post('/quotes', 'create');
    Route::put('/quotes/{id}', 'update');
    Route::delete('/quotes/{id}', 'delete');
});
