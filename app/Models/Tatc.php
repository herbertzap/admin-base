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
     * Relación con la empresa transportista
     */
    public function empresaTransportista(): BelongsTo
    {
        return $this->belongsTo(EmpresaTransportista::class, 'empresa_transportista_id');
    }

    /**
     * Relación con las salidas
     */
    public function salidas(): HasMany
    {
        return $this->hasMany(Salida::class, 'tatc_id');
    }

    /**
     * Relación con la aduana
     */
    public function aduana(): BelongsTo
    {
        return $this->belongsTo(AduanaChile::class, 'aduana_ingreso', 'codigo');
    }

    /**
     * Relación con el historial de importación del Excel
     */
    public function historialImportacion(): HasMany
    {
        return $this->hasMany(TatcImportHistorial::class);
    }

    /**
     * Verificar si el TATC puede ser modificado
     */
    public function puedeSerModificado(): bool
    {
        // Si el estado es "finalizado" o "Con Salida", no se puede modificar
        if (in_array($this->estado, ['finalizado', 'Con Salida'])) {
            return false;
        }
        
        // Si tiene salidas aprobadas, no se puede modificar
        $salidasAprobadas = $this->salidas()
            ->where('estado', 'Aprobado')
            ->count();
            
        return $salidasAprobadas === 0;
    }

    /**
     * Obtener el estado formateado
     */
    public function getEstadoFormateadoAttribute()
    {
        return ucfirst($this->estado);
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

    /**
     * Obtener código de operador según resolución HERMES 2024
     */
    private static function obtenerCodigoOperador($operador = null)
    {
        if ($operador) {
            // Buscar código en la tabla de operadores
            $codigo = Operador::where('id', $operador->id)->value('codigo_hermes');
            if ($codigo) {
                return (int) $codigo;
            }
        }
        
        // Código por defecto para S46 (Contenedores Tomás Dagnino)
        return 246;
    }

    /**
     * Generar número de TATC según nueva codificación HERMES 2024
     * Formato: AAAA-AA-OOO-CCCCCCC (16 dígitos)
     * AAAA = Año, AA = Aduana, OOO = Operador, CCCCCCC = Correlativo
     */
    public static function generarNumeroTatcHermes2024($aduanaIngreso, $operador = null)
    {
        // Obtener año actual
        $anio = date('Y');
        
        // Obtener código de aduana (2 dígitos)
        $codigoAduana = self::obtenerCodigoAduana($aduanaIngreso);
        
        // Obtener código de operador (3 dígitos)
        $codigoOperador = self::obtenerCodigoOperador($operador);
        
        // Obtener correlativo anual (7 dígitos)
        $correlativo = self::obtenerCorrelativoAnual($anio);
        
        // Formatear número completo
        $numeroTatc = sprintf('%04d%02d%03d%07d', $anio, $codigoAduana, $codigoOperador, $correlativo);
        
        return $numeroTatc;
    }
    
    /**
     * Obtener código de aduana según resolución HERMES 2024
     */
    private static function obtenerCodigoAduana($aduanaIngreso)
    {
        // Mapeo de aduanas según anexo de la resolución
        $codigosAduana = [
            'Valparaíso' => 34,
            'San Antonio' => 35,
            'Arica' => 31,
            'Iquique' => 32,
            'Antofagasta' => 33,
            'Coquimbo' => 36,
            'Talcahuano' => 37,
            'Coronel' => 38,
            'Puerto Montt' => 39,
            'Punta Arenas' => 40,
            'Aeropuerto Arturo Merino Benítez' => 41,
            'Aeropuerto La Araucanía' => 42,
        ];
        
        return $codigosAduana[$aduanaIngreso] ?? 34; // Default: Valparaíso
    }
    
    /**
     * Obtener correlativo anual para el año especificado
     */
    private static function obtenerCorrelativoAnual($anio)
    {
        // Contar TATCs del año
        $ultimoTatc = self::whereYear('created_at', $anio)
            ->orderBy('id', 'desc')
            ->first();
        
        if ($ultimoTatc) {
            // Extraer correlativo del último TATC
            $correlativo = (int) substr($ultimoTatc->numero_tatc, -7);
            return $correlativo + 1;
        }
        
        return 1; // Primer TATC del año
    }
    
    /**
     * Verificar si el TATC está próximo a vencer (HERMES 2024)
     */
    public function estaProximoAVencer()
    {
        $fechaLimite = $this->created_at->addDays(335); // 30 días antes del vencimiento
        return now()->gte($fechaLimite);
    }
    
    /**
     * Verificar si el TATC puede solicitar prórroga (HERMES 2024)
     */
    public function puedeSolicitarProrroga()
    {
        // Solo se puede prorrogar una vez
        $yaTieneProrroga = $this->prorrogas()->exists();
        
        // Debe estar próximo a vencer
        $proximoAVencer = $this->estaProximoAVencer();
        
        // No debe haber vencido
        $noVencido = $this->created_at->addYear()->gt(now());
        
        return !$yaTieneProrroga && $proximoAVencer && $noVencido;
    }
    
    /**
     * Obtener fecha de vencimiento según HERMES 2024
     */
    public function getFechaVencimientoAttribute()
    {
        return $this->created_at->addYear();
    }
    
    /**
     * Obtener días restantes hasta vencimiento
     */
    public function getDiasRestantesAttribute()
    {
        return now()->diffInDays($this->fecha_vencimiento, false);
    }
}
