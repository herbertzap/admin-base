<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'titulo',
        'descripcion',
        'estado',
        'user_id',
        'asignado_a',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function asignado()
    {
        return $this->belongsTo(User::class, 'asignado_a');
    }
}
