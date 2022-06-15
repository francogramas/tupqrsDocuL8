<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespuestaUsuario extends Model
{
    use HasFactory;
    protected $fillable = [
        'pregunta_id',
        'respuesta_id',
        'encuesta_id',
        'respuesta_texto',   
    ];
}
