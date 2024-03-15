<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/quotes', [\App\Http\Controllers\QuoteController::class, 'getAll']);
Route::get('/quotes/{id}', [\App\Http\Controllers\QuoteController::class, 'getSingle']);
