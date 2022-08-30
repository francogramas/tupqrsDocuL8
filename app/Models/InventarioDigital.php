<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventarioDigital extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'remitente_id',
        'seccion_id',
        'empresa_id',
        'serie_id',
        'tipologia_id',
        'fecha',
        'radicado',
        'destinatario',
        'estante',
        'caja',
        'folios',
        'anexos',
        'descripcion',
        'observaciones',
        'confidencial',
        'documento',
    ];


    public function remitente()
    {
        return $this->belongsTo(RemitenteDigital::class, 'remitente_id');
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
