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
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\SeccionUser;
use App\Models\Serie;
use App\Models\Subserie;
use App\Models\SeccionEmpresa;
use App\Models\TipologiaDocumento;
use App\Models\EmpresaUser;


class AdminEmpresasComponent extends Component
{
    use WithPagination;
    use WithFileUploads;


    public  $empresa_id, $empresa, $modalFormVisible1, $asunto, $mensaje, $estado_id, $param, $estados, $estados_id, $ciudades, $ciudad_id,
    $boolGuardar, $boolUpdate, $nit, $razonsocial, $direccion, $telefono, $email, $logo, $user_id, $url, $dominio, $urlLogo;

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
        $this->boolUpdate = false;
        $this->limpiar();
    }

    public function guardarNueva()
    {
        $this->validate(
            [
                'nit' => 'required|min:10|unique:empresas,nit,'.$this->empresa_id,
                'razonsocial' => 'required|min:5',
                'direccion' => 'required',
                'telefono' => 'required',
                'ciudad_id' => 'required',
                'email' => 'required|email',
                'logo' => 'max:1024', // Pdf máximo 1MB
            ]
        );

        $url =  Str::random(12);
        $ban = true;

        while ($ban) {
            $e = empresa::where('url',$url)->count();
            if($e==0){
                $ban=false;
            }
            else{
                $url =  Str::random(8);
            }
        }

        try {
            $dataValid['logo'] = $this->logo->store('logos','public');

        } catch (\Throwable $th) {
            $dataValid['logo']='';
        }


// Admin
        $admin = User::firstOrCreate([ 'name' => 'Administrador del Sistema', 'email' => 'admin@'.$this->dominio, 'email_verified_at' => now(), 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',]);
        $admin->assignRole('Gerente');
        $admin->assignRole('Ventanilla');

        EmpresaUser::firstOrCreate(
            [
                'user_id' => $admin->id,
                'empresa_id' => $this->empresa_id
            ]
        );

// Lider de vetanilla unica central
        $usuario = User::firstOrCreate(['name' => 'Ventanilla Unica', 'email' => 'ventanilla@'.$this->dominio, 'email_verified_at' => now(), 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',]);
        $usuario->assignRole('Ventanilla');

        EmpresaUser::firstOrCreate(
            [
                'user_id' => $usuario->id,
                'empresa_id' => $this->empresa_id
            ]
        );

// Auxiliar de dependencia
        $auxiliar = User::firstOrCreate(['name' => 'Auxiliar 1', 'email' => 'auxiliar@'.$this->dominio, 'email_verified_at' => now(), 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',]); // password
        $auxiliar->assignRole('Lider');

        EmpresaUser::firstOrCreate(
            [
                'user_id' => $auxiliar->id,
                'empresa_id' => $this->empresa_id
            ]
        );

        $empresa = empresa::firstOrCreate( [ 'nit'=> $this->nit, 'razonsocial'=> $this->razonsocial, 'direccion'=> $this->direccion, 'telefono'=> $this->telefono, 'email'=> $this->email, 'logo'=> $dataValid['logo'], 'ciudad_id'=> $this->ciudad_id, 'user_id'=> $admin->id, 'url'=> $url, 'estado_id'=> 1, 'dominio'=> $this->dominio,] );
        $seccion = SeccionEmpresa::firstOrCreate(['nombre'=>'Oficina General', 'codigo'=>'000', 'empresa_id'=>$empresa->id, 'estado_id'=>1, 'publica' => true, ]);

        SeccionUser::create(['user_id' => $auxiliar->id, 'seccion_id' => $seccion->id, 'empresa_id'=>$empresa->id,]);
        SeccionUser::create(['user_id' => $admin->id, 'seccion_id' => $seccion->id, 'empresa_id'=>$empresa->id,]);
        SeccionUser::create(['user_id' => $usuario->id, 'seccion_id' => $seccion->id, 'empresa_id'=>$empresa->id,]);

        //------------------------------------------------------------------ SERIES
        $SP = Serie::create([ 'empresa_id' => $empresa->id, 'nombre' => 'PETICIONES', 'codigo' => '0001', ]);
        $SQ = Serie::create([ 'empresa_id' => $empresa->id, 'nombre' => 'QUEJAS', 'codigo' => '0002', ]);
        $SR = Serie::create([ 'empresa_id' => $empresa->id, 'nombre' => 'RECLAMOS', 'codigo' => '0003', ]);
        $SS = Serie::create([ 'nombre' => 'SUGERENCIAS', 'empresa_id' => $empresa->id, 'codigo' => '0004', ]);
        $SD = Serie::create([ 'empresa_id' => $empresa->id, 'nombre' => 'DENUNCIAS', 'codigo' => '0005', ]);

        //------------------------------------------------------------------ SUBSERIES

        $SSP = Subserie::create([ 'serie_id'=>$SP->id, 'seccion_id'=>$seccion->id, 'codigo'=>'0001', 'nombre'=>'PETICIONES', 'Re_AG'=>10, 'Re_AC'=>0, 'DF_CT'=>true, 'DF_E'=>false, 'DF_MD'=>false, 'DF_S'=>false, 'ACC_P'=>true, 'ACC_Pr'=>false, 'procedimiento'=>'',]);
        $SSQ = Subserie::create([ 'serie_id'=>$SQ->id, 'seccion_id'=>$seccion->id, 'codigo'=>'0002', 'nombre'=>'QUEJAS', 'Re_AG'=>10, 'Re_AC'=>0, 'DF_CT'=>true, 'DF_E'=>false, 'DF_MD'=>false, 'DF_S'=>false, 'ACC_P'=>true, 'ACC_Pr'=>false, 'procedimiento'=>'',]);
        $SSR = Subserie::create([ 'serie_id'=>$SR->id, 'seccion_id'=>$seccion->id, 'codigo'=>'0003', 'nombre'=>'RECLAMOS', 'Re_AG'=>10, 'Re_AC'=>0, 'DF_CT'=>true, 'DF_E'=>false, 'DF_MD'=>false, 'DF_S'=>false, 'ACC_P'=>true, 'ACC_Pr'=>false, 'procedimiento'=>'',]);
        $SSS = Subserie::create([ 'serie_id'=>$SS->id, 'seccion_id'=>$seccion->id, 'codigo'=>'0004', 'nombre'=>'SUGERENCIAS', 'Re_AG'=>10, 'Re_AC'=>0, 'DF_CT'=>true, 'DF_E'=>false, 'DF_MD'=>false, 'DF_S'=>false, 'ACC_P'=>true, 'ACC_Pr'=>false, 'procedimiento'=>'',]);
        $SSD = Subserie::create([ 'serie_id'=>$SD->id, 'seccion_id'=>$seccion->id, 'codigo'=>'0005', 'nombre'=>'DENUNCIAS', 'Re_AG'=>10, 'Re_AC'=>0, 'DF_CT'=>true, 'DF_E'=>false, 'DF_MD'=>false, 'DF_S'=>false, 'ACC_P'=>true, 'ACC_Pr'=>false, 'procedimiento'=>'',]);

        //--------------------------------------------------------------------------tipología
        TipologiaDocumento::create([ 'subserie_id'=>$SSP->id, 'nombre'=>'PETICIONES', 'So_Pa'=>true, 'So_El'=>true, 'So_Di'=>true, 'diasTermino'=>15, 'radicadoSalida'=>true, 'radicadoEntrada'=>false, 'pqrs_id'=>true, ]);
        TipologiaDocumento::create([ 'subserie_id'=>$SSQ->id, 'nombre'=>'QUEJAS', 'So_Pa'=>true, 'So_El'=>true, 'So_Di'=>true, 'diasTermino'=>15, 'radicadoSalida'=>true, 'radicadoEntrada'=>false, 'pqrs_id'=>true, ]);
        TipologiaDocumento::create([ 'subserie_id'=>$SSR->id, 'nombre'=>'RECLAMOS', 'So_Pa'=>true, 'So_El'=>true, 'So_Di'=>true, 'diasTermino'=>15, 'radicadoSalida'=>true, 'radicadoEntrada'=>false, 'pqrs_id'=>true, ]);
        TipologiaDocumento::create([ 'subserie_id'=>$SSS->id, 'nombre'=>'SUGERENCIAS', 'So_Pa'=>true, 'So_El'=>true, 'So_Di'=>true, 'diasTermino'=>15, 'radicadoSalida'=>true, 'radicadoEntrada'=>false, 'pqrs_id'=>true, ]);
        TipologiaDocumento::create([ 'subserie_id'=>$SSD->id, 'nombre'=>'DENUNCIAS', 'So_Pa'=>true, 'So_El'=>true, 'So_Di'=>true, 'diasTermino'=>15, 'radicadoSalida'=>true, 'radicadoEntrada'=>false, 'pqrs_id'=>true, ]);


        $this->limpiar();
        $this->boolGuardar = false;
        $this->boolUpdate = false;

    }
    public function cancelarNueva()
    {
        $this->boolGuardar = false;
        $this->boolUpdate = false;
    }

    public function limpiar()
    {
        $this->nit=null;
        $this->razonsocial=null;
        $this->direccion=null;
        $this->telefono=null;
        $this->email=null;
        $this->logo=null;
        $this->dominio=null;
        $this->urlLogo = null;
        $this->empresa = null;
        $this->empresa_id = null;
    }

    public function edit($id)
    {
        $this->empresa_id = $id;
        $this->empresa = empresa::find($this->empresa_id);
        $this->nit = $this->empresa->nit;
        $this->razonsocial = $this->empresa->razonsocial;
        $this->direccion = $this->empresa->direccion;
        $this->telefono = $this->empresa->telefono;
        $this->email = $this->empresa->email;
        $this->logo = $this->empresa->logo;
        $this->ciudad_id = $this->empresa->ciudad_id;
        $this->user_id = $this->empresa->user_id;
        $this->url = $this->empresa->url;
        $this->estado_id = $this->empresa->estado_id;
        $this->dominio = $this->empresa->dominio;

        $this->ciudades = Ciudade::where('estado_id', $this->empresa->ciudad->estado->id)->get();
        $this->urlLogo = $this->empresa->logo;

        $this->boolGuardar=true;
        $this->boolUpdate = true;
    }

    public function update()
    {
        $this->validate(
            [
                'nit' => 'required|min:10|unique:empresas,nit,'.$this->empresa_id,
                'razonsocial' => 'required|min:5',
                'direccion' => 'required',
                'telefono' => 'required',
                'ciudad_id' => 'required',
                'email' => 'required|email',
                'logo' => 'max:1024', // Pdf máximo 1MB
            ]
        );

        try {
            $dataValid['logo'] = $this->logo->store('logos','public');
            Storage::disk('local')->delete('public/'.$this->empresa->logo);

        } catch (\Throwable $th) {
            $dataValid['logo']=$this->empresa->logo;
        }

        $this->empresa->nit = $this->nit;
        $this->empresa->razonsocial = $this->razonsocial;
        $this->empresa->direccion = $this->direccion;
        $this->empresa->telefono = $this->telefono;
        $this->empresa->email = $this->email;
        $this->empresa->logo = $this->logo;
        $this->empresa->ciudad_id = $this->ciudad_id;
        $this->empresa->user_id = $this->user_id;
        $this->empresa->url = $this->url;
        $this->empresa->estado_id = $this->estado_id;
        $this->empresa->dominio = $this->dominio;

        $this->empresa->save();
        $this->cancelarNueva();
        $this->limpiar();

    }
}
