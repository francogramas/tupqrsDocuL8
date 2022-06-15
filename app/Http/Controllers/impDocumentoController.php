<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use App\Models\Solicitud;
use App\Models\SeguimientoOrden;
use Illuminate\Support\Facades\Storage;


class impDocumentoController extends Controller
{
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
}
