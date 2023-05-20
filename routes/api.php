<?php

use App\Http\Controllers\ClienteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/cliente', [ClienteController::class, 'store']);
Route::get('/cliente', [ClienteController::class, 'index']);
Route::put('/cliente', [ClienteController::class, 'update']);
Route::delete('/cliente', [ClienteController::class, 'destroy']);
