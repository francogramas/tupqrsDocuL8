<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Subserie;
use App\Models\TipologiaDocumento;
use App\Models\empresa;
use App\Models\Tipodocumento;
use App\Models\SeccionEmpresa;
use App\Models\MedioRecepcion;
use App\Models\Expediente;
use App\Models\DetalleExpediente;
use App\Models\User;
use App\Models\Solicitud;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;



class ExpedienteComponent extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $seccion_empresa, $series, $serie_id, $subserie, $subserie_id, $seccion_id, $empresa_id,
    $tipologia, $tipologia_id, $medio_recepcion, $medio_id, $diasTermino, $fecha, $destinatario, $folios,
    $anexos, $asunto, $confidencial, $respuesta_email, $copia_radicado, $seccionCopia, $seccionCopia_id,
    $descripcion, $adjunto, $tipoProceso, $filtro, $etapa, $expediente, $expediente_id, $boolAgregar,
    $observaciones, $modalFormVisible1, $param;

    public function mount()
    {
        $this->empresa_id = Auth::user()->empresaUser->empresa_id;
        $this->empresa = empresa::find($this->empresa_id);
        $this->tipodocumento = Tipodocumento::all();
        $this->tipo_documento = Tipodocumento::first()->id;
        $this->tipoProceso = 1;
        $this->seccion_empresa = Subserie::seccionE($this->empresa_id);
        $this->seccion_id = $this->seccion_empresa->first()->id;
        $this->seccion_empresa = $this->seccion_empresa->pluck('nombre','id');
        $this->seccionCopia = SeccionEmpresa::where('empresa_id', $this->empresa_id)->get();
        $this->seccionCopia_id = SeccionEmpresa::where('empresa_id', $this->empresa_id)->first()->id;
        $this->buscarSerie();
        $this->buscarSubSerie();
        $this->medio_recepcion = MedioRecepcion::all();
        $this->medio_id = MedioRecepcion::first()->id;
        $this->solicitudi = 0;
        $this->confidencial = false;
        $this->respuesta_email = false;
        $this->copia_radicado = false;
        $this->folios = 1;
        $this->anexos = 0;
        $this->filtro = 0;
        $this->etapa = 0;
        try {
            $this->expediente_id = Expediente::where('empresa_id',$this->empresa_id)->orderBy('updated_at','desc')->first()->id;
            $this->seleccionar($this->expediente_id);
        } catch (\Throwable $th) {
            $this->expediente_id = 0;
        }
    }

    public function render()
    {


        if(Str::length($this->param)>2){
            $char = [' ',',','.',';','"','?','¿','!','¡','&','$','@','#','%',')','(','/','=','+','-','*','/','_',':','>','<','{','}','[',']',"'"];
            $p = str_replace($char,'',$this->param);

            $expedientes = Expediente::select('expedientes.*')
            ->whereRaw("(replace(solicitantes.nombrecompleto,' ','') REGEXP ?)
            or (replace(concat_ws('', solicitantes.documento),' ','') REGEXP ?)
            or (replace(concat_ws('', solicituds.radicado),' ','') REGEXP ?)
            or (replace(concat_ws('', solicituds.asunto),' ','') REGEXP ?)
            and (solicituds.empresa_id like ?)",
            [$p, $p, $this->param, $p, $this->empresa_id])
            ->join('solicituds', 'expedientes.solicitudEntrada', 'solicituds.id')
            ->join('solicitantes','solicituds.solicitante_id','solicitantes.id')
            ->orderBy('updated_at','desc')->paginate(20);

        }
        else{
            $expedientes = Expediente::where('empresa_id',$this->empresa_id)->orderBy('updated_at','desc')->paginate(20);
        };

        return view('livewire.expediente-component', ['expedientes'=> $expedientes]);
    }

    public function buscarSerie()
    {
        $this->series = Subserie::serieSeccion($this->seccion_id);
        $this->serie_id = $this->series->first()->id;
        $this->series = $this->series->pluck('nombre', 'id');

        $seccion_empresa = SeccionEmpresa::find($this->seccion_id);
        $this->destinatario = $seccion_empresa->lider;
        $this->buscarSubSerie();
    }

    public function buscarSubSerie()
    {

        $this->subserie = Subserie::where('serie_id', $this->serie_id)->where('seccion_id', $this->seccion_id)->orderBy('nombre')->get();

        $this->subserie_id = $this->subserie->first()->id;
        $this->buscarTipologia();

    }

    public function buscarTipologia()
    {
        try {
            $this->tipologia = TipologiaDocumento::where('subserie_id', $this->subserie_id)->orderBy('nombre')->get();
            $this->tipologia_id = $this->tipologia->first()->id;
        } catch (\Throwable $th) {

            $this->tipologia = TipologiaDocumento::create([
                'subserie_id'=>$this->subserie_id,
                'nombre'=>'No Aplica',
                'So_Pa'=>false,
                'So_El'=>false,
                'So_Di'=>false,
                'diasTermino'=>0,
                'radicadoSalida'=>false,
                'radicadoEntrada'=>false,
                'pqrs_id'=>1,
            ]);

            $this->tipologia_id = $this->tipologia->first()->id;
        }
        $this->obtenerDiasTermino();
    }

    public function obtenerDiasTermino()
    {
        $this->diasTermino = TipologiaDocumento::find($this->tipologia_id)->pqrs->diastermino;
    }

    public function finalizarRadicado()
    {
        $this->nombrecompleto = null;
        $this->telefono = null;
        $this->email = null;
        $this->direccion = null;
        $this->documento = null;
        $this->solicitante = null;
        $this->solicitudi = 0;
        $this->etapa = 0;
        $this->asunto = null;
        $this->destinatario = null;
        $this->etapa = 0;
        $this->filtrar(0);
        session()->flash('message', 'El expdiente fue actualizado!!');
    }

    public function seleccionar($id)
    {
        $this->expediente_id = $id;
        $this->expediente = Expediente::find($this->expediente_id);
        $this->Agregar(false);

    }

    public function Agregar($agregar)
    {
        $this->boolAgregar=$agregar;

    }

    public function radicar()
    {
        $s = SeccionEmpresa::find($this->seccion_id);
        $cc=[];



        if (!is_null($s->emailjefe)) {
            $cc[]=$s->emailjefe;
        }

        if($this->copia_radicado and $this->usercopias){
            foreach ($this->usercopias as $co => $value) {
                if($value){
                    $u = User::find($co);
                        $cc[]=$u->email;
                    }
                }
            }

        $cc = array_unique($cc);
        //dd($cc);


        $this->validate([
            'asunto'=>'required|min:5',
            'diasTermino'=>'required|numeric',
            'adjunto' => 'required|max:24576', // Pdf máximo 24MB
        ]);

        try {
            $dataValid['adjunto'] = $this->adjunto->store('pdf','public');
            Storage::disk('public')->path($dataValid['adjunto']);

        } catch (\Throwable $th) {
            $dataValid['adjunto']='';
        }

        DetalleExpediente::create([
            'user_id'=>Auth::user()->id,
            'expediente_id'=>$this->expediente_id,
            'seccion_id'=>$this->seccion_id,
            'empresa_id'=>$this->empresa_id,
            'serie_id'=>$this->serie_id,
            'subserie_id'=>$this->subserie_id,
            'tipologia_id'=>$this->tipologia_id,
            'medio_id'=>$this->medio_id,
            'folios'=>$this->folios,
            'anexos'=>$this->anexos,
            'asunto'=>$this->asunto,
            'adjunto'=>$dataValid['adjunto'],
            'observaciones'=>$this->observaciones,
        ]);

        $this->asunto=null;
        $this->adjunto=null;
        $this->Agregar(false);
        $this->expediente = Expediente::find($this->expediente_id);
    }

    public function boolCerrar($cerrar)
    {
        $this->modalFormVisible1 = $cerrar;
    }

    public function cerrarExpediente()
    {
        $this->expediente->finalizada = true;
        $this->expediente->save();
    }

}
