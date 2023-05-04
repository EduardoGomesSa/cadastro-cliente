<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EnderecoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/clientes', [ClienteController::class, 'store']);
Route::get('/clientes', [ClienteController::class, 'index']);
Route::post('/clientes', [ClienteController::class, 'update']);

Route::post('/enderecos', [EnderecoController::class, 'store']);
Route::get('/enderecos', [EnderecoController::class, 'index']);
Route::get('/clientesporendereco/{id}', [EnderecoController::class, 'clientesPorEndereco']);
Route::post('/enderecos', [EnderecoController::class, 'update']);
Route::get('/show', [EnderecoController::class, 'show']);

// {
//     "logradouro": "Rua 06, 900",
//     "cidade": "Balsas",
//     "estado": "MA",
//     "cep": "65800-000"
// }
