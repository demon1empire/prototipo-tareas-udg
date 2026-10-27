<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActividadController;

// Sprint 5: Endpoint de verificación de estado de la API (Health Check)
Route::get('health', function () {
    return response()->json([
        'status' => 'ok',
        'servicio' => 'API Prototipo Tareas UDG',
        'version' => '1.1.0-sprint6'
    ], 200);
});

// Ruta para las métricas del Dashboard
Route::get('actividades/stats', [ActividadController::class, 'stats']);

// Sprint 6: Ruta para exportar reporte de actividades en CSV
Route::get('actividades/export/csv', [ActividadController::class, 'exportCsv']);

// Rutas estándar del CRUD
Route::apiResource('actividades', ActividadController::class);