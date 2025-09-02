<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TatcImportHistorial extends Model
{
    use HasFactory;

    protected $fillable = [
        'tatc_id',
        'archivo_origen',
        'operador',
        'tipo_ingreso',
        'fecha_ingreso_pais',
        'fecha_ingreso_deposito',
        'numero_contenedor',
        'aduana',
        'numero_tatc',
        'eir',
        'tatc_origen',
        'tatc_destino',
        'tipo_contenedor',
        'tamano_contenedor',
        'documento_ingreso',
        'puerto_ingreso',
        'tatc_emisor',
        'tatc_ingreso',
        'fecha_traspaso',
        'tara_contenedor',
        'anio_fabricacion',
        'estado_contenedor',
        'tipo_bulto',
        'valor_cif',
        'comentario',
        'fecha_registro',
        'usuario_registro',
        'estado',
    ];

    protected $casts = [
        'fecha_ingreso_pais' => 'date',
        'fecha_ingreso_deposito' => 'date',
        'fecha_traspaso' => 'date',
        'fecha_registro' => 'date',
        'tara_contenedor' => 'decimal:2',
        'valor_cif' => 'decimal:2',
        'anio_fabricacion' => 'integer',
    ];

    /**
     * Relación con TATC
     */
    public function tatc(): BelongsTo
    {
        return $this->belongsTo(Tatc::class);
    }
}
