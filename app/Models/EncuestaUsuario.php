<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EncuestaUsuario extends Model
{
    use HasFactory;
    protected $fillable = [
        'solicitante_id',
        'empresa_id',
        'estado_id',
    ];
}
