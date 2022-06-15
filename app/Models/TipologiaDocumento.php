<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipologiaDocumento extends Model
{
    use HasFactory;
    protected $fillable = [
        'subserie_id',
        'nombre',
        'So_Pa',
        'So_El',
        'So_Di',
        'diasTermino',
        'radicadoSalida',
        'radicadoEntrada',
        'pqrs_id',
    ];

    
    public function pqrs()
    {
        return $this->belongsTo(Pqr::class, 'pqrs_id');
    }

    public function subserie()
    {
        return $this->belongsTo(Subserie::class, 'subserie_id');
    } 
}
