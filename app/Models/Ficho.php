<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ficho extends Model
{
    protected $table = 'fichos';

    protected $fillable = [
        'aprendiz_id',
        'actividad_id',
        'codigo_qr',
        'codigo_respaldo',
        'estado',
        'entregado_en',
        'entregado_por',
    ];

    protected $casts = [
        'entregado_en' => 'datetime',
    ];

    public function aprendiz(): BelongsTo
    {
        return $this->belongsTo(Aprendiz::class);
    }

    public function actividad(): BelongsTo
    {
        return $this->belongsTo(Actividad::class);
    }

    public function operador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'entregado_por');
    }

    // Scopes
    public function scopePendiente($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeEntregado($query)
    {
        return $query->where('estado', 'entregado');
    }

    /**
     * ¿Ya fue entregado?
     */
    public function estaEntregado(): bool
    {
        return $this->estado === 'entregado';
    }

    /**
     * Generar un código de respaldo único (formato XXX-XXXX).
     */
    public static function generarCodigoRespaldo(): string
    {
        $caracteres = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789'; // Sin I, O, 0, 1 para evitar confusión
        $maxIntentos = 100;

        for ($i = 0; $i < $maxIntentos; $i++) {
            $codigo = '';
            for ($j = 0; $j < 3; $j++) {
                $codigo .= $caracteres[random_int(0, strlen($caracteres) - 1)];
            }
            $codigo .= '-';
            for ($j = 0; $j < 4; $j++) {
                $codigo .= $caracteres[random_int(0, strlen($caracteres) - 1)];
            }

            if (!self::where('codigo_respaldo', $codigo)->exists()) {
                return $codigo;
            }
        }

        throw new \RuntimeException('No se pudo generar un código de respaldo único después de ' . $maxIntentos . ' intentos.');
    }
}
