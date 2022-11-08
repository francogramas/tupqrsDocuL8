<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleExpediente extends Model
{
    use HasFactory;

    protected $fillable = [
                            'user_id',
                            'expediente_id',
                            'seccion_id',
                            'empresa_id',
                            'serie_id',
                            'subserie_id',
                            'medio_id',
                            'folios',
                            'anexos',
                            'asunto',
                            'adjunto',
                            'observaciones',
                        ];
}
