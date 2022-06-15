<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TipoSolicitud;
use App\Models\SeccionEmpresa;
use App\Models\Solicitud;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Asantibanez\LivewireCharts\Facades\LivewireCharts;
// TODO: Calcular índices de oportunidad

class GerenteComponent extends Component
{
    public $tipos, $fechai, $fechaf, $seccion_id, $seccion, $secciones, $solicitudes, $total, $empresa;
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
    }

    public function mount()
    {        
        
        $this->fechaf = Carbon::now()->lastOfMonth()->format('Y-m-d');        
        $this->fechai = Carbon::now()->firstOfMonth()->subMonths(5)->format('Y-m-d');   
        $t = Solicitud::select('tipo_id')->where('estado_id','<>', 4)
        ->where('empresa_id', Auth::user()->seccion->first()->seccionempresa->empresa_id)
        ->whereBetween('created_at',[$this->fechai, $this->fechaf])
        ->groupBy('tipo_id')
        ->get();
        
        $this->tipos = TipoSolicitud::whereIn('id',$t)->get();

        try {
            $this->seccion_id = Auth::user()->empresa->secciones[0]->id;               
        } catch (\Throwable $th) {
            $this->seccion_id = 0;
        }        
    }

    public function render()
    {        
        if ($this->seccion_id == 0) {
            return view('livewire.gerente-component')
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
                ->setTitle('PQRSF Mensual');            
            
            $this->total = 0;

            $pieChartModel = LivewireCharts::pieChartModel()
            ->setTitle('Total de solicitudes por Seccion/Departamento')
            ->setAnimated(true)
            ->withOnSliceClickEvent('onSliceClick')
            ->withLegend()
            ->legendPositionBottom()
            ->legendHorizontallyAlignedCenter()
            ->setDataLabelsEnabled(true);

            $i=0;
            foreach (Auth::user()->empresa->secciones as $seccioni) {            
                $t = Solicitud::whereBetween('created_at', [$this->fechai, $this->fechaf])            
                ->where('seccion_id', $seccioni->id)
                ->count();            

                $this->total += $t;
                $pieChartModel->addSlice($seccioni->nombre, $t, $this->colors[$i], $seccioni->id);
                $i +=1;
            }

            $i=0;
            $totalTipo = [];
            $pieChartModel1 = LivewireCharts::pieChartModel()
            ->setTitle('Total de solicitudes de '. SeccionEmpresa::find($this->seccion_id)->nombre .' por tipo de solicitud ')
            ->setAnimated(true)        
            ->withLegend()
            ->legendPositionBottom()
            ->legendHorizontallyAlignedCenter()
            ->setDataLabelsEnabled(true);

            foreach ($this->tipos as $tipo) {
                $t = Solicitud::whereBetween('created_at', [$this->fechai, $this->fechaf])            
                ->where('seccion_id', $this->seccion_id)
                ->where('tipo_id', $tipo->id)
                ->count();            
                
                $pieChartModel1->addSlice($tipo->nombre, $t, $this->colors[$i], $seccioni->id);
                $i +=1;
            }
            
            foreach ($solicitesMesTotales as $fechas) {
                $mes = $fechas->new_date;
                $m[] = $fechas->new_date;

                foreach ($this->tipos as $tipo) {
                    $t = Solicitud::where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"),$fechas->new_date)            
                    ->where('seccion_id', $this->seccion_id)
                    ->where('tipo_id', $tipo->id)
                    ->count();                                
                    $columnChartModel->addSeriesColumn($tipo->nombre, $mes, $t);                    
                }                      
            }

            $columnChartModel->multiColumn()
            ->withLegend()
            ->setOpacity(.75)
            ->setColumnWidth(15)
            ->setHorizontal(false)
            ->setAnimated(true)
            ->stacked()
            ->withGrid()
            ->setXAxisCategories($m);
            
            return view('livewire.gerente-component')
            ->with('pieChartModel', $pieChartModel)
            ->with('pieChartModel1', $pieChartModel1)
            ->with('columnChartModel', $columnChartModel);
        }                
    }
    
    public function detalle($id)
    {
        $this->solicitudes = Solicitud::whereBetween('created_at', [$this->fechai, $this->fechaf])
        ->where('seccion_id', $this->seccion_id)
        ->orderBy('created_at')
        ->get();     
    }
}
