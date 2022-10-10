<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Subserie extends Model
{
    use HasFactory;
    protected $fillable = [
        'serie_id',
        'seccion_id',
        'codigo',
        'nombre',
        'Re_AG',
        'Re_AC',
        'DF_CT',
        'DF_E',
        'DF_MD',
        'DF_S',
        'ACC_P',
        'ACC_Pr',
        'procedimiento',
     ];

    public function seccionempresa()
    {
        return $this->belongsTo(SeccionEmpresa::class, 'seccion_id');
    }

    public function serie()
    {
        return $this->belongsTo(Serie::class, 'serie_id');
    }

    static function seccionE($empresa_id)
    {
        $s = Subserie::select('seccion_id')
            ->join('seccion_empresas','subseries.seccion_id','seccion_empresas.id')
            ->where('seccion_empresas.empresa_id', $empresa_id)
            ->groupBy('subseries.seccion_id')
            ->get();

        $s1 = SeccionEmpresa::whereIn('id', $s)->get();
        return $s1;
    }

    static function serieSeccion($seccion_id)
    {
        $s = Subserie::select('serie_id')
            ->join('series','subseries.serie_id','series.id')
            ->where('subseries.seccion_id', $seccion_id)
            ->groupBy('subseries.serie_id')
            ->get();

        $s1 = Serie::whereIn('id', $s)->get();
        return $s1;
    }

}
