<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use Illuminate\Http\Request;

class ActividadController extends Controller
{
    // Mostrar todas las actividades
    public function index() {
        return response()->json(Actividad::all(), 200);
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