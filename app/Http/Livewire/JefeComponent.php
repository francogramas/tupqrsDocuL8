<?php

namespace App\Http\Livewire;

use App\Models\ColaSolicitud;
use Livewire\Component;
use Illuminate\Support\Facades\Crypt;
use App\Models\Solicitud;
use App\Models\SeccionUser;
use App\Models\SeccionEmpresa;
use App\Models\SeguimientoOrden;
use App\Mail\respuestaSolicitudMail;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Auth;

class JefeComponent extends Component
{
    public $sol, $solicitud, $cola, $pendientes, $secciones, $seccion_id, $solicitudi, $mensaje, $secc;
    protected $queryString = ['sol'];

    public function mount()
    {

        $this->secc = SeccionUser::select('seccion_id')->where('user_id', Auth::user()->id)->where('jefe',true)->groupBy('id')->get();
        $this->secciones = SeccionEmpresa::whereIn('id',$this->secc)->get();
        $this->seccion_id = $this->secciones->first()->id;


        if (!is_null($this->sol)) {
            $id = Crypt::decryptString($this->sol);
            $this->verSolicitud($id);
            //dd($this->solicitud);
        }
        else {
            try {
                $this->cola = ColaSolicitud::where('seccion_id', $this->seccion_id)->where('finalizada',false)->first();
                $this->solicitud = Solicitud::find($this->cola->solicitudSalida);
            } catch (\Throwable $th) {
                $this->cola = null;
                $this->solicitud = null;
                $this->pendientes= null;
            }

        }

        if (!is_null($this->cola)) {
            $s = SeccionUser::select('seccion_id')->where('user_id', Auth::user()->id)->where('jefe',true)->groupBy('id')->get();
            $this->secciones = SeccionEmpresa::whereIn('id',$s)->get();
            $this->seccion_id = $this->secciones->first()->id;
            $this->cargarPendientes();
            $this->respuesta= $this->cola->salida->seguimiento->last()->mensaje;
        }

    }

    public function render()
    {
        return view('livewire.jefe-component');
    }

    public function cargarPendientes()
    {
        //dd($this->s);
        $this->secc = SeccionUser::select('seccion_id')->where('user_id', Auth::user()->id)->groupBy('seccion_id')->get();
        $this->pendientes = ColaSolicitud::where('finalizada',false)
                            ->whereIn('seccion_id', $this->secc)
                            ->get();
    }

    public function verSolicitud($id)
    {

        $this->cola = ColaSolicitud::where('solicitudSalida',$id)->where('finalizada',false)->first();
        if (is_null($this->cola)) {
            $this->cola = ColaSolicitud::where('finalizada',false)
                            ->where('seccion_id', $this->seccion_id)
                            ->first();
            if (!is_null($this->cola)) {
                $id = $this->cola->salida->id;
                $this->solicitud = Solicitud::find($id);
                $this->respuesta= $this->cola->salida->seguimiento->last()->mensaje;
            }
        }
        else {
            $this->solicitud = Solicitud::find($id);
            $this->respuesta= $this->cola->salida->seguimiento->last()->mensaje;
        }

        $this->cargarPendientes();
    }

    public function responderSolicitud()
    {
        $id = $this->cola->salida->seguimiento->last()->id;
        $s = SeguimientoOrden::find($id);
        $solicitudi = Solicitud::find($s->solicitud_id);
        $s->mensaje = $this->respuesta;
        $solicitudi->estado_id = 4;
        $solicitudi->save();
        $s->save();

        Mail::to($solicitudi->solicitante->email)->send(new respuestaSolicitudMail($solicitudi));

        $this->cola->finalizada=true;
        $this->cola->save();

        $this->cargarPendientes();


        if (is_null($this->pendientes)) {
            $this->solicitud=null;
            $this->cola = null;
        }
        else {
            try {
                $this->cola = ColaSolicitud::where('seccion_id', $this->seccion_id)->where('finalizada',false)->first();
                $this->solicitud = $this->cola->first()->salida;
                $this->respuesta = $this->cola->salida->seguimiento->last()->mensaje;
            } catch (\Throwable $th) {
                $this->solicitud=null;
                $this->cola = null;
            }

        }
    }
}
