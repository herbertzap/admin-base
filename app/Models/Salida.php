<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Salida extends Model
{
    use HasFactory;

    protected $fillable = [
        'tatc_id',
        'numero_salida',
        'fecha_salida',
        'tipo_salida',
        'motivo_salida',
        'numero_contenedor',
        'tipo_contenedor',
        'estado_contenedor',
        'aduana_salida',
        'documento_aduana',
        'numero_documento',
        'empresa_transportista_id',
        'rut_chofer',
        'patente_camion',
        'destino_final',
        'pais_destino',
        'observaciones',
        'estado',
        'user_id',
    ];

    protected $casts = [
        'fecha_salida' => 'date',
    ];

    /**
     * Relación con el TATC
     */
    public function tatc(): BelongsTo
    {
        return $this->belongsTo(Tatc::class);
    }

    /**
     * Relación con el usuario que registró la salida
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con la empresa transportista
     */
    public function empresaTransportista(): BelongsTo
    {
        return $this->belongsTo(EmpresaTransportista::class, 'empresa_transportista_id');
    }

    /**
     * Scope para salidas activas
     */
    public function scopeActivas($query)
    {
        return $query->where('estado', '!=', 'Cancelado');
    }

    /**
     * Scope para buscar por número de contenedor
     */
    public function scopePorContenedor($query, $numero)
    {
        return $query->where('numero_contenedor', 'like', '%' . $numero . '%');
    }

    /**
     * Scope para buscar por tipo de salida
     */
    public function scopePorTipoSalida($query, $tipo)
    {
        return $query->where('tipo_salida', $tipo);
    }

    /**
     * Scope para buscar por aduana
     */
    public function scopePorAduana($query, $aduana)
    {
        return $query->where('aduana_salida', $aduana);
    }

    /**
     * Scope para buscar por rango de fechas
     */
    public function scopePorRangoFechas($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('fecha_salida', [$fechaInicio, $fechaFin]);
    }

    /**
     * Generar número de salida automáticamente
     */
    public static function generarNumeroSalida($tatc, $tipoSalida)
    {
        $ultimaSalida = self::where('tatc_id', $tatc->id)
            ->orderBy('id', 'desc')
            ->first();

        $secuencial = $ultimaSalida ? (intval(substr($ultimaSalida->numero_salida, -3)) + 1) : 1;

        return $tatc->numero_tatc . '-SAL-' . str_pad($secuencial, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Obtener el estado formateado
     */
    public function getEstadoFormateadoAttribute()
    {
        return ucfirst($this->estado);
    }

    /**
     * Obtener el tipo de salida formateado
     */
    public function getTipoSalidaFormateadoAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->tipo_salida));
    }
}
