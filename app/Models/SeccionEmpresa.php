<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeccionEmpresa extends Model
{
    use HasFactory;
    protected $fillable = [
        'codigo',
        'nombre',
        'publica',
        'empresa_id',
        'estado_id',
        'lider',
        'firma',
    ];

    public function userSeccion()
    {
        return $this->hasOne(SeccionUser::class, 'seccion_id');
    }

    public function empresa()
    {
        return $this->belongsTo(empresa::class, 'empresa_id');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoSeccion::class, 'estado_id');
    }
}
