<?php

namespace App\Http\Controllers;

use App\Models\InventarioDigital;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

use App\Models\Solicitud;
use App\Models\Serie;
use App\Models\Subserie;
use App\Models\SeccionEmpresa;
use App\Models\TipologiaDocumento;
use App\Models\Pqr;

use App\Models\empresa;
use App\Models\SeguimientoOrden;
use Illuminate\Support\Facades\Storage;


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

}
