<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\CanResetPassword;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'operador_id',
        'fotografia',
        'rut_usuario',
        'estado',
        'ultimo_movimiento',
        'fecha_renovacion_password',
        'cambio_password_requerido',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'ultimo_movimiento' => 'datetime',
        'fecha_renovacion_password' => 'datetime',
        'cambio_password_requerido' => 'boolean',
    ];

    /**
     * Relación con el operador asociado
     */
    public function operador(): BelongsTo
    {
        return $this->belongsTo(Operador::class, 'operador_id');
    }

    /**
     * Verificar si el usuario es super admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super-admin');
    }

    /**
     * Verificar si el usuario es admin
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin') || $this->hasRole('super-admin');
    }

    /**
     * Verificar si el usuario tiene operador asociado
     */
    public function hasOperador(): bool
    {
        return !is_null($this->operador_id);
    }

    /**
     * Verificar si el usuario puede editar otros usuarios
     */
    public function canEditUsers(): bool
    {
        return $this->isAdmin();
    }

    /**
     * Verificar si el usuario puede crear usuarios
     */
    public function canCreateUsers(): bool
    {
        return $this->isAdmin() || $this->hasOperador();
    }

    /**
     * Obtener la URL de la fotografía
     */
    public function getFotografiaUrlAttribute()
    {
        return $this->fotografia ? asset('storage/' . $this->fotografia) : asset('assets/img/default-avatar.png');
    }

    /**
     * Actualizar último movimiento
     */
    public function updateLastMovement()
    {
        $this->update(['ultimo_movimiento' => now()]);
    }

    /**
     * Verificar si necesita renovar contraseña
     */
    public function needsPasswordRenewal(): bool
    {
        if (!$this->fecha_renovacion_password) {
            return false;
        }
        
        $daysUntilRenewal = Carbon::now()->diffInDays($this->fecha_renovacion_password, false);
        return $daysUntilRenewal <= 90 && $daysUntilRenewal > 0;
    }

    /**
     * Obtener días restantes para renovar contraseña
     */
    public function getDaysUntilPasswordRenewal(): int
    {
        if (!$this->fecha_renovacion_password) {
            return 0;
        }
        
        return Carbon::now()->diffInDays($this->fecha_renovacion_password, false);
    }

    /**
     * Scope para usuarios activos
     */
    public function scopeActivos($query)
    {
        return $query->where('estado', 'Activo');
    }

    /**
     * Scope para usuarios por operador
     */
    public function scopeByOperador($query, $operadorId)
    {
        return $query->where('operador_id', $operadorId);
    }
}
