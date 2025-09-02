<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas de la API HERMES
Route::prefix('hermes')->group(function () {
    // Envío de TATC
    Route::post('/tatc', [App\Http\Controllers\Api\HermesController::class, 'enviarTatc']);
    Route::post('/tatc/modificacion', [App\Http\Controllers\Api\HermesController::class, 'enviarModificacionTatc']);
    Route::post('/tatc/cancelacion', [App\Http\Controllers\Api\HermesController::class, 'enviarCancelacionTatc']);
    Route::post('/tatc/traspaso', [App\Http\Controllers\Api\HermesController::class, 'enviarTraspasoTatc']);
    Route::post('/tatc/cumplido', [App\Http\Controllers\Api\HermesController::class, 'enviarCumplidoTatc']);
    
    // Envío de TSTC
    Route::post('/tstc', [App\Http\Controllers\Api\HermesController::class, 'enviarTstc']);
    
    // Envío de Salidas
    Route::post('/salida', [App\Http\Controllers\Api\HermesController::class, 'enviarSalida']);
    
    // Consultas
    Route::post('/consulta', [App\Http\Controllers\Api\HermesController::class, 'consultarEstado']);
    Route::get('/historial', [App\Http\Controllers\Api\HermesController::class, 'obtenerHistorial']);
    Route::get('/estadisticas', [App\Http\Controllers\Api\HermesController::class, 'obtenerEstadisticas']);
    
    // Reintentos
    Route::post('/reintentar', [App\Http\Controllers\Api\HermesController::class, 'reintentarMensajesFallidos']);
});
