<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prorroga extends Model
{
    protected $fillable = [
        'tatc_id',
        'numero_prorroga',
        'fecha_solicitud',
        'fecha_aprobacion',
        'motivo',
        'estado',
        'user_id'
    ];

    protected $casts = [
        'fecha_solicitud' => 'date',
        'fecha_aprobacion' => 'date',
    ];

    /**
     * Relación con TATC
     */
    public function tatc(): BelongsTo
    {
        return $this->belongsTo(Tatc::class);
    }

    /**
     * Relación con Usuario
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generar número de prórroga automático
     */
    public static function generarNumeroProrroga()
    {
        $anio = date('Y');
        $ultimaProrroga = self::where('numero_prorroga', 'like', "PRR{$anio}%")
            ->orderBy('numero_prorroga', 'desc')
            ->first();
        
        if ($ultimaProrroga) {
            $correlativo = (int) substr($ultimaProrroga->numero_prorroga, -7);
            $correlativo++;
        } else {
            $correlativo = 1;
        }
        
        return sprintf('PRR%s%07d', $anio, $correlativo);
    }
}
