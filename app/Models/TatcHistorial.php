<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TatcHistorial extends Model
{
    use HasFactory;

    protected $fillable = [
        'tatc_id',
        'user_id',
        'accion',
        'detalles',
        'datos_anteriores',
        'datos_nuevos',
        'estado_anterior',
        'estado_nuevo',
    ];

    protected $casts = [
        'datos_anteriores' => 'array',
        'datos_nuevos' => 'array',
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
}
