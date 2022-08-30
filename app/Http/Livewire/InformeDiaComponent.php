<?php

namespace App\Http\Livewire;

use App\Models\SeccionEmpresa;
use App\Models\Serie;
use App\Models\Subserie;
use App\Models\TipologiaDocumento;
use Livewire\Component;
use App\Models\Solicitud;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;


class InformeDiaComponent extends Component
{
    public $fechai, $fechaf, $solicitudes, $series, $secciones, $serie_id, $subseries, $subserie_id, $tipologias, $tipologia_id, $secciones_id, $empresa, $s;

    public function mount()
    {
        $this->empresa=Auth::user()->empresa;
        $this->fechai = Carbon::now()->format('Y-m-d');
        $this->fechaf = Carbon::now()->format('Y-m-d');
        $this->series = [];
        $this->subseries = [];
        $this->tipologias = [];
        $this->solicitudes = [];
        $this->selFecha();
    }

    public function render()
    {
        $this->consulta();
        return view('livewire.informe-dia-component');
    }

    public function selFecha()
    {
        $seccion = Solicitud::select('seccion_id')
        ->whereBetween('solicituds.created_at', [$this->fechai.' 00:00:00', $this->fechaf.' 23:59:59'])
        ->where('solicituds.empresa_id', $this->empresa->id)
        ->groupBy('seccion_id')
        ->get();
        $this->secciones = SeccionEmpresa::whereIn('id',$seccion)->get();
    }



    public function consulta()
    {
        $s = [];
        $s1 = [];
        $s2 = [];
        $s3 = [];

        if (!is_null($this->secciones_id)) {
            foreach ($this->secciones_id as $key => $value) {
                if ($value) {
                    $s[]=$key;
                }
            }

            $serie = Solicitud::select('solicituds.serie_id')
            ->whereBetween('solicituds.created_at', [$this->fechai.' 00:00:00', $this->fechaf.' 23:59:59'])
            ->whereIn('solicituds.seccion_id', $s)
            ->groupBy('solicituds.serie_id')
            ->get();

            $this->series = Serie::whereIn('id',$serie)->get();
            if (!is_null($this->serie_id)) {
                foreach ($this->serie_id as $key => $value) {
                    if ($value) {
                        $s1[]=$key;
                    }
                }

                $subserie = Solicitud::select('solicituds.subserie_id')
                    ->whereBetween('solicituds.created_at', [$this->fechai.' 00:00:00', $this->fechaf.' 23:59:59'])
                    ->whereIn('solicituds.seccion_id', $s)
                    ->whereIn('solicituds.serie_id', $s1)
                    ->groupBy('solicituds.subserie_id')
                    ->get();
                $this->subseries = Subserie::whereIn('id',$subserie)->get();

                if (!is_null($this->subserie_id)) {
                    foreach ($this->subserie_id as $key => $value) {
                        if ($value) {
                            $s2[]=$key;
                        }
                    }
                    $tipologia = Solicitud::select('solicituds.tipologia_id')
                        ->whereBetween('solicituds.created_at', [$this->fechai.' 00:00:00', $this->fechaf.' 23:59:59'])
                        ->whereIn('solicituds.seccion_id', $s)
                        ->whereIn('solicituds.serie_id', $s1)
                        ->whereIn('solicituds.subserie_id', $s2)
                        ->groupBy('solicituds.tipologia_id')
                        ->get();
                    $this->tipologias = TipologiaDocumento::whereIn('id',$tipologia)->get();
                    if (!is_null($this->tipologia_id)) {
                        foreach ($this->tipologia_id as $key => $value) {
                            if ($value) {
                                $s3[]=$key;
                            }
                        }
                    }
                }

            }

            if (count($s3)>0) {
                $this->solicitudes = Solicitud::whereBetween('created_at', [$this->fechai.' 00:00:00', $this->fechaf.' 23:59:59'])
                    ->whereIn('seccion_id', $s)
                    ->whereIn('serie_id', $s1)
                    ->whereIn('subserie_id', $s2)
                    ->whereIn('tipologia_id', $s3)
                    ->get();
            }
            elseif(count($s2)>0) {
                $this->solicitudes = Solicitud::whereBetween('created_at', [$this->fechai.' 00:00:00', $this->fechaf.' 23:59:59'])
                    ->whereIn('seccion_id', $s)
                    ->whereIn('serie_id', $s1)
                    ->whereIn('subserie_id', $s2)
                    ->get();
            }
            elseif(count($s1)>0) {
                $this->solicitudes = Solicitud::whereBetween('created_at', [$this->fechai.' 00:00:00', $this->fechaf.' 23:59:59'])
                    ->whereIn('seccion_id', $s)
                    ->whereIn('serie_id', $s1)
                    ->get();
            }
            elseif(count($s)>0) {
                $this->solicitudes = Solicitud::whereBetween('created_at', [$this->fechai.' 00:00:00', $this->fechaf.' 23:59:59'])
                    ->whereIn('seccion_id', $s)
                    ->get();
            }
        }
    }
}
