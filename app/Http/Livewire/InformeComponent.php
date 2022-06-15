<?php

namespace App\Http\Livewire;

use App\Models\SeccionEmpresa;
use App\Models\Serie;
use Livewire\Component;
use App\Models\Solicitud;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;


class InformeComponent extends Component
{
    public $fechai, $fechaf, $solicitudes, $series, $secciones, $serie_id, $seccion_id, $empresa;
    public $colors = ['#54478C', '#2C699A', '#048BA8', '#0DB39E', '#16DB93', '#83E377', '#B9E769', '#EFEA5A', '#F1C453', '#F29E4C','#EA8C55', '#C75146', '#AD2E24', '#81171B', '#540804', 
    '#54478C', '#2C699A', '#048BA8', '#0DB39E', '#16DB93', '#83E377', '#B9E769', '#EFEA5A', '#F1C453', '#F29E4C','#EA8C55', '#C75146', '#AD2E24', '#81171B', '#540804',
    '#54478C', '#2C699A', '#048BA8', '#0DB39E', '#16DB93', '#83E377', '#B9E769', '#EFEA5A', '#F1C453', '#F29E4C','#EA8C55', '#C75146', '#AD2E24', '#81171B', '#540804',
    '#54478C', '#2C699A', '#048BA8', '#0DB39E', '#16DB93', '#83E377', '#B9E769', '#EFEA5A', '#F1C453', '#F29E4C','#EA8C55', '#C75146', '#AD2E24', '#81171B', '#540804',
    '#54478C', '#2C699A', '#048BA8', '#0DB39E', '#16DB93', '#83E377', '#B9E769', '#EFEA5A', '#F1C453', '#F29E4C','#EA8C55', '#C75146', '#AD2E24', '#81171B', '#540804',
    '#54478C', '#2C699A', '#048BA8', '#0DB39E', '#16DB93', '#83E377', '#B9E769', '#EFEA5A', '#F1C453', '#F29E4C','#EA8C55', '#C75146', '#AD2E24', '#81171B', '#540804'];

    protected $listeners = [
        'onSliceClick' => 'handleOnSliceClick'
    ];
    
    public function handleOnSliceClick($slice)
    {
        $this->seccion_id = $slice['extras'];
        $serie = Solicitud::select('subseries.serie_id')
        ->join('subseries', 'solicituds.subserie_id', 'subseries.id')
        ->whereBetween('solicituds.created_at', [$this->fechai, $this->fechaf])
        ->where('solicituds.seccion_id', $this->seccion_id)
        ->groupBy('subseries.serie_id')
        ->get();
        $this->series = Serie::whereIn('id',$serie)->get();        
        $this->series_id = $this->series->first()->id;
        
    }

    public function selSeccion()
    {
        if ($this->seccion_id>0) {
            $serie = Solicitud::select('subseries.serie_id')
            ->join('subseries', 'solicituds.subserie_id', 'subseries.id')
            ->whereBetween('solicituds.created_at', [$this->fechai, $this->fechaf])
            ->where('solicituds.seccion_id', $this->seccion_id)
            ->groupBy('subseries.serie_id')
            ->get();

            $this->series = Serie::whereIn('id',$serie)->get();        
            $this->series_id = $this->series->first()->id;
        }        

    }

    public function mount()
    {
        $this->empresa=Auth::user()->empresa;
        $this->fechaf = Carbon::now()->lastOfMonth()->format('Y-m-d');        
        $this->fechai = Carbon::now()->firstOfMonth()->subMonths(5)->format('Y-m-d');  

        
        $seccion = Solicitud::select('seccion_id')
        ->whereBetween('solicituds.created_at', [$this->fechai, $this->fechaf])
        ->where('solicituds.empresa_id', $this->empresa->id)
        ->groupBy('seccion_id')
        ->get();

        $this->secciones = SeccionEmpresa::whereIn('id',$seccion)->get();

        try {
            $this->seccion_id = $this->secciones->first()->id;        
            
            $serie = Solicitud::select('subseries.serie_id')
            ->join('subseries', 'solicituds.subserie_id', 'subseries.id')
            ->whereBetween('solicituds.created_at', [$this->fechai, $this->fechaf])
            ->where('solicituds.seccion_id', $this->seccion_id)
            ->groupBy('subseries.serie_id')
            ->get();

            $this->series = Serie::whereIn('id',$serie)->get();        
            $this->series_id = $this->series->first()->id;

        } catch (\Throwable $th) {
            $this->series = null;        
            $this->series_id = 0;
        }
        

    }

