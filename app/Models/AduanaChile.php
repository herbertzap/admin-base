<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AduanaChile extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'nombre_aduana',
        'ubicacion',
        'region',
        'direccion',
        'telefono',
        'email',
        'estado',
        'observaciones',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopeActivas($query)
    {
        return $query->where('estado', 'Activo');
    }
}
