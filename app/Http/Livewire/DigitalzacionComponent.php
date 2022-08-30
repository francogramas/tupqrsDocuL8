<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Tipodocumento;
use App\Models\TipoUsuario;
use App\Models\Subserie;
use App\Models\SeccionUser;
use App\Models\MedioRecepcion;
use App\Models\TipologiaDocumento;
use App\Models\RemitenteDigital;
use App\Models\InventarioDigital;
use App\Models\Solicitud;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Crypt;


class DigitalzacionComponent extends Component
{
    use WithFileUploads;
    use WithPagination;

    protected $inventarioDigital;
    public $tipo_documento, $tipo_documento_id, $tipoUsuario, $tipoUsuarioId, $seccion_empresa, $seccion_id,
    $empresa, $series, $serie_id, $subserie, $subserie_id, $tipologia, $tipologia_id, $tipoProceso,
    $tipo_usuarios, $tipo_usuario_id, $observaciones, $radicado, $fecha, $destinatario, $estante, $caja, $folios,
    $anexos, $descripcion, $confidencial, $adjunto, $documento, $nombrecompleto, $email, $telefono, $solicitud,
    $remitente_id, $param, $archivo;

    public function mount()
    {
        $this->tipoDocumento = Tipodocumento::all();
        $this->tipoDocumentoId = $this->tipoDocumento->first()->id;
        $this->tipoUsuario = TipoUsuario::all();
        $this->tipoUsuarioId = $this->tipoUsuario->first()->id;
        $s = SeccionUser::where('user_id', Auth::user()->id)->first();
        $this->empresa = $s->seccionempresa->empresa;
        $this->seccion_empresa = Subserie::seccionE($this->empresa->id);
        $this->seccion_id = $this->seccion_empresa->first()->id;
        $this->seccion_empresa = $this->seccion_empresa->pluck('nombre', 'id');

        $this->buscarSerie();
        $this->buscarSubSerie();

        $this->tipo_usuarios = TipoUsuario::all();
        $this->tipo_usuario_id = TipoUsuario::first()->id;
        $this->medio_recepcion = MedioRecepcion::all();
        $this->confidencial = false;

    }
    public function render()
    {
        if(Str::length($this->param)>2){
            $char = [' ',',','.',';','"','?','¿','!','¡','&','$','@','#','%',')','(','/','=','+','-','*','/','_',':','>','<','{','}','[',']',"'"];
            $p = '%'.str_replace($char,'',$this->param).'%';
            $inventarioDigital = InventarioDigital::select('inventario_digitals.*', 'remitente_digitals.nombrecompleto')
            ->whereRaw("(replace(remitente_digitals.nombrecompleto,' ','') like ?) or (replace(concat_ws('', remitente_digitals.documento),' ','') like ?) or (replace(concat_ws('', inventario_digitals.radicado),' ','') like ?) or (replace(concat_ws('', inventario_digitals.descripcion),' ','') like ?)",
            [$p, $p, $p, $p])
            ->join('remitente_digitals','inventario_digitals.remitente_id','remitente_digitals.id')
            ->where('inventario_digitals.empresa_id', $this->empresa->id)
            ->paginate(20);
        }
        else {
            $inventarioDigital = InventarioDigital::select('inventario_digitals.*', 'remitente_digitals.nombrecompleto')
            ->where('empresa_id', $this->empresa->id)
            ->join('remitente_digitals','inventario_digitals.remitente_id','remitente_digitals.id')
            ->paginate(20   );
        }

        return view('livewire.digitalzacion-component', ['inventarioDigital' =>  $inventarioDigital]);
    }

    public function buscarSerie()
    {
        $this->series = Subserie::serieSeccion($this->seccion_id);
        $this->serie_id = $this->series->first()->id;
        $this->series = $this->series->pluck('nombre', 'id');
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
        $this->tipologia = TipologiaDocumento::where('subserie_id', $this->subserie_id)->orderBy('nombre')->get();
        $this->tipologia_id = $this->tipologia->first()->id;
        $this->obtenerDiasTermino();
    }


    public function obtenerDiasTermino()
    {
        $this->diasTermino = TipologiaDocumento::find($this->tipologia_id)->pqrs->diastermino;
    }

