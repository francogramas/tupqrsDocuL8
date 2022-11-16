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
                            'tipologia_id',
                            'medio_id',
                            'folios',
                            'anexos',
                            'asunto',
                            'adjunto',
                            'observaciones',
                        ];


    public function expediente()
    {
        return $this->belongsTo(Expediente::class);
    }

    public function seccionempresa()
    {
        return $this->belongsTo(SeccionEmpresa::class, 'seccion_id');
    }

    public function empresa()
    {
        return $this->belongsTo(empresa::class, 'empresa_id');
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
