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
        'fecha_emision_tatc',
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
        'fecha_emision_tatc' => 'date',
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
     * Relación con el tipo de contenedor
     */
    public function tipoContenedor(): BelongsTo
    {
        return $this->belongsTo(TipoContenedor::class, 'tipo_contenedor', 'codigo');
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
     * Convierte código alfanumérico (S46) a set numérico (246) según Anexo 51-36
     */
    private static function obtenerCodigoOperador($operador = null)
    {
        // Mapeo de códigos alfanuméricos a set numérico según Anexo 51-36
        $codigosOperador = [
            'S46' => 246, // CONTENEDORES TOMAS DAGNINO VICENCIO E.I.R.L.
            // Agregar más operadores según sea necesario
        ];
        
        if ($operador) {
            // Buscar código alfanumérico en la tabla de operadores
            $codigoAlfanumerico = Operador::where('id', $operador->id)->value('codigo');
            if ($codigoAlfanumerico && isset($codigosOperador[$codigoAlfanumerico])) {
                return $codigosOperador[$codigoAlfanumerico];
            }
        }
        
        // Código por defecto para S46 (Contenedores Tomás Dagnino) = 246
        return 246;
    }

    /**
     * Generar número de TATC según nueva codificación HERMES 2024
     * Formato: AAAA-AA-OOO-CCCCCCC (16 dígitos)
     * AAAA = Año (4 dígitos), AA = Aduana (2 dígitos), OOO = Operador (3 dígitos), CCCCCCC = Correlativo (7 dígitos)
     * Ejemplo: 2025341170000001
     */
    public static function generarNumeroTatcHermes2024($aduanaIngreso, $operador = null)
    {
        // Obtener año actual (4 dígitos)
        $anio = date('Y');
        
        // Obtener código de aduana (2 dígitos)
        $codigoAduana = self::obtenerCodigoAduana($aduanaIngreso);
        
        // Obtener código de operador (3 dígitos)
        $codigoOperador = self::obtenerCodigoOperador($operador);
        
        // Obtener correlativo anual por aduana y operador (7 dígitos)
        $correlativo = self::obtenerCorrelativoAnualPorAduanaOperador($anio, $codigoAduana, $codigoOperador);
        
        // Formatear número completo según HERMES 2024
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
     * Obtener correlativo anual para el año especificado (método legacy)
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
     * Obtener correlativo anual por aduana y operador según HERMES 2024
     * Considera tanto TATCs con formato nuevo como formato antiguo
     */
    private static function obtenerCorrelativoAnualPorAduanaOperador($anio, $codigoAduana, $codigoOperador)
    {
        // Buscar el último TATC del año con la misma aduana y operador (formato nuevo HERMES 2024)
        $ultimoTatcNuevo = self::whereYear('created_at', $anio)
            ->where('numero_tatc', 'like', $anio . sprintf('%02d%03d', $codigoAduana, $codigoOperador) . '%')
            ->orderBy('numero_tatc', 'desc')
            ->first();
        
        // Buscar TATCs antiguos de la misma aduana (formato antiguo)
        $tatcsAntiguos = self::where('aduana_ingreso', $codigoAduana)
            ->whereYear('created_at', $anio)
            ->get();
        
        $correlativoNuevo = 0;
        $correlativoAntiguo = 0;
        
        // Obtener correlativo del formato nuevo
        if ($ultimoTatcNuevo) {
            $correlativoNuevo = (int) substr($ultimoTatcNuevo->numero_tatc, -7);
        }
        
        // Obtener correlativo del formato antiguo (contar TATCs existentes)
        $correlativoAntiguo = $tatcsAntiguos->count();
        
        // Usar el mayor correlativo + 1
        $correlativo = max($correlativoNuevo, $correlativoAntiguo) + 1;
        
        return $correlativo;
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
