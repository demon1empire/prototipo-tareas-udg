<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache; // Importamos Cache para el Sprint 4

class ActividadController extends Controller
{
    public function index(Request $request) {
        $query = Actividad::query();
        if ($request->has('estado') && $request->estado != '') {
            $query->where('estado', $request->estado);
        }
        if ($request->has('buscar') && $request->buscar != '') {
            $query->where('titulo', 'like', '%' . $request->buscar . '%');
        }
        return response()->json($query->get(), 200);
    }

    // Sprint 4: Implementación de Caché para optimizar rendimiento
    public function stats() {
        // Guarda las métricas en caché por 5 minutos para no saturar MongoDB
        $metricas = Cache::remember('dashboard_stats', 300, function () {
            $total = Actividad::count();
            $completadas = Actividad::where('estado', 'Completada')->count();
            $pendientes = Actividad::where('estado', 'Pendiente')->count();
            $avance = $total > 0 ? ($completadas / $total) * 100 : 0;

            return [
                'total' => $total,
                'completadas' => $completadas,
                'pendientes' => $pendientes,
                'avance' => round($avance, 2)
            ];
        });

        return response()->json($metricas);
    }

    public function store(Request $request) {
        $actividad = Actividad::create($request->all());
        Cache::forget('dashboard_stats'); // Limpia el caché al agregar tarea
        return response()->json($actividad, 201);
    }

    public function update(Request $request, $id) {
        $actividad = Actividad::findOrFail($id);
        $actividad->update($request->all());
        Cache::forget('dashboard_stats'); // Limpia el caché al actualizar
        return response()->json($actividad, 200);
    }

    public function destroy($id) {
        Actividad::destroy($id);
        Cache::forget('dashboard_stats'); // Limpia el caché al borrar
        return response()->json(null, 204);
    }
}