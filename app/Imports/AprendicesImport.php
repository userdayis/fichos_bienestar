<?php

namespace App\Imports;

use App\Models\Actividad;
use App\Models\Aprendiz;
use App\Models\Ficho;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AprendicesImport implements ToCollection, WithHeadingRow, WithValidation
{
    public int $creados = 0;
    public int $actualizados = 0;
    public int $fichosGenerados = 0;
    public array $errores = [];

    public function collection(Collection $rows): void
    {
        $actividades = Actividad::activas()->get();

        foreach ($rows as $index => $row) {
            try {
                $documento = trim($row['documento'] ?? '');
                if (empty($documento)) {
                    $this->errores[] = "Fila " . ($index + 2) . ": documento vacío";
                    continue;
                }

                $aprendiz = Aprendiz::where('documento', $documento)->first();

                if ($aprendiz) {
                    // Actualizar datos si ya existe
                    $aprendiz->update([
                        'nombre' => trim($row['nombre'] ?? $aprendiz->nombre),
                        'correo' => trim($row['correo'] ?? $row['email'] ?? $aprendiz->correo),
                        'ficha' => trim($row['ficha'] ?? $aprendiz->ficha),
                    ]);
                    $this->actualizados++;
                } else {
                    $aprendiz = Aprendiz::create([
                        'documento' => $documento,
                        'nombre' => trim($row['nombre'] ?? 'Sin nombre'),
                        'correo' => trim($row['correo'] ?? $row['email'] ?? ''),
                        'ficha' => trim($row['ficha'] ?? ''),
                    ]);
                    $this->creados++;
                }

                // Generar fichos para cada actividad (si no existen ya)
                foreach ($actividades as $actividad) {
                    $existe = Ficho::where('aprendiz_id', $aprendiz->id)
                        ->where('actividad_id', $actividad->id)
                        ->exists();

                    if (!$existe) {
                        Ficho::create([
                            'aprendiz_id' => $aprendiz->id,
                            'actividad_id' => $actividad->id,
                            'codigo_qr' => (string) Str::uuid(),
                            'codigo_respaldo' => Ficho::generarCodigoRespaldo(),
                            'estado' => 'pendiente',
                        ]);
                        $this->fichosGenerados++;
                    }
                }
            } catch (\Exception $e) {
                $this->errores[] = "Fila " . ($index + 2) . ": " . $e->getMessage();
            }
        }
    }

    public function rules(): array
    {
        return [
            'documento' => 'required',
            'nombre' => 'required',
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'documento.required' => 'El documento es obligatorio.',
            'nombre.required' => 'El nombre es obligatorio.',
        ];
    }
}
