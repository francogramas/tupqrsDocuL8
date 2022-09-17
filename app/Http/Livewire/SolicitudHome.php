<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\empresa;
use App\Models\TipoSolicitud;
use App\Models\Tipodocumento;
use App\Models\Solicitante;
use App\Models\Solicitud;
use App\Models\SeguimientoOrden;
use App\Models\SeccionEmpresa;


use App\Mail\solicitudMail;
use Illuminate\Support\Facades\Mail;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SolicitudHome extends Component
{
    use WithFileUploads;

    public $empresa, $tiposolicitud, $solicitante, $solicitante_id, $tipodocumento, $etapa, $documento, $nacimiento, $nombrecompleto,
           $telefono, $email, $modalFormVisible, $mensaje, $tipo_documento, $tipo_id, $seccion_id, $solicitud, $adjunto,
           $asunto, $anos, $ano, $meses, $mes, $dias, $dia, $confidencial, $max_consecutivo;

    public function mount()
    {
        $url = request('e');
        $this->empresa=empresa::where('url',$url)->first();
        $this->tiposolicitud = TipoSolicitud::where('pqrs',1)->get();
        $this->tipodocumento = Tipodocumento::all();
        $this->tipo_documento = 1;
        $this->etapa = 1;
        $this->anos = range(now()->year-100, now()->year);
        $this->ano = now()->year-30;
        $this->dias = range(1,31);
        $this->dia = 1;
        $this->mes = 1;
        $this->confidencial = 0;
    }

    public function render()
    {
        return view('livewire.solicitud-home');

    }

    public function guardarSolicitante()
    {
        $this->validate([
            'tipo_documento' => 'required',
            'documento' => 'required|min:5',
            'nacimiento' => 'required|date',
            'telefono' => 'required|numeric|min:10',
            'email' => 'required|email',
            'nombrecompleto' => 'required|min:15'
        ]);

        $s = Solicitante::where('documento', $this->documento)->first();
        if($s){
            $s = Solicitante::where('documento', $this->documento)->where('nacimiento', $this->nacimiento)->first();
            if($s){
                $s->telefono = $this->telefono;
                $s->email = $this->email;
                $s->save();
                $this->etapa = 2;
                $this->solicitante = $s;
                $this->solicitante_id = $this->solicitante->id;

            }
            else {
                $this->mensaje = "El usuario ya se encuentra registrado en nuestro sistema, pero el número de documento no corresponde con la fecha de nacimiento, por favor verifique e intente nuevamente";
                $this->modalFormVisible = true;
            }
        }
        else {
            $this->solicitante = Solicitante::create([
                'tipo_documento' => $this->tipo_documento,
                'documento' => $this->documento,
                'nacimiento' => $this->nacimiento,
                'nombrecompleto' => $this->nombrecompleto,
                'telefono' => $this->telefono,
                'email' => $this->email,
                'tipo_usuario_id' => 4,
                'ciudad_id' => '920',
                'direccion'=>'Solicitud Virtual',
            ]);

            $this->solicitante_id = $this->solicitante->id;
            $this->etapa = 2;
        }

    }
    public function crearFecha()
    {
        $this->calcularDias();
        $this->buscarSolicitante();
    }

    public function buscarSolicitante()
    {
        $this->nacimiento = $this->ano.'-'.$this->mes.'-'.$this->dia;
        $s = Solicitante::where('documento', $this->documento)
        ->where('nacimiento', $this->nacimiento)->first();

        if($s){
            $this->nombrecompleto = $s->nombrecompleto;
            $this->telefono = $s->telefono;
            $this->email = $s->email;
        }
    }

    public function tipoSolicitud($id)
    {
        $this->tipo_id = $id;

        if ($this->empresa->secciones->where('publica',1)->count()>1) {
            $this->etapa = 3;
        }
        else{
            $this->etapa = 4;
            $this->seccion_id = $this->empresa->secciones->where('publica',1)->first()->id;
        }
    }

    public function seccionSolicitud($id)
    {
        $this->seccion_id = $id;
        $this->etapa = 4;
    }

    public function enviarSolicitud()
    {


        $datavalid = $this->validate([
            'asunto' => 'required',
            'solicitante_id' => 'required',
            'seccion_id' => 'required',
            'tipo_id' => 'required',
            'solicitud' => 'required|min:10',
            'adjunto' => 'max:4096', // Pdf máximo 4MB
        ]);

        try {
            $dataValid['adjunto'] = $this->adjunto->store('pdf','public');
        } catch (\Throwable $th) {
            $dataValid['adjunto']='';
        }

        $seccion_empresa = SeccionEmpresa::find($this->seccion_id);

        $solicitudBD = Solicitud::create([
            'solicitante_id'=>$this->solicitante_id,
            'estado_id'=>1,
            'seccion_id'=>$this->seccion_id,
            'empresa_id'=>$seccion_empresa->empresa_id,
            'tipo_id'=>$this->tipo_id,
            'radicado'=>$this->calcularRadicado(),
            'consecutivo'=>$this->max_consecutivo,
            'asunto'=>$this->asunto,
            'medio_id'=>5,
            'user_id'=>1,
            'tipologia_id'=>35,
            'respuesta_email'=> true,
            'confidencial'=>$this->confidencial,
            'diasTermino'=>30,
            'fecha'=>now()->format('Y-m-d'),
        ]);

        $seguimiento = SeguimientoOrden::create([
            'solicitud_id' => $solicitudBD->id,
            'user_id'=>Auth::user()->id,
            'estado_id' => 1,
            'seccion_id' => $this->seccion_id,
            'accion_id' => 1,
            'mensaje' => $this->solicitud,
            'adjunto' => $dataValid['adjunto'],
        ]);

        $this->etapa = 5;
        Mail::to($this->solicitante->email)->send(new solicitudMail($solicitudBD));
    }

    public function calcularDias()
    {
        $m31 = collect(["1","3","5","7","8","10","12"]);

        if($this->mes=="2"){
            $this->dias = range(1,28);
            if($this->ano%4==0){
                if($this->ano%100 != 0){
                    $this->dias = range(1,29);
                }
                elseif($this->ano%400 == 0){
                    $this->dias = range(1,29);
                }
            }
        }
        elseif($m31->contains($this->mes)){
            $this->dias = range(1,31);
        }
        else{
            $this->dias = range(1,30);
        }

        $this->dia = 1;
    }

    public function nuevaSolicitud()
    {
        $this->etapa = 2;
        $this->asunto = null;
        $this->solicitud = null;
    }

    public function calcularRadicado()
    {
        $date = Carbon::createFromDate(now()->format('Y-m-d'));
        $startOfYear = $date->copy()->startOfYear();
        $endOfYear   = $date->copy()->endOfYear();

        $this->max_consecutivo = Solicitud::where('empresa_id',$this->empresa->id)
                            ->whereBetween('created_at',[$startOfYear, $endOfYear])
                            ->max('consecutivo');
        if($this->max_consecutivo>0){
            $this->max_consecutivo +=1;
        }
        else{
            $this->max_consecutivo =1;
        }
        $BDseccion_empresa = SeccionEmpresa::find($this->seccion_id);
        $radicado = now()->format('y').$BDseccion_empresa->codigo.TipoSolicitud::find($this->tipo_id)->codigo.$this->max_consecutivo;
        return($radicado);
    }
}