    public function buscarRadicado()
    {
        $solicitud=Solicitud::where('radicado', $this->radicado)->first();
        if ($solicitud) {
            //-------------------------------- Datos de solictante ----------------
            $this->nombrecompleto = $solicitud->solicitante->nombrecompleto;
            $this->documento = $solicitud->solicitante->documento;
            $this->email = $solicitud->solicitante->email;
            $this->telefono = $solicitud->solicitante->telefono;
            $this->tipo_documento = $solicitud->solicitante->tipo_documento;

            //-------------------------------- Datos de Solicitud ----------------
            $this->seccion_id = $solicitud->seccion_id;
            $this->buscarSerie();
            $this->serie_id = $solicitud->serie_id;
            $this->buscarSubSerie();
            $this->subserie_id = $solicitud->subserie_id;
            $this->buscarTipologia();
            $this->tipologia_id = $solicitud->tipologia_id;
            $this->fecha = $solicitud->fecha;
            $this->destinatario = $solicitud->destinatario;
            $this->folios = $solicitud->folios;
            $this->anexos = $solicitud->anexos;
            $this->descripcion = $solicitud->asunto;
            $this->confidencial = $solicitud->confidencial;
            
        }
        $radicado = InventarioDigital::where('radicado', $this->radicado)->first();
        if($radicado){

        }
    }

    public function archivarDocumento()
    {

        $remitente = $this->guardarRemitente();

        $this->validate([
            'remitente_id' => 'required',
            'seccion_id' =>'required',
            'serie_id' =>'required',
            'tipologia_id' =>'required',
            'fecha' =>'required|date',
            'radicado' =>'required',
            'destinatario' =>'required|min:3',
            'estante' =>'required',
            'caja' =>'required',
            'folios' =>'required',
            'anexos' =>'required',
            'descripcion' => 'required',
            'documento' => 'required',
            'adjunto' => 'required|max:4096', // Pdf máximo 4MB
        ]);


        try {
            $dataValid['adjunto'] = $this->adjunto->store('pdf','public');
        } catch (\Throwable $th) {
            $dataValid['adjunto']='';
        }

        InventarioDigital::create([
            'user_id' => Auth::user()->id,
            'remitente_id' => $remitente->id,
            'seccion_id' => $this->seccion_id,
            'empresa_id' => $this->empresa->id,
            'serie_id' => $this->serie_id,
            'tipologia_id' => $this->tipologia_id,
            'fecha' => $this->fecha,
            'radicado' => $this->radicado,
            'destinatario' => $this->destinatario,
            'estante' => $this->estante,
            'caja' => $this->caja,
            'folios' => $this->folios,
            'anexos' => $this->anexos,
            'descripcion' => $this->descripcion,
            'observaciones' => $this->observaciones,
            'confidencial' => $this->confidencial,
            'documento' => $dataValid['adjunto'],
        ]);
        $this->limpiar();
    }

    public function guardarRemitente()
    {
        $this->validate([
            'tipo_documento'=>'required',
            'documento'=>'required|numeric|min:100',
            'nombrecompleto'=>'required|min:5',
            'email'=>'email',
            'telefono'=>'numeric'
        ]);

        $rd = RemitenteDigital::where('documento', $this->documento)->first();
        if(is_null($rd)){
            $rd = RemitenteDigital::create([
                'tipo_documento' => $this->tipo_documento,
                'documento' => $this->documento,
                'nombrecompleto' => $this->nombrecompleto,
                'email' => $this->email,
                'telefono' => $this->telefono,
            ]);
        }
        $this->remitente_id = $rd->id;
        return $rd;
    }

    public function buscarRemitente()
    {
        $remitente = RemitenteDigital::where('documento', $this->documento)->first();
        if($remitente){
            $this->tipo_documento = $remitente->tipo_documento;
            $this->nombrecompleto = $remitente->nombrecompleto;
            $this->email = $remitente->email;
            $this->telefono = $remitente->telefono;
            $this->remitente_id = $remitente->id;
        }
    }

    public function limpiar()
    {
        $this->fecha = null;
        $this->radicado = null;
        $this->destinatario = null;
        $this->estante = null;
        $this->caja = null;
        $this->folios = null;
        $this->anexos = null;
        $this->descripcion = null;
        $this->observaciones = null;
        $this->confidencial = null;
        $this->adjunto = null;
        $this->nombrecompleto = null;
        $this->email = null;
        $this->telefono = null;
        $this->remitente_id = null;
    }
    public function administrarDoc($documento)
    {
        $id = Crypt::decryptString($documento);
        $this->inventarioDigital = InventarioDigital::find($id);
    }
}
