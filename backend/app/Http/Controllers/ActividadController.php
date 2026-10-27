<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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

    public function stats() {
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

    // Sprint 5: Validación de reglas de negocio al crear actividad
    public function store(Request $request) {
        $datosValidados = $request->validate([
            'titulo' => 'required|string|max:120',
            'descripcion' => 'nullable|string',
            'asignatura_id' => 'nullable|string',
            'fecha_limite' => 'nullable|date',
            'prioridad' => 'required|in:Baja,Media,Alta',
            'estado' => 'required|in:Pendiente,En Proceso,Completada'
        ]);

        $actividad = Actividad::create($datosValidados);
        Cache::forget('dashboard_stats');
        return response()->json($actividad, 201);
    }

    // Sprint 5: Validación al actualizar estados o datos
    public function update(Request $request, $id) {
        $datosValidados = $request->validate([
            'titulo' => 'sometimes|required|string|max:120',
            'prioridad' => 'sometimes|required|in:Baja,Media,Alta',
            'estado' => 'sometimes|required|in:Pendiente,En Proceso,Completada'
        ]);

        $actividad = Actividad::findOrFail($id);
        $actividad->update($datosValidados);
        Cache::forget('dashboard_stats');
        return response()->json($actividad, 200);
    }

    public function destroy($id) {
        Actividad::destroy($id);
        Cache::forget('dashboard_stats');
        return response()->json(null, 204);
    }
    // Sprint 6: Exportar listado de actividades académicas en formato CSV
    public function exportCsv() {
        $actividades = Actividad::all();
        $csv = "\xEF\xBB\xBF"; // UTF-8 BOM para acentos correctos en Excel
        $csv .= "Titulo,Prioridad,Estado,Fecha Limite\n";

        foreach ($actividades as $act) {
            $titulo = str_replace('"', '""', $act->titulo ?? '');
            $prioridad = $act->prioridad ?? 'Media';
            $estado = $act->estado ?? 'Pendiente';
            $fecha = $act->fecha_limite ?? 'Sin fecha';
            $csv .= "\"{$titulo}\",\"{$prioridad}\",\"{$estado}\",\"{$fecha}\"\n";
        }

        return response($csv, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="reporte_actividades_udg.csv"',
        ]);
    }
}