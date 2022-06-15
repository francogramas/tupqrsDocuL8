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
    public $fechai, $fechaf, $solicitudes, $series, $secciones, $serie_id, $subseries, $subseries_id, $tipologias, $tipologias_id, $seccion_id, $empresa;

    public function mount()
    {
        $this->empresa=Auth::user()->empresa;         
        $this->fechai = Carbon::now()->format('Y-m-d');  
        $this->series = [];        
        $this->series_id = 0;
        $this->subseries = [];        
        $this->subseries_id = 0;
        $this->tipologias = [];        
        $this->tipologias_id = 0;
        $this->selFecha();              
    }

    public function render()
    {
        return view('livewire.informe-dia-component');
    }

    public function selFecha()
    {
        $seccion = Solicitud::select('seccion_id')
        ->whereBetween('solicituds.created_at', [$this->fechai.' 00:00:00', $this->fechai.' 23:59:59'])
        ->where('solicituds.empresa_id', $this->empresa->id)
        ->groupBy('seccion_id')
        ->get();      
        
        $this->secciones = SeccionEmpresa::whereIn('id',$seccion)->get();

        try {
            $this->seccion_id = $this->secciones->first()->id;                             
            $this->selSeccion();

        } catch (\Throwable $th) {            
            $this->series = [];        
            $this->series_id = 0;    
            $this->subseries = [];        
            $this->subseries_id = 0;        
        }
    }

    public function selSeccion()
    {
        try {            
            $serie = Solicitud::select('solicituds.serie_id')            
            ->whereBetween('solicituds.created_at', [$this->fechai.' 00:00:00', $this->fechai.' 23:59:59'])
            ->where('solicituds.seccion_id', $this->seccion_id)
            ->groupBy('solicituds.serie_id')
            ->get();  

            $this->series = Serie::whereIn('id',$serie)->get();        
            $this->series_id = $this->series->first()->id;
            $this->selSerie();
        } catch (\Throwable $th) {
            $this->series = [];        
            $this->series_id = 0;
            $this->subseries = [];        
            $this->subseries_id = 0;
            $this->tipologias = [];        
            $this->tipologias_id = 0;
        }
    }

    public function selSerie()
    {
        try {            
            $subserie = Solicitud::select('solicituds.subserie_id')            
            ->whereBetween('solicituds.created_at', [$this->fechai.' 00:00:00', $this->fechai.' 23:59:59'])
            ->where('solicituds.seccion_id', $this->seccion_id)
            ->where('solicituds.serie_id', $this->series_id)
            ->groupBy('solicituds.subserie_id')
            ->get();            
            $this->subseries = Subserie::whereIn('id',$subserie)->get();        
            $this->subseries_id = $this->subseries->first()->id;
            $this->selSubserie();

        } catch (\Throwable $th) {
            $this->subseries = [];        
            $this->subseries_id = 0;
            $this->tipologias = [];        
            $this->tipologias_id = 0;
        }
    }

    public function selSubserie()
    {
        try {            
            $tipologia = Solicitud::select('solicituds.tipologia_id')            
            ->whereBetween('solicituds.created_at', [$this->fechai.' 00:00:00', $this->fechai.' 23:59:59'])
            ->where('solicituds.seccion_id', $this->seccion_id)
            ->where('solicituds.serie_id', $this->series_id)
            ->where('solicituds.subserie_id', $this->subseries_id)
            ->groupBy('solicituds.tipologia_id')
            ->get();
            $this->tipologias = TipologiaDocumento::whereIn('id',$tipologia)->get();        
            $this->tipologias_id = $this->tipologias->first()->id;
            
        } catch (\Throwable $th) {
            $this->tipologias = [];        
            $this->tipologias_id = 0;
        }
    }
}
