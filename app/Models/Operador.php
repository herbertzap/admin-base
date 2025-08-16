<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Operador extends Model
{
    protected $table = 'operadors';
    
    protected $fillable = [
        'codigo',
        'rut_operador',
        'nombre_operador',
        'nombre_fantasia',
        'direccion_operador',
        'resolucion_operador',
        'logo_operador',
        'firma_operador',
        'rut_representante',
        'nombre_representante',
        'cargo_representante',
        'estado',
        'fecha_creacion',
        'fecha_actualizacion',
        'usuario_id',
        'nombre_remitente',
        'email_remitente',
        'email_copia',
        'valida_ingreso_aduana',
        'email_notificaciones',
    ];

    protected $casts = [
        'fecha_creacion' => 'date',
        'fecha_actualizacion' => 'datetime',
        'valida_ingreso_aduana' => 'boolean',
    ];

    /**
     * Relación con el usuario que creó/actualizó el operador
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Relación con los lugares de depósito
     */
    public function lugaresDeposito(): HasMany
    {
        return $this->hasMany(LugarDeposito::class, 'operador_id');
    }

    /**
     * Scope para operadores activos
     */
    public function scopeActivos($query)
    {
        return $query->where('estado', 'Activo');
    }

    /**
     * Obtener la URL del logo
     */
    public function getLogoUrlAttribute()
    {
        return $this->logo_operador ? asset('storage/' . $this->logo_operador) : null;
    }

    /**
     * Obtener la URL de la firma
     */
    public function getFirmaUrlAttribute()
    {
        return $this->firma_operador ? asset('storage/' . $this->firma_operador) : null;
    }
}
