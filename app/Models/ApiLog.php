<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApiLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'customs_declaration_id',
        'endpoint',
        'method',
        'request_data',
        'response_data',
        'response_code',
        'status',
        'error_message',
        'sent_at',
        'received_at',
        'response_time_ms'
    ];

    protected $casts = [
        'request_data' => 'array',
        'response_data' => 'array',
        'sent_at' => 'datetime',
        'received_at' => 'datetime',
    ];

    // Relación con declaración de aduana
    public function customsDeclaration()
    {
        return $this->belongsTo(CustomsDeclaration::class);
    }
}
