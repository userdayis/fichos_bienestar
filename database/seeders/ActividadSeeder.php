<?php

namespace Database\Seeders;

use App\Models\Actividad;
use Illuminate\Database\Seeder;

class ActividadSeeder extends Seeder
{
    public function run(): void
    {
        $actividades = [
            ['nombre' => 'Alimentación', 'icono' => '🍽️', 'orden' => 1],
            ['nombre' => 'Actividad 2', 'icono' => '🎯', 'orden' => 2],
            ['nombre' => 'Actividad 3', 'icono' => '🎪', 'orden' => 3],
            ['nombre' => 'Actividad 4', 'icono' => '🏆', 'orden' => 4],
        ];

        foreach ($actividades as $actividad) {
            Actividad::firstOrCreate(
                ['nombre' => $actividad['nombre']],
                $actividad
            );
        }
    }
}