    public function render()
    {
        if ($this->seccion_id == 0) {
            return view('livewire.informe-component')
            ->with('pieChartModel', [])
            ->with('pieChartModel1', [])
            ->with('columnChartModel', []);
            
        }
        else{
            $solicitesMesTotales = Solicitud::select(DB::raw('count(solicituds.id) as `data`'),
            DB::raw("DATE_FORMAT(solicituds.created_at, '%Y-%m') new_date"))
            ->join('seccion_empresas', 'solicituds.seccion_id', 'seccion_empresas.id')
            ->where('seccion_empresas.empresa_id', Auth::user()->empresa->id)
            ->whereBetween('solicituds.created_at',[$this->fechai, $this->fechaf])
            ->groupBy('new_date')->orderBy('new_date')
            ->get();
            $m = [];        
            
            $this->seccion = SeccionEmpresa::find($this->seccion_id);
            $columnChartModel =  LivewireCharts::multiColumnChartModel()
                ->setTitle('PQRS Mensual');            
            
            $this->total = 0;

            $pieChartModel = LivewireCharts::pieChartModel()
            ->setTitle('Total de solicitudes por Seccion/Departamento')
            ->setAnimated(true)
            ->withOnSliceClickEvent('onSliceClick')
            ->withLegend()
            ->legendPositionRight()
            ->legendHorizontallyAlignedCenter()
            ->setDataLabelsEnabled(true);

            $i=0;
            foreach ($this->secciones as $seccioni) {            
                $t = Solicitud::whereBetween('created_at', [$this->fechai, $this->fechaf])            
                ->where('seccion_id', $seccioni->id)
                ->count();            

                $this->total += $t;
                $pieChartModel->addSlice($seccioni->nombre, $t, $this->colors[$i], $seccioni->id);
                $i +=1;
            }

            $i=0;
            $totalSerie = [];
            $pieChartModel1 = LivewireCharts::pieChartModel()
            ->setTitle('Total de solicitudes de '. SeccionEmpresa::find($this->seccion_id)->nombre .' por series')
            ->setAnimated(true)        
            ->withLegend()
            ->legendPositionRight()
            ->legendHorizontallyAlignedCenter()
            ->setDataLabelsEnabled(true);

            foreach ($this->series as $serie) {
                $t = Solicitud::whereBetween('created_at', [$this->fechai, $this->fechaf])            
                ->where('seccion_id', $this->seccion_id)
                ->where('serie_id', $serie->id)
                ->count();            
            
                $pieChartModel1->addSlice($serie->nombre, $t, $this->colors[$i], $seccioni->id);
                $i +=1;
            }

            foreach ($solicitesMesTotales as $fechas) {
                $mes = $fechas->new_date;
                $m[] = $fechas->new_date;

                foreach ($this->series as $serie) {
                    $t = Solicitud::where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"),$fechas->new_date)            
                    ->where('seccion_id', $this->seccion_id)
                    ->where('serie_id', $serie->id)
                    ->count();                                
                    $columnChartModel->addSeriesColumn($serie->nombre, $mes, $t);                    
                }                      
            }

            $columnChartModel->multiColumn()
            ->withLegend()            
            ->setOpacity(.75)
            ->setColumnWidth(15)
            ->setHorizontal(false)
            ->setAnimated(true)
            ->legendPositionRight()
            ->stacked()
            ->withGrid()
            ->setXAxisCategories($m);

            return view('livewire.informe-component')
            ->with('pieChartModel', $pieChartModel)
            ->with('pieChartModel1', $pieChartModel1)
            ->with('columnChartModel', $columnChartModel);
        }
        
    }
}
