<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Aprendiz extends Model
{
    protected $table = 'aprendices';

    protected $fillable = [
        'documento',
        'nombre',
        'correo',
        'ficha',
    ];

    public function fichos(): HasMany
    {
        return $this->hasMany(Ficho::class);
    }

    /**
     * Obtener el ficho de una actividad específica.
     */
    public function fichoPara(Actividad $actividad): ?Ficho
    {
        return $this->fichos()->where('actividad_id', $actividad->id)->first();
    }

    /**
     * Obtener todos los fichos con sus actividades, ordenados.
     */
    public function fichosConActividades()
    {
        return $this->fichos()
            ->with('actividad')
            ->join('actividades', 'fichos.actividad_id', '=', 'actividades.id')
            ->orderBy('actividades.orden')
            ->select('fichos.*');
    }

    /**
     * Conteo rápido de fichos entregados.
     */
    public function getFichosEntregadosCountAttribute(): int
    {
        return $this->fichos()->where('estado', 'entregado')->count();
    }
}
