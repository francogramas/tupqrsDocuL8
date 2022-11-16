<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expediente extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero',
        'user_id',
        'empresa_id',
        'seccion_id',
        'solicitudEntrada',
        'solicitudSalida',
        'finalizada',
    ];

    public function user()
    {
        return $this->belongsTo(user::class);
    }

    public function empresa()
    {
        return $this->belongsTo(empresa::class);
    }

    public function entrada()
    {
        return $this->belongsTo(Solicitud::class, 'solicitudEntrada');
    }

    public function salida()
    {
        return $this->belongsTo(Solicitud::class, 'solicitudSalida');
    }

    public function seccionempresa()
    {
        return $this->belongsTo(SeccionEmpresa::class, 'seccion_id');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleExpediente::class, 'expediente_id', 'id');
    }
}
