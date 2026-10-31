<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActividadController;

// Endpoint de verificación de estado de la API (Health Check)
Route::get('health', function () {
    return response()->json([
        'status' => 'ok',
        'servicio' => 'API Prototipo Tareas UDG',
        'version' => '1.2.0-sprint7'
    ], 200);
});

// Ruta para las métricas del Dashboard
Route::get('actividades/stats', [ActividadController::class, 'stats']);

// Sprint 6: Ruta para exportar reporte de actividades en CSV
Route::get('actividades/export/csv', [ActividadController::class, 'exportCsv']);

// Sprint 7: Ruta para sincronizar calendario en formato iCalendar (.ics)
Route::get('actividades/export/ics', [ActividadController::class, 'exportIcs']);

// Rutas estándar del CRUD
Route::apiResource('actividades', ActividadController::class);