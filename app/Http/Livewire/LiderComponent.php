<?php

namespace App\Http\Livewire;
use App\Models\Solicitud;
use App\Models\AccionOrdene;
use App\Models\SeccionEmpresa;
use App\Models\Serie;
use App\Models\Subserie;
use App\Models\TipologiaDocumento;
use App\Models\SeguimientoOrden;
use App\Models\SeccionUser;

use App\Mail\respuestaSolicitudMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use App\Models\EmpresaUser;
use App\Mail\ColaSolicitudMail;

use App\Models\ColaSolicitud;

class LiderComponent extends Component
{
    use WithFileUploads;
    public $tiposolicitud, $solicitud, $solicitudi, $respuesta, $adjunto, $acciones, $accion_id, $empresa_id,
    $observaciones, $seccion_empresa, $seccion_empresaTodos, $seccion_id, $secciones_u, $secciones_u_id, $series, $serie_id, $subseries, $subserie_id,
    $tipologias, $tipologia_id, $max_consecutivo, $pendientes, $resuletas;


    public function mount()
    {
        $this->empresa_id = Auth::user()->empresaUser->empresa_id;
        $this->acciones=AccionOrdene::where('id','>',2)->orderBy('id','desc')->get();
        $this->accion_id = $this->acciones->first()->id;

        $secciones_id = SeccionUser::select('seccion_id')->where('empresa_id',$this->empresa_id)->where('user_id', Auth::user()->id)->groupBy('seccion_id')->get();
        $seccion_id = Solicitud::select('seccion_id')->where('estado_id','<>',4)->whereIn('seccion_id', $secciones_id)->groupBy('seccion_id')->get();

        //Verificación de que existe solicitudes en las secciones, de lo contrario se muestra un mensaje diciendo que no hay solicitudes por responder

        if($seccion_id->count()>0){
            $this->seccion_empresaTodos = SeccionEmpresa::whereIn('id', $seccion_id)->get();

            $this->secciones_u_id = $this->seccion_empresaTodos->first()->id;
            try {
                $this->seccion_id = $this->seccion_empresaTodos->first()->id;
            } catch (\Throwable $th) {
                $this->seccion_id = null;
            }

            $this->consultarSeries();
            $this->subseries = Subserie::where('serie_id', $this->serie_id)->get();
            if (!is_null($this->subseries)) {
                $this->subserie_id = $this->subseries->first()->id;
            }
            $this->tipologias = TipologiaDocumento::where('subserie_id', $this->subserie_id)->get();
            if (!is_null($this->tipologias)){
                $this->tipologia_id = $this->tipologias->first()->id;
            }
            $this->solicitudes($this->serie_id);
            $this->finalizadas();
        }
    }

    public function render()
    {
        return view('livewire.lider-component');

    }

    public function serieChange()
    {
        $this->subseries = Subserie::where('serie_id', $this->serie_id)
        ->where('seccion_id', $this->secciones_u_id)
        ->get();

        if ($this->subseries->count()>0) {
            $this->subserie_id = $this->subseries->first()->id;
        }
        else{
            $this->subserie_id = 0;
        }

        $this->subserieChange();
    }

    public function subserieChange()
    {
        $this->tipologias= TipologiaDocumento::where('subserie_id', $this->subserie_id)->get();
        if ($this->tipologias->count()>0) {
            $this->tipologia_id = $this->tipologias->first()->id;
        }
        else{
            $this->tipologia_id = null;
        }
    }


    public function consultarSeries()
    {

        $sub = Solicitud::select('subseries.serie_id')
            ->join('subseries','solicituds.subserie_id','subseries.id')
            ->where('solicituds.seccion_id', $this->secciones_u_id)
            ->where('estado_id','<>', 4)
            ->groupBy('subseries.serie_id')
            ->get();

        $this->series = Serie::whereIn('id', $sub)->get();
        $this->serie_id = $this->series->first()->id;
        $this->solicitudes($this->serie_id);

    }

    public function solicitudes($serie_id)
    {
        $this->solicitud = Solicitud::select('solicituds.*')
        ->join('subseries', 'solicituds.subserie_id', 'subseries.id')
        ->where('estado_id','<>', 4)
        ->where('revision', 0)
        ->where('solicituds.seccion_id', $this->secciones_u_id)
        ->where('subseries.serie_id', $serie_id)
        ->where('entrada', true)
        ->orderBy('estado_id', 'desc')
        ->orderBy('created_at', 'asc')
        ->get();

        $secc = SeccionUser::select('seccion_id')->where('user_id', Auth::user()->id)->groupBy('seccion_id')->get();
        $this->pendientes = ColaSolicitud::where('finalizada',false)
                            ->whereIn('seccion_id', $secc)
                            ->take(5)
                            ->get();

        //dd($this->pendientes);

        $this->solicitudi = $this->solicitud->first();
        $this->respuesta=null;
        $this->adjunto = null;
        $this->serie_id = $serie_id;
        $secciones_id = SeccionUser::select('id')->where('user_id', Auth::user()->id)->get();
        $seccion_id = Solicitud::select('seccion_id')->where('estado_id','<>',4)->whereIn('seccion_id', $secciones_id)->groupBy('seccion_id')->get();
        $this->seccion_empresa = SeccionEmpresa::whereIn('id', $seccion_id)->get();

    }

