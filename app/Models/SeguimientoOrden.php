<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeguimientoOrden extends Model
{
    use HasFactory;
    protected $fillable = [
        'solicitud_id',
        'estado_id',
        'seccion_id',
        'accion_id',
        'mensaje',
        'observaciones',
        'adjunto',
    ];

    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class, 'solicitud_id');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoSolicitud::class, 'estado_id');
    }

    public function seccionempresa()
    {
        return $this->belongsTo(SeccionEmpresa::class, 'seccion_id');
    }

    public function accion()
    {
        return $this->belongsTo(AccionOrdene::class, 'accion_id');
    }
}
