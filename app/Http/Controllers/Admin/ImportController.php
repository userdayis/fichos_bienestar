<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\AprendicesImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function show()
    {
        return view('admin.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:xlsx,xls,csv|max:10240',
        ]);

        $import = new AprendicesImport();

        try {
            Excel::import($import, $request->file('archivo'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errores = [];
            foreach ($failures as $failure) {
                $errores[] = "Fila {$failure->row()}: " . implode(', ', $failure->errors());
            }

            return back()->with('errores_validacion', $errores);
        }

        return back()->with('resultado', [
            'creados' => $import->creados,
            'actualizados' => $import->actualizados,
            'fichos_generados' => $import->fichosGenerados,
            'errores' => $import->errores,
        ]);
    }
}
