<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contenedor extends Model
{
    use HasFactory;

    // Estados del contenedor según Mitac
    const ESTADO_DISPONIBLE = 'Disponible en Stock';
    const ESTADO_VENDIDO = 'Vendido';
    const ESTADO_ARRENDADO = 'Arrendado';
    const ESTADO_RESERVADO = 'Reservado';
    const ESTADO_FACTURADO = 'Facturado';
    const ESTADO_BAJA = 'Dado de Baja';

    public static function getEstados()
    {
        return [
            self::ESTADO_DISPONIBLE,
            self::ESTADO_VENDIDO,
            self::ESTADO_ARRENDADO,
            self::ESTADO_RESERVADO,
            self::ESTADO_FACTURADO,
            self::ESTADO_BAJA,
        ];
    }

    protected $table = 'contenedors';

    protected $fillable = [
        // Datos Contenedor
        'numero_contenedor', 'tipo_contenedor_id', 'tamano_contenedor', 'estado_contenedor',
        'tara_contenedor', 'anofab_contenedor', 'pais_id', 'ingreso_doc', 'comentario',
        'fecha_ingreso', 'tatc', 'lugardeposito_id', 'aduana_ingreso_id', 'operador_id',
        
        // TATC Asociado
        'origen_tatc', 'destino_tatc', 'tatc_emisor', 'tatc_ingreso', 'tipo_ingreso', 'eir', 'comentario_tatc',
        
        // Facturación
        'rut_factura', 'nombre_factura', 'direccion_factura', 'giro_factura', 'fecha_factura',
        'orden_compra', 'tipo_pago', 'valor_factura', 'reserva_nombre', 'comentario_facturacion',
        'factura_oc', 'factura_comentario',
        
        // Transporte
        'empresa_transportista_id', 'rut_chofer', 'patente_camion', 'documento_transporte', 'transporte_documento',
        
        // Datos Extras
        'extra_proveedor_nombre', 'extra_proveedor_factura', 'extra_proveedor_valor', 'extra_proveedor_fecha',
        'extra_panama_factura', 'extra_panama_valor', 'extra_panama_fecha', 'extra_cym_factura', 'extra_cym_valor', 'extra_cym_fecha',
        'extra_boxtam_factura', 'extra_boxtam_fecha', 'extra_ciudad', 'extra_tipo',
        
        // Estado
        'estado',
    ];

    protected $casts = [
        'fecha_ingreso' => 'date', 
        'fecha_factura' => 'date', 
        'tara_contenedor' => 'integer',
        'anofab_contenedor' => 'integer', 
        'valor_factura' => 'integer',
        'extra_proveedor_fecha' => 'date',
        'extra_panama_fecha' => 'date',
        'extra_cym_fecha' => 'date',
        'extra_boxtam_fecha' => 'date',
    ];

    /**
     * Relación con el operador
     */
    public function operador(): BelongsTo
    {
        return $this->belongsTo(Operador::class, 'operador_id');
    }

    /**
     * Relación con el tipo de contenedor
     */
    public function tipoContenedor(): BelongsTo
    {
        return $this->belongsTo(TipoContenedor::class, 'tipo_contenedor_id');
    }

    /**
     * Relación con el lugar de depósito
     */
    public function lugarDeposito(): BelongsTo
    {
        return $this->belongsTo(LugarDeposito::class, 'lugardeposito_id');
    }

    /**
     * Relación con la empresa transportista
     */
    public function empresaTransportista(): BelongsTo
    {
        return $this->belongsTo(EmpresaTransportista::class, 'empresa_transportista_id');
    }

    /**
     * Relación con la aduana de ingreso
     */
    public function aduanaIngreso(): BelongsTo
    {
        return $this->belongsTo(AduanaChile::class, 'aduana_ingreso_id');
    }

    public function scopeActivos($query)
    {
        return $query->where('estado', 'Activo');
    }
}
