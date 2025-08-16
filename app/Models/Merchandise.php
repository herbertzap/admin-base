<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Merchandise extends Model
{
    use HasFactory;

    protected $table = 'merchandise';

    protected $fillable = [
        'customs_declaration_id',
        'item_number',
        'description',
        'hs_code',
        'origin_country',
        'quantity',
        'unit_of_measure',
        'unit_value',
        'total_value',
        'weight',
        'brand',
        'model',
        'additional_info'
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_value' => 'decimal:2',
        'total_value' => 'decimal:2',
        'weight' => 'decimal:2',
    ];

    // Relación con declaración de aduana
    public function customsDeclaration()
    {
        return $this->belongsTo(CustomsDeclaration::class);
    }
}
