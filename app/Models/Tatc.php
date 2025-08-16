<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tatc extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_tatc',
        'numero_contenedor',
        'tipo_contenedor',
        'tipo_ingreso',
        'ingreso_pais',
        'ingreso_deposito',
        'tatc_origen',
        'tatc_destino',
        'documento_ingreso',
        'fecha_traspaso',
        'tara_contenedor',
        'tipo_bulto',
        'valor_fob',
        'comentario',
        'aduana_ingreso',
        'eir',
        'tamano_contenedor',
        'puerto_ingreso',
        'estado_contenedor',
        'anio_fabricacion',
        'ubicacion_fisica',
        'valor_cif',
        'empresa_transportista_id',
        'rut_chofer',
        'patente_camion',
        'documento_transporte',
        'estado',
        'hermes_request',
        'hermes_response',
        'hermes_status',
        'hermes_message_id',
        'hermes_sent_at',
        'hermes_processed_at',
        'user_id',
    ];

    protected $casts = [
        'ingreso_pais' => 'datetime',
        'ingreso_deposito' => 'datetime',
        'fecha_traspaso' => 'date',
        'valor_fob' => 'decimal:2',
        'valor_cif' => 'decimal:2',
        'hermes_request' => 'array',
        'hermes_response' => 'array',
        'hermes_sent_at' => 'datetime',
        'hermes_processed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación con el usuario que creó el TATC
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con el historial del TATC
     */
    public function historial(): HasMany
    {
        return $this->hasMany(TatcHistorial::class)->orderBy('created_at', 'desc');
    }

    /**
     * Relación con la empresa transportista
     */
    public function empresaTransportista(): BelongsTo
    {
        return $this->belongsTo(EmpresaTransportista::class, 'empresa_transportista_id');
    }

    public function scopePendientes($query)
    {
        return $query->where('estado', 'Pendiente');
    }

    public function scopeAprobados($query)
    {
        return $query->where('estado', 'Aprobado');
    }

    public function scopeVencidos($query)
    {
        return $query->where('estado', 'Vencido');
    }

    public function scopeEnviadosHermes($query)
    {
        return $query->whereNotNull('hermes_sent_at');
    }

    public function scopeNoEnviadosHermes($query)
    {
        return $query->whereNull('hermes_sent_at');
    }

    public function isVencido()
    {
        return $this->fecha_vencimiento < now();
    }

    public function isEnviadoHermes()
    {
        return !is_null($this->hermes_sent_at);
    }

    public function isAprobadoHermes()
    {
        return $this->hermes_status === 'Aprobado';
    }
}
