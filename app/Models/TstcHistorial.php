<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TstcHistorial extends Model
{
    use HasFactory;

    protected $fillable = [
        'tstc_id',
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

    public function tstc(): BelongsTo
    {
        return $this->belongsTo(Tstc::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
