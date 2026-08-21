<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Actividad;
use App\Models\Aprendiz;
use App\Models\Ficho;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FichosExport;

class FichoController extends Controller
{
    public function index(Request $request)
    {
        $documento = $request->input('documento');
        $aprendiz = null;
        $fichos = collect();

        if ($documento) {
            $aprendiz = Aprendiz::where('documento', trim($documento))->first();
            if ($aprendiz) {
                $fichos = $aprendiz->fichos()
                    ->with(['actividad', 'operador'])
                    ->join('actividades', 'fichos.actividad_id', '=', 'actividades.id')
                    ->orderBy('actividades.orden')
                    ->select('fichos.*')
                    ->get();
            }
        }

        return view('admin.fichos.index', compact('documento', 'aprendiz', 'fichos'));
    }

    public function resetear(Ficho $ficho)
    {
        $ficho->update([
            'estado' => 'pendiente',
            'entregado_en' => null,
            'entregado_por' => null,
        ]);

        return back()->with('success', "Ficho {$ficho->codigo_respaldo} reseteado a pendiente.");
    }

    public function exportar(Actividad $actividad)
    {
        $filename = 'fichos_' . \Illuminate\Support\Str::slug($actividad->nombre) . '_' . now()->format('Y-m-d_His') . '.xlsx';
        return Excel::download(new FichosExport($actividad->id), $filename);
    }
}
