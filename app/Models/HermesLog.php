<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HermesLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_operacion',
        'numero_documento',
        'payload_enviado',
        'respuesta_recibida',
        'estado',
        'codigo_respuesta',
        'mensaje_error',
        'endpoint',
        'api_key_utilizada',
        'intentos',
        'ultimo_intento',
        'metadata',
    ];

    protected $casts = [
        'payload_enviado' => 'array',
        'respuesta_recibida' => 'array',
        'metadata' => 'array',
        'ultimo_intento' => 'datetime',
    ];

    /**
     * Obtener el TATC asociado
     */
    public function tatc()
    {
        return $this->belongsTo(Tatc::class, 'numero_documento', 'numero_tatc');
    }

    /**
     * Obtener el TSTC asociado
     */
    public function tstc()
    {
        return $this->belongsTo(Tstc::class, 'numero_documento', 'numero_tstc');
    }

    /**
     * Obtener la Salida asociada
     */
    public function salida()
    {
        return $this->belongsTo(Salida::class, 'numero_documento', 'numero_salida');
    }

    /**
     * Scope para filtrar por estado
     */
    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    /**
     * Scope para filtrar por tipo de operación
     */
    public function scopePorTipoOperacion($query, $tipo)
    {
        return $query->where('tipo_operacion', $tipo);
    }

    /**
     * Scope para filtrar por fecha
     */
    public function scopePorFecha($query, $fecha)
    {
        return $query->whereDate('created_at', $fecha);
    }
}
