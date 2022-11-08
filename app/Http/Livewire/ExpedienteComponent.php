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

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\WithPagination;


class ExpedienteComponent extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $seccion_empresa, $series, $serie_id, $subserie, $subserie_id, $seccion_id, $empresa_id,
    $tipologia, $tipologia_id, $medio_recepcion, $medio_id, $diasTermino, $fecha, $destinatario, $folios,
    $anexos, $asunto, $confidencial, $respuesta_email, $copia_radicado, $seccionCopia, $seccionCopia_id,
    $descripcion, $adjunto, $tipoProceso, $filtro, $etapa, $expediente_id;

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
        $this->fecha = now()->format('Y-m-d');
        $this->solicitudi = 0;
        $this->confidencial = false;
        $this->respuesta_email = false;
        $this->copia_radicado = false;
        $this->folios = 1;
        $this->anexos = 0;
        $this->filtro = 0;
        $this->etapa = 0;

    }

    public function render()
    {
        $expedientes = Expediente::paginate(20);

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
}
