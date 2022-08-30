<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\empresa;
use App\Models\mailEmpresa;
use App\Mail\adminEmpresasMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Estado;
use App\Models\Ciudade;

use Illuminate\Support\Facades\DB;

class AdminEmpresasComponent extends Component
{
    use WithPagination;

    public  $empresa_id, $empresa, $modalFormVisible1, $asunto, $mensaje, $estado_id, $param, $estados, $estados_id, $ciudades, $ciudad_id,
    $boolGuardar;
    public function mount()
    {
        $this->empresa = empresa::first();
        $this->estado_id = '_';
        $this->estados=Estado::all()->sortBy('estado');
        $this->estados_id=$this->estados->first()->id;
        $this->cargarciudades();

    }

    public function render()
    {
        $empresas = $this->buscarEmpresas();
        return view('livewire.admin-empresas-component',['empresas'=>$empresas]);
    }

    public function cambiarEstado($id)
    {
        $e = empresa::find($id);
        if($e->estado_id==1){
            $e->estado_id = 2;
        }
        else{
            $e->estado_id = 1;
        }
        $e->save();
    }

    public function mostrarMensaje($id)
    {
        $this->modalFormVisible1 = true;
        $this->empresa = empresa::find($id);

    }

    public function enviarMensaje()
    {
        if ($this->empresa->id>0) {
            $this->enviarCorreos($this->empresa);
        }
        else {
            $empresas = $this->buscarEmpresas();
            foreach ($empresas as $empresai) {
                $this->enviarCorreos($empresai);
            }
        }

        $this->modalFormVisible1 = false;
        $this->asunto = null;
        $this->mensaje = null;
    }

    public function mostrarMensajeMasivo()
    {
        $this->empresa = new empresa();
        $this->empresa->id = 0;
        $this->empresa->razonsocial = "Todas las empresas seleccionadas";
        $this->modalFormVisible1 = true;
    }

    public function clickParam()
    {
        $this->param = null;
    }

    public function buscarEmpresas()
    {
        if(Str::length($this->param)>1){
            $char = [' ',',','.',';','"','?','¿','!','¡','&','$','@','#','%',')','(','/','=','+','-','*','/','_',':','>','<','{','}','[',']',"'"];
            $p = '%'.str_replace($char,'',$this->param).'%';
            $empresas = empresa::whereRaw("(replace(concat_ws('', nit),' ','') like ?) or (replace(concat_ws('', razonsocial),' ','') like ?)", [$p, $p])->paginate(19);
        }
        else {
            $empresas = empresa::where('estado_id','like',$this->estado_id)->paginate(30);
        }

        return $empresas;
    }

    public function enviarCorreos($e)
    {
        $mailEmpresa =  mailEmpresa::create([
            'asunto' => $this->asunto,
            'mensaje' => $this->mensaje,
            'empresa_id' => $e->id,
        ]);

        Mail::to($e->email)
        ->send(new adminEmpresasMail($mailEmpresa));
    }

    public function cargarciudades()
    {
        $this->ciudades = Ciudade::where('estado_id',$this->estados_id)->get();
        $this->ciudad_id = $this->ciudades->first()->id;
    }

    public function crearNueva()
    {
        $this->boolGuardar = true;
    }

    public function guardarNueva()
    {

    }
    public function cancelarNueva()
    {
        $this->boolGuardar = false;
    }
}
