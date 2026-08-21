<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Actividad extends Model
{
    protected $table = 'actividades';

    protected $fillable = [
        'nombre',
        'descripcion',
        'icono',
        'orden',
        'activa',
    ];

    protected $casts = [
        'activa' => 'boolean',
        'orden' => 'integer',
    ];

    public function fichos(): HasMany
    {
        return $this->hasMany(Ficho::class);
    }

    public function operadores(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function scopeActivas($query)
    {
        return $query->where('activa', true)->orderBy('orden');
    }

    /**
     * Estadísticas rápidas de esta actividad.
     */
    public function getStatsAttribute(): array
    {
        $total = $this->fichos()->count();
        $entregados = $this->fichos()->where('estado', 'entregado')->count();
        $pendientes = $total - $entregados;
        $porcentaje = $total > 0 ? round(($entregados / $total) * 100, 1) : 0;

        return [
            'total' => $total,
            'entregados' => $entregados,
            'pendientes' => $pendientes,
            'porcentaje' => $porcentaje,
        ];
    }
}
