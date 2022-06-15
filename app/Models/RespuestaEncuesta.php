<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespuestaEncuesta extends Model
{
    use HasFactory;
    
    protected $fillable = ['pregunta_id','respuesta'];


    public function pregunta()
    {
        return $this->belongsTo(PreguntaEncuesta::class, 'pregunta_id');
    }
}
