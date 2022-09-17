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


class EmpresaUsuarioCompoment extends Component
{

    public $empresa, $empresa_id, $countempresa, $dependencia, $dependencia_id, $secciones, $estados, $estado_id, $ciudades,
    $nit, $razonsocial, $telefono, $email, $ciudad_id, $direccion, $id_eps, $boolguardar, $boolguardarDep, $modalFormVisible,
    $modalFormVisible1, $modalFormVisible2, $userName, $userEmail, $password, $password_confirmation, $seccionUser, $boolUsuario,
    $mensaje, $codigo, $publica;

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
        ]);

        SeccionEmpresa::create([
            'nombre'=>$this->dependencia,
            'codigo'=>$this->codigo,
            'empresa_id'=>$this->empresa_id,
            'estado_id'=>1,
            'publica' => $this->publica,
        ]);

        $this->dependencia = null;
        $this->codigo = null;

    }
    public function editDependencia($id)
    {
        $dependencia = SeccionEmpresa::find($id);
        $this->dependencia = $dependencia->nombre;
        $this->dependencia_id = $dependencia->id;
        $this->codigo = $dependencia->codigo;
        $this->boolguardarDep=false;
        $this->publica = $dependencia->publica;


    }
    public function updateDependencia()
    {
        $dependencia = SeccionEmpresa::find($this->dependencia_id);
        $dependencia->update([
            'nombre' => $this->dependencia,
            'codigo' => $this->codigo,
            'publica' => $this->publica,
        ]);


        $this->dependencia = null;
        $this->dependencia_id = null;
        $this->boolguardarDep = true;
        $this->codigo = null;
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

        $user->assignRole('Lider');

        SeccionUser::create([
            'user_id' => $user->id,
            'seccion_id' => $this->dependencia_id,
            'empresa_id'=>$this->empresa_id
        ]);

        Mail::to($user->email)->send(new bienvenidaMail($user));
        $this->modalFormVisible1 = false;
    }

    public function confirmarBorrarUsuario($id)
    {
        $seccion = SeccionUser::find($id);
        $seccion->delete();
        $this->seccionUser = null;
        $this->modalFormVisible1 = false;
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
