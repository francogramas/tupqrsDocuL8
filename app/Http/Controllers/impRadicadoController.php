<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use App\Models\Solicitud;

class impRadicadoController extends Controller
{
    public function radicado($radicado)
    {
        try {
            $id = Crypt::decryptString($radicado);
            $solicitud = Solicitud::find($id);            
            return view('impRadicadoView')->with('solicitud', $solicitud);

        } catch (DecryptException $e) {
            return('No existe la solicitud');
        }        
    }
    public function ficha($radicado)
    {
        
        try {
            $id = Crypt::decryptString($radicado);
            $solicitud = Solicitud::find($id);            
            
            return view('impFichaView')->with('solicitud', $solicitud);

        } catch (DecryptException $e) {
            return('No existe la solicitud');
        }
    }
}
