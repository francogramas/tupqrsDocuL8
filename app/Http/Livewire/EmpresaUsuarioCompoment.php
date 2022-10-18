<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\empresa;
use App\Models\Estado;
use App\Models\Ciudade;
use App\Models\SeccionEmpresa;
use App\Models\User;
use App\Models\SeccionUser;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Mail\bienvenidaMail;
use Illuminate\Support\Facades\Mail;
use Livewire\WithFileUploads;
use App\Models\Serie;
use App\Models\Subserie;
use App\Models\TipologiaDocumento;
use Illuminate\Support\Facades\Storage;
use App\Models\EmpresaUser;
use Database\Seeders\themeSeeder;

class EmpresaUsuarioCompoment extends Component
{
    use WithFileUploads;

    public $empresa, $empresa_id, $countempresa, $dependencia, $dependencia_id, $secciones, $estados, $estado_id, $ciudades,
    $nit, $razonsocial, $telefono, $email, $ciudad_id, $direccion, $id_eps, $boolguardar, $boolguardarDep, $modalFormVisible,
    $modalFormVisible1, $modalFormVisible2, $userName, $userEmail, $password, $password_confirmation, $seccionUser, $seccionUsers, $boolUsuario,
    $mensaje, $codigo, $publica, $lider, $firma, $emailjefe, $urlFirma, $jefe, $jefeNoExiste;

    public function rules()
    {
         return [
             'nit' => 'required|min:10|unique:empresas,nit,'.$this->empresa_id,
             'razonsocial' => 'required|min:5',
             'direccion' => 'required',
             'telefono' => 'required',
             'ciudad_id' => 'required',
             'email' => 'required|email',
         ];
    }
    public function mount()
    {
        $this->empresa = empresa::where('user_id', Auth::user()->id)->first();
        $this->countempresa = empresa::where('user_id', Auth::user()->id)->count();
        if ($this->countempresa==0) {
            $this->empresa_id=0;
        }
        else{
            $this->empresa_id=$this->empresa->id;
        }
        $this->estados=Estado::all()->sortBy('estado');
        $this->estado_id=1;
        $this->ciudades = Ciudade::where('estado_id',$this->estado_id)->get();
        $ciudad1 = Ciudade::where('estado_id',$this->estado_id)->first();
        $this->ciudad_id = $ciudad1->id;
        $this->boolguardar = true;
        $this->boolguardarDep = true;
        $this->publica = true;
    }

    public function render()
    {
        $this->empresa = empresa::where('user_id', Auth::user()->id)->first();
        return view('livewire.empresa-usuario-compoment');
    }

    public function cargarciudades()
    {
        $this->ciudades = Ciudade::where('estado_id',$this->estado_id)->get();
        $ciudades1 = Ciudade::where('estado_id',$this->estado_id)->first();
        $this->ciudad_id = $ciudades1->id;
    }

    public function store()
    {
        $this->validate();
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
        empresa::create([
            'nit'=>$this->nit,
            'razonsocial'=>$this->razonsocial,
            'telefono'=>$this->telefono,
            'email'=>$this->email,
            'ciudad_id'=>$this->ciudad_id,
            'direccion'=>$this->direccion,
            'user_id'=>Auth::user()->id,
            'estado_id'=>1,
            'logo'=>'',
            'url'=>$url,
        ]);
        $this->limpiar();

        $this->countempresa = empresa::where('user_id', Auth::user()->id)->count();

    }
    public function edit()
    {
        $this->countempresa = 0;
        $this->nit=$this->empresa->nit;
        $this->razonsocial=$this->empresa->razonsocial;
        $this->telefono=$this->empresa->telefono;
        $this->email=$this->empresa->email;
        $this->estado_id = $this->empresa->ciudad->estado->id;
        $this->ciudades=Ciudade::where('estado_id',$this->estado_id)->get();
        $this->ciudad_id=$this->empresa->ciudad_id;
        $this->direccion=$this->empresa->direccion;
        $this->id_eps=$this->empresa->id;
        $this->boolguardar = false;

    }
    public function update()
    {
        $this->validate();
        $this->empresa->update([
            'nit'=>$this->nit,
            'razonsocial'=>$this->razonsocial,
            'telefono'=>$this->telefono,
            'email'=>$this->email,
            'ciudad_id'=>$this->ciudad_id,
            'direccion'=>$this->direccion,
        ]);
        $this->boolguardar=true;
       $this->limpiar();
       $this->countempresa = 1;
    }

