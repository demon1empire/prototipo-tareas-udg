<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use Illuminate\Http\Request;

class ActividadController extends Controller
{
    // Mostrar actividades con filtros dinámicos (Sprint 3)
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

    // Nuevas métricas para el Dashboard (Sprint 3)
    public function stats() {
        $total = Actividad::count();
        $completadas = Actividad::where('estado', 'Completada')->count();
        $pendientes = Actividad::where('estado', 'Pendiente')->count();
        
        $avance = $total > 0 ? ($completadas / $total) * 100 : 0;

        return response()->json([
            'total' => $total,
            'completadas' => $completadas,
            'pendientes' => $pendientes,
            'avance' => round($avance, 2)
        ]);
    }

    // Guardar una nueva actividad (Pendiente por defecto)
    public function store(Request $request) {
        $actividad = Actividad::create($request->all());
        return response()->json($actividad, 201);
    }

    // Actualizar estados (En proceso, Completada) o datos
    public function update(Request $request, $id) {
        $actividad = Actividad::findOrFail($id);
        $actividad->update($request->all());
        return response()->json($actividad, 200);
    }

    // Eliminar actividad
    public function destroy($id) {
        Actividad::destroy($id);
        return response()->json(null, 204);
    }
}