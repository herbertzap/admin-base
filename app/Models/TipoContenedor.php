<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TipoContenedor extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'descripcion',
        'estado',
        'operador_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación con el operador
     */
    public function operador(): BelongsTo
    {
        return $this->belongsTo(Operador::class, 'operador_id');
    }

    public function scopeActivos($query)
    {
        return $query->where('estado', 'Activo');
    }
}
