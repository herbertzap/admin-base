<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LugarDeposito extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'nombre_deposito',
        'direccion',
        'ciudad',
        'region',
        'capacidad',
        'telefono',
        'email',
        'operador_id',
        'estado',
        'observaciones',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function operador()
    {
        return $this->belongsTo(Operador::class);
    }

    public function scopeActivos($query)
    {
        return $query->where('estado', 'Activo');
    }
}
