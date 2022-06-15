<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\EncuestaUsuario;
use App\Models\RespuestaUsuario;
use App\Models\PreguntaEncuesta;
use App\Models\RespuestaEncuesta;
use App\Models\Tipodocumento;
use App\Models\TipoEncuesta;
use App\Models\Solicitante;
use App\Models\empresa;

class EncuestaComponent extends Component
{
    public $empresa, $tiposolicitud, $solicitante, $solicitante_id, $tipodocumento, $etapa, $documento, $nacimiento, $nombrecompleto,
           $telefono, $email, $modalFormVisible, $mensaje, $tipo_documento, $tipo_id, $seccion_id, $solicitud, $adjunto, 
           $asunto, $anos, $ano, $meses, $mes, $dias, $dia, $preguntas, $respuesta, $respuesta_id, $respuesta_texto, $encuesta, 
           $encuestaUsuario;

    public function mount()
    {
        $url = request('e');
        $this->empresa=empresa::where('url',$url)->first();                
        $this->tipodocumento = Tipodocumento::all();
        $this->tipo_documento = 1;
        $this->etapa = 1;
        $this->anos = range(now()->year-100, now()->year);
        $this->ano = now()->year-30;
        $this->dias = range(1,31);
        $this->dia = 1;
        $this->mes = 1;
        $this->preguntas = PreguntaEncuesta::all();        
    }
    
    public function render()
    {
        return view('livewire.encuesta-component');
    }
    
    public function guardarEncuesta()
    {
        $this->encuestaUsuario->estado_id = 2;
        $this->encuestaUsuario->save();
        $this->etapa = 5;
        $this->encuestaUsuario = null;
    }

    public function nuevaSolicitud()
    {
        $this->encuestaUsuario = EncuestaUsuario::create([
            'solicitante_id' => $this->solicitante_id,
            'empresa_id' => $this->empresa->id,
            'estado_id' => 1,
        ]);
        $this->etapa = 2;
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
    
    public function crearFecha()
    {        
        $this->calcularDias();
        $this->buscarSolicitante();
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
                'email' => $this->email
            ]);
    
            $this->solicitante_id = $this->solicitante->id;        
            $this->etapa = 2;
        }
        $this->encuestaUsuario = EncuestaUsuario::where('solicitante_id', $this->solicitante_id)
        ->where('empresa_id', $this->empresa->id)
        ->where('estado_id',1)->first();

        if(is_null($this->encuestaUsuario)){
            $this->encuestaUsuario = EncuestaUsuario::create([
                'solicitante_id' => $this->solicitante_id,
                'empresa_id' => $this->empresa->id,
                'estado_id' => 1,
            ]);
        }
    }

    public function responder($pregunta, $respuesta)
    {
        RespuestaUsuario::where('pregunta_id', $pregunta)
        ->where('encuesta_id', $this->encuestaUsuario->id)
        ->delete();
        RespuestaUsuario::create(
            [
                'pregunta_id'=> $pregunta,
                'respuesta_id'=> $respuesta,
                'encuesta_id'=> $this->encuestaUsuario->id,
                'respuesta_texto'=> null,
            ]
        );
    }
}
