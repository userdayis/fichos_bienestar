<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Actividad;
use App\Models\Aprendiz;
use App\Models\Ficho;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ActividadController extends Controller
{
    public function index()
    {
        $actividades = Actividad::orderBy('orden')->get();
        return view('admin.actividades.index', compact('actividades'));
    }

    public function create()
    {
        return view('admin.actividades.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:actividades,nombre',
            'descripcion' => 'nullable|string|max:500',
            'icono' => 'nullable|string|max:50',
            'orden' => 'nullable|integer|min:0',
        ]);

        $actividad = Actividad::create($request->only(['nombre', 'descripcion', 'icono', 'orden']));

        // Generar fichos para todos los aprendices existentes
        $aprendices = Aprendiz::all();
        $count = 0;
        foreach ($aprendices as $aprendiz) {
            Ficho::create([
                'aprendiz_id' => $aprendiz->id,
                'actividad_id' => $actividad->id,
                'codigo_qr' => (string) Str::uuid(),
                'codigo_respaldo' => Ficho::generarCodigoRespaldo(),
                'estado' => 'pendiente',
            ]);
            $count++;
        }

        return redirect()->route('admin.actividades.index')
            ->with('success', "Actividad «{$actividad->nombre}» creada. Se generaron {$count} fichos.");
    }

    public function edit(Actividad $actividad)
    {
        return view('admin.actividades.edit', compact('actividad'));
    }

    public function update(Request $request, Actividad $actividad)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:actividades,nombre,' . $actividad->id,
            'descripcion' => 'nullable|string|max:500',
            'icono' => 'nullable|string|max:50',
            'orden' => 'nullable|integer|min:0',
            'activa' => 'boolean',
        ]);

        $actividad->update($request->only(['nombre', 'descripcion', 'icono', 'orden', 'activa']));

        return redirect()->route('admin.actividades.index')
            ->with('success', "Actividad «{$actividad->nombre}» actualizada.");
    }

    public function destroy(Actividad $actividad)
    {
        $entregados = $actividad->fichos()->entregado()->count();

        if ($entregados > 0) {
            return back()->with('error', "No se puede eliminar: hay {$entregados} fichos ya entregados.");
        }

        $actividad->delete();

        return redirect()->route('admin.actividades.index')
            ->with('success', "Actividad eliminada.");
    }
}
