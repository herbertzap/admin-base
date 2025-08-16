<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpresaTransportista extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_empresa',
        'rut_empresa',
        'direccion',
        'ciudad',
        'telefono',
        'email',
        'contacto_persona',
        'contacto_telefono',
        'contacto_email',
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