    public function limpiar()
    {
        $this->nit="";
        $this->razonsocial="";
        $this->telefono="";
        $this->email="";
        $this->direccion="";
        $this->dependencia = null;
        $this->codigo = null;
        $this->urlFirma = null;
    }

    public function crearDependencia()
    {
        if($this->empresa_id==0){
            $this->empresa = empresa::where('user_id', Auth::user()->id)->first();
            $this->empresa_id=$this->empresa->id;
        }
        $this->validate([
            'dependencia' => 'required|min:3',
            'codigo' => 'required|min:3',
            'lider' => 'required',
            'firma' => 'max:1024', // Pdf máximo 1MB
        ]);

        try {
            $dataValid['firma'] = $this->firma->store('firmas','public');

        } catch (\Throwable $th) {
            $dataValid['firma']='';
        }

        $seccion = SeccionEmpresa::create([
            'nombre'=>$this->dependencia,
            'codigo'=>$this->codigo,
            'empresa_id'=>$this->empresa_id,
            'estado_id'=>1,
            'publica' => $this->publica,
            'lider' => $this->lider,
            'firma' => $dataValid['firma'],
            'emailjefe' => $this->emailjefe,
        ]);

        //------------------------------------------------------------------ SERIES
        $SP = Serie::where('empresa_id', $this->empresa_id)->where('nombre', 'PETICIONES')->first();
        $SQ = Serie::where('empresa_id', $this->empresa_id)->where('nombre', 'QUEJAS')->first();
        $SR = Serie::where('empresa_id', $this->empresa_id)->where('nombre', 'RECLAMOS')->first();
        $SS = Serie::where('empresa_id', $this->empresa_id)->where('nombre', 'SUGERENCIAS')->first();
        $SD = Serie::where('empresa_id', $this->empresa_id)->where('nombre', 'DENUNCIAS')->first();

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

        $this->dependencia = null;
        $this->codigo = null;

    }
    public function editDependencia($id)
    {
        $dependencia = SeccionEmpresa::find($id);
        $this->dependencia = $dependencia->nombre;
        $this->dependencia_id = $dependencia->id;
        $this->codigo = $dependencia->codigo;
        $this->lider = $dependencia->lider;
        $this->firma = $dependencia->firma;
        $this->boolguardarDep=false;
        $this->publica = $dependencia->publica;
        $this->emailjefe = $dependencia->emailjefe;
        $this->urlFirma = $dependencia->firma;

    }
    public function updateDependencia()
    {
        $dependencia = SeccionEmpresa::find($this->dependencia_id);


        $this->validate([
            'dependencia' => 'required|min:3',
            'codigo' => 'required|min:3',
            'lider' => 'required',
            'firma' => 'max:1024', // Pdf máximo 1MB
        ]);

        try {
            $dataValid['firma'] = $this->firma->store('firmas','public');
            Storage::disk('local')->delete('public/'.$dependencia->firma);

        } catch (\Throwable $th) {
            $dataValid['firma'] = $dependencia->firma;
        }

        $dependencia->update([
            'nombre' => $this->dependencia,
            'codigo' => $this->codigo,
            'publica' => $this->publica,
            'lider' => $this->lider,
            'firma' => $dataValid['firma'],
            'emailjefe' => $this->emailjefe,
        ]);


        $this->dependencia = null;
        $this->dependencia_id = null;
        $this->boolguardarDep = true;
        $this->codigo = null;
        $this->lider = null;
        $this->firma = null;
        $this->emailjefe = null;
        $this->urlFirma = null;
    }

