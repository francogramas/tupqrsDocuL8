<?php

namespace App\Http\Controllers;

use App\Models\InventarioDigital;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

use App\Models\empresa;
use App\Models\SeguimientoOrden;
use App\Models\Solicitud;
use App\Models\ColaSolicitud;

use Illuminate\Support\Facades\Mail;
use App\Mail\respuestaSolicitudMail;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Request;


class impDocumentoController extends Controller
{
    /* function seguimiento($seguimiento): imprime el documento en pdf del
    soporte de cada una de las solicitudes */
    public function seguimiento($seguimiento)
    {
        try {
            $id = Crypt::decryptString($seguimiento);
            $seguimiento = SeguimientoOrden::find($id);
            $solicitud = $seguimiento->solicitud;
            $url = Storage::url('public/'.$seguimiento->adjunto);
            return view('impDocumentoView')
            ->with('solicitud', $solicitud)
            ->with('seguimiento', $seguimiento)
            ->with('url', $url);

        } catch (DecryptException $e) {
            return('No existe la solicitud');
        }
    }

    /* function archivo($documento) muestra el documento archivado digitalmente*/
    public function archivo($documento)
    {
        try {
            $id = Crypt::decryptString($documento);
            $archivo = InventarioDigital::find($id);
            $url = Storage::url('public/'.$archivo->documento);
            return view('impDocumentoView')
            ->with('url', $url);

        } catch (DecryptException $e) {
            return('No existe la solicitud');
        }
    }

    /* Function  trd() Imprime las tablas de retención documental*/
    public function trd($empresa)
    {
        try {
            $id = Crypt::decryptString($empresa);
            $empresa = empresa::find($id);

            return view('trd')
            ->with('empresa', $empresa);

        } catch (DecryptException $e) {
            return('No existen tablas para la empresa');
        }
    }

    public function oficio($seguimiento)
    {
        $id = Crypt::decryptString($seguimiento);
        $s = SeguimientoOrden::find($id);
        $urlFirma = Storage::url('public/'.$s->seccionempresa->firma);
        $urlLogo = Storage::url('public/'.$s->solicitud->empresa->logo);

        return view('oficio_respuesta', ['s'=>$s, 'urlFirma'=>$urlFirma, 'urlLogo'=>$urlLogo]);
    }

    public function seguimientoLider($solicitud_id)
    {
        // La $solcititud es el radicado de salida
        $id = Crypt::decryptString($solicitud_id);
        $cola = ColaSolicitud::where('solicitudSalida', $id)->first();
        $solicitud = Solicitud::find($id);

        return view('seguimientoLider', ['solicitud'=>$solicitud, 'cola'=>$cola, 'solicitud_id'=> $solicitud_id]);
    }

    /*responderSolicitud($solicitud)
    * Da respuesta desde la herramienta del jefe de oficina a la solicitud
    */
    public function responderSolicitud(Request $request, $seguimiento_id)
    {
        $id = Crypt::decryptString($seguimiento_id);
        $s = SeguimientoOrden::find($id);
        $solicitudi = Solicitud::find($s->solicitud_id);
        $s->mensaje = $request->mensaje;
        $solicitudi->estado_id = 4;
        $solicitudi->save();
        $s->save();

        Mail::to($solicitudi->solicitante->email)->send(new respuestaSolicitudMail($solicitudi));
        return('Su respuesta se ha radicado correctamente');
    }

}
