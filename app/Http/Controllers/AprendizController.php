<?php

namespace App\Http\Controllers;

use App\Models\Aprendiz;
use Illuminate\Http\Request;

class AprendizController extends Controller
{
    /**
     * Pantalla de ingreso de documento.
     */
    public function index()
    {
        return view('aprendiz.index');
    }

    /**
     * Buscar aprendiz por documento.
     */
    public function buscar(Request $request)
    {
        $request->validate([
            'documento' => 'required|string|max:20',
        ]);

        $documento = trim($request->input('documento'));

        $aprendiz = Aprendiz::where('documento', $documento)->first();

        if (!$aprendiz) {
            return back()
                ->withInput()
                ->withErrors(['documento' => 'No encontramos ese documento. Acércate al stand de soporte.']);
        }

        return redirect()->route('aprendiz.carnet', $aprendiz->documento);
    }

    /**
     * Mostrar carnet del aprendiz con todos sus fichos.
     */
    public function carnet(string $documento)
    {
        $aprendiz = Aprendiz::where('documento', $documento)->firstOrFail();

        $fichos = $aprendiz->fichos()
            ->with('actividad')
            ->join('actividades', 'fichos.actividad_id', '=', 'actividades.id')
            ->orderBy('actividades.orden')
            ->select('fichos.*')
            ->get();

        $totalActividades = $fichos->count();
        $entregados = $fichos->where('estado', 'entregado')->count();

        return view('aprendiz.carnet', compact('aprendiz', 'fichos', 'totalActividades', 'entregados'));
    }
}
