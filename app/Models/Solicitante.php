<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitante extends Model
{
    use HasFactory;
    protected $fillable = [
        'tipo_documento',
        'tipo_usuario_id',
        'documento',
        'nombrecompleto',
        'email',
        'telefono',
        'nacimiento',
        'ciudad_id',
        'direccion',
    ];

    public function ciudad()
    {
        return $this->belongsTo(Ciudade::class);
    }
}
