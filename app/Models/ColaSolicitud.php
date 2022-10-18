<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColaSolicitud extends Model
{
    use HasFactory;
    protected $fillable = ['user_id',
                           'solicitudEntrada',
                           'solicitudSalida',
                           'seccion_id',
                           'finalizada',
                        ];


    public function entrada()
    {
        return $this->belongsTo(Solicitud::class, 'solicitudEntrada');
    }

    public function salida()
    {
        return $this->belongsTo(Solicitud::class, 'solicitudSalida');
    }
}