    public function verSolicitud($id)
    {
        $this->solicitudi = Solicitud::find($id);
    }

    public function responder()
    {
        $datavalid = $this->validate([
            'respuesta' => 'required|min:10',
            'adjunto' => 'max:24576', // Pdf máximo 24MB
        ]);

        try {
            $dataValid['adjunto'] = $this->adjunto->store('pdf','public');
        } catch (\Throwable $th) {
            $dataValid['adjunto']='';
        }

        if ($this->accion_id >= 6 and $this->accion_id <=8) {
            $this->solicitudi->revision = true;

            // Se debe definir la forma de radiciaciones internas
            $solicitudBD = Solicitud::create([
                'solicitante_id'=>$this->solicitudi->solicitante_id,
                'estado_id'=> $this->solicitudi->estado_id,
                'seccion_id'=>$this->solicitudi->seccion_id,
                'empresa_id'=>$this->solicitudi->empresa_id,
                'serie_id'=>$this->solicitudi->serie_id,
                'subserie_id'=>$this->solicitudi->subserie_id,
                'medio_id'=>$this->solicitudi->medio_id,
                'user_id' => Auth::user()->id,
                'radicado'=> $this->calcularRadicado(),
                'consecutivo'=> $this->max_consecutivo,
                'diasTermino'=> $this->solicitudi->diasTermino,
                'folios'=>$this->solicitudi->folios,
                'anexos'=>$this->solicitudi->anexos,
                'destinatario'=>$this->solicitudi->solicitante->nombrecompleto,
                'asunto'=>'Rta: '.$this->solicitudi->asunto,
                'fecha'=>now(),
                'confidencial'=>$this->solicitudi->confidencial,
                'respuesta_email'=>$this->solicitudi->respuesta_email,
                'tipologia_id'=>$this->solicitudi->tipologia_id,
                'entrada'=>false
            ]);

            SeguimientoOrden::create([
                'radicado' => null, // El seguimiento se hace por cada solicitud, debido a esto no es necesrio que tenga radicado
                'solicitud_id' => $solicitudBD->id,
                'user_id'=>Auth::user()->id,
                'estado_id' => $solicitudBD->estado_id,
                'seccion_id' => $solicitudBD->seccion_id,
                'accion_id' => $this->accion_id,
                'mensaje' => $this->respuesta,
                'observaciones' => $this->observaciones,
                'adjunto' => $dataValid['adjunto'],
            ]);


            ColaSolicitud::firstOrCreate([
                'user_id'=>Auth::user()->id,
                'solicitudEntrada'=>$this->solicitudi->id,
                'solicitudSalida'=>$solicitudBD->id,
                'seccion_id'=>$this->solicitudi->seccion_id,
                'finalizada'=>false,
                ]
            );


            $m = Mail::to($this->solicitudi->seccionempresa->emailjefe)
            ->cc('francogramas@gmail.com')
            ->send(new ColaSolicitudMail($solicitudBD));
            $this->solicitudi->save();

        }
        elseif($this->accion_id == 3) {
            $this->solicitudi->seccion_id = $this->seccion_id;
            $this->solicitudi->save();

            SeguimientoOrden::create([
                'radicado' => null, // El seguimiento se hace por cada solicitud, debido a esto no es necesrio que tenga radicado
                'solicitud_id' => $this->solicitudi->id,
                'user_id'=>Auth::user()->id,
                'estado_id' => $this->solicitudi->estado_id,
                'seccion_id' => $this->solicitudi->seccion_id,
                'accion_id' => $this->accion_id,
                'mensaje' => $this->respuesta,
                'observaciones' => $this->observaciones,
                'adjunto' => $dataValid['adjunto'],
            ]);

        }

        try {
            $this->consultarSeries();
            $this->solicitudes($this->serie_id);
        } catch (\Throwable $th) {
            $this->seccion_empresa = null;
        }

    }

    public function descargar($id)
    {
        $sol = SeguimientoOrden::find($id);
        dd(Storage::url('public/'.$sol->adjunto));
    }

    public function calcularRadicado($trd=false)
    {
        $date = Carbon::createFromDate(now()->format('Y-m-d'));
        $startOfYear = $date->copy()->startOfYear();
        $endOfYear   = $date->copy()->endOfYear();
        $c=null;
        $pref = 'S';

        $this->max_consecutivo = Solicitud::where('empresa_id',$this->empresa_id)
                            ->whereBetween('created_at',[$startOfYear, $endOfYear])
                            ->max('consecutivo');
        if($this->max_consecutivo>0){
            $this->max_consecutivo +=1;
        }
        else{
            $this->max_consecutivo =1;
        }

        if ($trd) {
            $t = TipologiaDocumento::find($this->tipologia_id);
            $c= $t->subserie->seccionempresa->codigo.'-'.$t->subserie->serie->codigo.'-'.$t->subserie->codigo.'-';
        }
        if($this->accion_id==3){$pref='I';}
        $radicado = $pref.'-'.now()->format('y').'-'.$c.$this->max_consecutivo;
        return($radicado);
    }

    public function finalizadas()
    {
        $secc = SeccionUser::select('seccion_id')->where('user_id', Auth::user()->id)->groupBy('seccion_id')->get();
        $this->resueltas = ColaSolicitud::where('finalizada',true)->whereIn('seccion_id', $secc)->orderBy('updated_at', 'desc')->take(20)->get();
    }
}
