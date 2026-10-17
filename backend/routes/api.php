<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActividadController;

// Sprint 5: Endpoint de verificación de estado de la API (Health Check)
Route::get('health', function () {
    return response()->json([
        'status' => 'ok',
        'servicio' => 'API Prototipo Tareas UDG',
        'version' => '1.0.0-sprint5'
    ], 200);
});

// Ruta para las métricas del Dashboard
Route::get('actividades/stats', [ActividadController::class, 'stats']);

// Rutas estándar del CRUD
Route::apiResource('actividades', ActividadController::class);