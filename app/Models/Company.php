<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'rut',
        'address',
        'city',
        'phone',
        'email',
        'contact_person',
        'contact_phone',
        'contact_email',
        'is_active',
        'notes'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relación con declaraciones de aduana
    public function customsDeclarations()
    {
        return $this->hasMany(CustomsDeclaration::class);
    }
}
