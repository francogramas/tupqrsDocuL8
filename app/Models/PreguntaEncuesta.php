<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreguntaEncuesta extends Model
{
    use HasFactory;

    public function respuestas()
    {
        return $this->hasMany(RespuestaEncuesta::class, 'pregunta_id');
    }
}
