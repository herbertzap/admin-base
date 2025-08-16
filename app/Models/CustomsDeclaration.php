<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomsDeclaration extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'user_id',
        'declaration_number',
        'document_type',
        'status',
        'declaration_date',
        'customs_office',
        'transport_mode',
        'container_number',
        'bill_of_lading',
        'total_value',
        'total_weight',
        'description',
        'hermes_message',
        'hermes_response',
        'sent_to_hermes_at',
        'hermes_processed_at',
        'notes'
    ];

    protected $casts = [
        'declaration_date' => 'date',
        'sent_to_hermes_at' => 'datetime',
        'hermes_processed_at' => 'datetime',
        'hermes_message' => 'array',
        'hermes_response' => 'array',
        'total_value' => 'decimal:2',
        'total_weight' => 'decimal:2',
    ];

    // Relación con empresa
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Relación con usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con mercancías
    public function merchandise()
    {
        return $this->hasMany(Merchandise::class);
    }

    // Relación con logs de API
    public function apiLogs()
    {
        return $this->hasMany(ApiLog::class);
    }
}
