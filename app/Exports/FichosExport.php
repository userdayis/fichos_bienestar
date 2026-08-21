<?php

namespace App\Exports;

use App\Models\Ficho;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FichosExport implements FromQuery, WithHeadings, WithMapping
{
    public function __construct(private int $actividadId)
    {
    }

    public function query()
    {
        return Ficho::query()
            ->where('actividad_id', $this->actividadId)
            ->with(['aprendiz', 'actividad', 'operador'])
            ->orderBy('aprendiz_id');
    }

    public function headings(): array
    {
        return [
            'Documento',
            'Nombre Aprendiz',
            'Ficha',
            'Correo',
            'Actividad',
            'Código Respaldo',
            'Estado',
            'Entregado En',
            'Entregado Por',
        ];
    }

    public function map($ficho): array
    {
        return [
            $ficho->aprendiz->documento,
            $ficho->aprendiz->nombre,
            $ficho->aprendiz->ficha,
            $ficho->aprendiz->correo,
            $ficho->actividad->nombre,
            $ficho->codigo_respaldo,
            $ficho->estado,
            $ficho->entregado_en ? $ficho->entregado_en->format('Y-m-d H:i:s') : '',
            $ficho->operador ? $ficho->operador->name : '',
        ];
    }
}
