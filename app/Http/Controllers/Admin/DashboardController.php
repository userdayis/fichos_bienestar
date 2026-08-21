<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Actividad;
use App\Models\Aprendiz;
use App\Models\Ficho;

class DashboardController extends Controller
{
    public function index()
    {
        $actividades = Actividad::activas()->get();
        $totalAprendices = Aprendiz::count();
        $totalFichos = Ficho::count();
        $totalEntregados = Ficho::entregado()->count();
        $totalPendientes = Ficho::pendiente()->count();

        // Stats por actividad
        $statsPorActividad = $actividades->map(function ($actividad) {
            $total = $actividad->fichos()->count();
            $entregados = $actividad->fichos()->entregado()->count();
            return [
                'id' => $actividad->id,
                'nombre' => $actividad->nombre,
                'icono' => $actividad->icono,
                'total' => $total,
                'entregados' => $entregados,
                'pendientes' => $total - $entregados,
                'porcentaje' => $total > 0 ? round(($entregados / $total) * 100, 1) : 0,
            ];
        });

        return view('admin.dashboard', compact(
            'actividades',
            'totalAprendices',
            'totalFichos',
            'totalEntregados',
            'totalPendientes',
            'statsPorActividad'
        ));
    }

    /**
     * Endpoint AJAX para stats en tiempo real.
     */
    public function stats()
    {
        $actividades = Actividad::activas()->get();
        $stats = $actividades->map(function ($actividad) {
            $total = $actividad->fichos()->count();
            $entregados = $actividad->fichos()->entregado()->count();
            return [
                'id' => $actividad->id,
                'nombre' => $actividad->nombre,
                'total' => $total,
                'entregados' => $entregados,
                'pendientes' => $total - $entregados,
                'porcentaje' => $total > 0 ? round(($entregados / $total) * 100, 1) : 0,
            ];
        });

        return response()->json([
            'total_aprendices' => Aprendiz::count(),
            'total_fichos' => Ficho::count(),
            'total_entregados' => Ficho::entregado()->count(),
            'total_pendientes' => Ficho::pendiente()->count(),
            'actividades' => $stats,
        ]);
    }
}
