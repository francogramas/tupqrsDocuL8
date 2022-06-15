<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class solicitudCopia extends Model
{
    use HasFactory;
    protected $fillable = [
        'solicitud_id',
        'seccion_id'
    ];

    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class, 'solicitud_id');
    }

    public function seccion()
    {
        return $this->belongsTo(SeccionEmpresa::class, 'seccion_id');
    }
}
