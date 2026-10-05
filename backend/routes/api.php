<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActividadController;

// Ruta para las métricas del Dashboard (Siempre debe ir ANTES del apiResource)
Route::get('actividades/stats', [ActividadController::class, 'stats']);

// Rutas estándar del CRUD (index, store, update, destroy)
Route::apiResource('actividades', ActividadController::class);