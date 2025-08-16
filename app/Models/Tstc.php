<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tstc extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_tstc',
        'operador_id',
        'fecha_emision_tstc',
        'numero_contenedor',
        'tipo_contenedor',
        'destino_contenedor',
        'valor_fob',
        'tara_contenedor',
        'comentario',
        'ingreso_deposito',
        'aduana_salida',
        'fecha_salida_pais',
        'tamano_contenedor',
        'estado_contenedor',
        'codigo_tipo_bulto',
        'anio_fabricacion',
        'empresa_transportista_id',
        'rut_chofer',
        'patente_camion',
        'documento_transporte',
        'estado',
        'user_id',
    ];

    protected $casts = [
        'fecha_emision_tstc' => 'date',
        'ingreso_deposito' => 'date',
        'fecha_salida_pais' => 'datetime',
        'tara_contenedor' => 'decimal:2',
        'valor_fob' => 'decimal:2',
    ];

    /**
     * Relación con el usuario que creó el TSTC
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con el operador
     */
    public function operador(): BelongsTo
    {
        return $this->belongsTo(Operador::class);
    }

    /**
     * Relación con el historial del TSTC
     */
    public function historial(): HasMany
    {
        return $this->hasMany(TstcHistorial::class)->orderBy('created_at', 'desc');
    }

    /**
     * Relación con la empresa transportista
     */
    public function empresaTransportista(): BelongsTo
    {
        return $this->belongsTo(EmpresaTransportista::class, 'empresa_transportista_id');
    }

    /**
     * Scope para TSTCs activos
     */
    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    /**
     * Scope para buscar por número de contenedor
     */
    public function scopePorContenedor($query, $numero)
    {
        return $query->where('numero_contenedor', 'like', '%' . $numero . '%');
    }

    /**
     * Scope para buscar por operador
     */
    public function scopePorOperador($query, $operadorId)
    {
        return $query->where('operador_id', $operadorId);
    }

    /**
     * Generar número TSTC automáticamente
     * Considera tanto TSTCs como TATCs existentes para la numeración secuencial
     */
    public static function generarNumeroTstc($operador, $aduana)
    {
        // Extraer solo los números del código del operador (ej: "S46" -> "46")
        $codigoOperador = preg_replace('/[^0-9]/', '', $operador->codigo);
        
        // Buscar el último TSTC para este operador en esta aduana
        $ultimoTstc = self::where('operador_id', $operador->id)
            ->where('aduana_salida', $aduana)
            ->orderBy('id', 'desc')
            ->first();

        // Buscar el último TATC para esta aduana (considerando todos los operadores)
        $ultimoTatc = \App\Models\Tatc::where('aduana_ingreso', $aduana)
            ->orderBy('id', 'desc')
            ->first();

        // Obtener el número secuencial más alto entre TSTCs y TATCs
        $secuencialTstc = $ultimoTstc ? intval(substr($ultimoTstc->numero_tstc, -6)) : 0;
        $secuencialTatc = $ultimoTatc ? intval(substr($ultimoTatc->numero_tatc, -6)) : 0;
        
        // Usar el número más alto + 1
        $secuencial = max($secuencialTstc, $secuencialTatc) + 1;

        return $aduana . '2' . $codigoOperador . str_pad($secuencial, 6, '0', STR_PAD_LEFT);
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
