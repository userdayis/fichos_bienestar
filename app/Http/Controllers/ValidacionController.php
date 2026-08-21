<?php

namespace App\Http\Controllers;

use App\Models\Ficho;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ValidacionController extends Controller
{
    /**
     * Pantalla del escáner QR para el operador.
     */
    public function index()
    {
        $user = auth()->user();

        // Si es admin sin actividad asignada, que seleccione una
        if ($user->esAdmin() && !$user->actividad_id) {
            $actividades = \App\Models\Actividad::activas()->get();
            return view('validacion.seleccionar', compact('actividades'));
        }

        $actividad = $user->actividad;

        return view('validacion.index', compact('actividad'));
    }

    /**
     * Validar un ficho (la operación crítica).
     */
    public function validar(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:50',
            'actividad_id' => 'required|exists:actividades,id',
        ]);

        $codigo = strtoupper(trim($request->input('codigo')));
        $actividadId = $request->input('actividad_id');
        $user = auth()->user();

        // Verificar que el operador tiene permiso para esta actividad
        if (!$user->esAdmin() && $user->actividad_id != $actividadId) {
            return response()->json([
                'status' => 'error',
                'message' => 'No tienes permiso para validar fichos de esta actividad.',
            ], 403);
        }

        try {
            $resultado = DB::transaction(function () use ($codigo, $actividadId, $user) {
                // Buscar el ficho con lock para evitar race conditions
                $ficho = Ficho::where(function ($query) use ($codigo) {
                        $query->where('codigo_qr', $codigo)
                              ->orWhere('codigo_respaldo', $codigo);
                    })
                    ->where('actividad_id', $actividadId)
                    ->lockForUpdate()
                    ->first();

                if (!$ficho) {
                    // Verificar si el código existe pero es de otra actividad
                    $fichoOtraActividad = Ficho::where(function ($query) use ($codigo) {
                        $query->where('codigo_qr', $codigo)
                              ->orWhere('codigo_respaldo', $codigo);
                    })->first();

                    if ($fichoOtraActividad) {
                        return [
                            'status' => 'error_actividad',
                            'message' => 'Este ficho pertenece a otra actividad: ' . $fichoOtraActividad->actividad->nombre,
                        ];
                    }

                    return [
                        'status' => 'no_encontrado',
                        'message' => 'Código no encontrado. Verifica e intenta de nuevo.',
                    ];
                }

                if ($ficho->estaEntregado()) {
                    $operadorNombre = $ficho->operador ? $ficho->operador->name : 'Desconocido';
                    return [
                        'status' => 'ya_entregado',
                        'message' => 'Este ficho ya fue reclamado.',
                        'entregado_en' => $ficho->entregado_en->format('h:i:s A'),
                        'entregado_por' => $operadorNombre,
                        'aprendiz_nombre' => $ficho->aprendiz->nombre,
                        'aprendiz_documento' => $ficho->aprendiz->documento,
                    ];
                }

                // ¡Marcar como entregado!
                $ficho->update([
                    'estado' => 'entregado',
                    'entregado_en' => now(),
                    'entregado_por' => $user->id,
                ]);

                $ficho->load('aprendiz');

                return [
                    'status' => 'entregado',
                    'message' => '¡Entregado ahora!',
                    'aprendiz_nombre' => $ficho->aprendiz->nombre,
                    'aprendiz_documento' => $ficho->aprendiz->documento,
                    'aprendiz_ficha' => $ficho->aprendiz->ficha,
                    'entregado_en' => $ficho->entregado_en->format('h:i:s A'),
                ];
            });

            return response()->json($resultado);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error del sistema. Intenta de nuevo.',
            ], 500);
        }
    }
}