    public function deleteDependencia()
    {
        try {
            $dependencia = SeccionEmpresa::find($this->dependencia_id)->delete();
            $this->dependencia=null;
            $this->dependencia_id = null;
            $this->modalFormVisible=false;
        } catch (\Throwable $th) {
            $this->mensaje="No se puede eliminar la sección por que ya tiene líder y/o solicitudes asignados";
            $this->modalFormVisible = false;
            $this->modalFormVisible2 = true;
        }
    }

    public function confirmarBorrarDependencia($id)
    {
        $this->dependencia_id = $id;
        $this->modalFormVisible = true;
    }

    public function adminUsuario($id)
    {
        $this->dependencia_id = $id;
        $this->modalFormVisible1 = true;
        $this->seccionUser = SeccionUser::where('seccion_id', $id)->first();
        $this->seccionUsers = SeccionUser::where('seccion_id', $id)->get();
        $this->jefeNoExiste = is_null(SeccionUser::where('seccion_id', $id)->where('jefe',true)->first());

        $this->userEmail = null;
        $this->userName = null;
        $this->password_confirmation = null;
        $this->password = null;
    }

    public function saveUser()
    {
        $this->validate([
            'userName' => 'required|min:5',
            'userEmail' => 'required|email',
            'password' => ['required','confirmed', Password::min(8)]
        ]);
        $user = User::firstOrCreate(
            ['email'=>$this->userEmail],
            ['name'=>$this->userName, 'password'=>Hash::make($this->password),]
        );

        if ($this->jefe) {
            $user->assignRole('Jefe');
        } else {
            $user->assignRole('Lider');
        }

        EmpresaUser::firstOrCreate([
            'user_id'=>$user->id,
            'empresa_id'=>$this->empresa_id
        ]);

        SeccionUser::firstOrCreate([
            'user_id' => $user->id,
            'seccion_id' => $this->dependencia_id,
            'empresa_id'=>$this->empresa_id,
            'jefe' => $this->jefe,
        ]);

        Mail::to($user->email)->send(new bienvenidaMail($user));
        $this->seccionUser = SeccionUser::where('seccion_id', $this->dependencia_id)->first();
        $this->seccionUsers = SeccionUser::where('seccion_id', $this->dependencia_id)->get();
        //$this->modalFormVisible1 = false;
        $this->jefe=false;
    }

    public function confirmarBorrarUsuario($id)
    {
        $seccion = SeccionUser::find($id);
        $seccion->delete();
        $this->seccionUser = SeccionUser::where('seccion_id', $this->dependencia_id)->first();
        $this->seccionUsers = SeccionUser::where('seccion_id', $this->dependencia_id)->get();

        //$this->modalFormVisible1 = false;
    }

    public function revisarEmail()
    {
        $u = User::where('email', $this->userEmail)->first();

        if(!is_null($u)){
            $s = SeccionUser::where('user_id', $u->id)->count();
            $this->userName = $u->name;
            $this->userEmail = $u->email;
            $this->password = '123456789';
            $this->password_confirmation = '123456789';
            $this->boolUsuario=true;

            if($s>0){
                $this->mensaje = "Este usuario por que ya está asignado a otra dependencia o empresa";
                /**$this->modalFormVisible1 = false;
                $this->modalFormVisible2 = true;*/

            }
/*            else {
                $this->mensaje = "Este usuario por que ya está asignado a otra dependencia o empresa";
            }

            if($u->HasRole('Gerente')){
                $this->modalFormVisible1 = false;
                $this->modalFormVisible2 = true;
                $this->mensaje = "No se puede asignar este usuario por que ya tiene rol de gerente";
            }
*/

        }
        else {
            $this->boolUsuario=false;
        }
    }
}
