<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    use HasFactory;
    protected $fillable = [
        'solicitante_id',
        'estado_id',
        'seccion_id',
        'empresa_id',
        'serie_id',
        'subserie_id',
        'medio_id',
        'user_id',
        'radicado',
        'consecutivo',
        'diasTermino',
        'folios',
        'anexos',
        'destinatario',
        'asunto',
        'fecha',
        'confidencial',
        'respuesta_email',
        'tipologia_id',
        'entrada',
        'revision',
        'aprobada',
        'cancelada'
    ];

    public function copia()
    {
        return $this->hasOne(solicitudCopia::class, 'solicitud_id', 'id');
    }

    public function solicitante()
    {
        return $this->belongsTo(Solicitante::class, 'solicitante_id');
    }

    public function seccionempresa()
    {
        return $this->belongsTo(SeccionEmpresa::class, 'seccion_id');
    }

    public function empresa()
    {
        return $this->belongsTo(empresa::class, 'empresa_id');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoSolicitud::class, 'estado_id');
    }

    public function seguimiento()
    {
        return $this->hasMany(SeguimientoOrden::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function medio()
    {
        return $this->belongsTo(MedioRecepcion::class, 'medio_id');
    }
    public function tipologia()
    {
        return $this->belongsTo(TipologiaDocumento::class, 'tipologia_id');
    }

    public function serie()
    {
        return $this->belongsTo(Serie::class, 'serie_id');
    }

    public function subserie()
    {
        return $this->belongsTo(Subserie::class, 'subserie_id');
    }
}
