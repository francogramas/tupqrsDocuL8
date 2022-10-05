<?php
use App\Models\Solicitud;
use App\Models\Serie;


function totalSolicitudes($serie, $seccion)
{
    return Solicitud::where('estado_id','<>', 4)
            ->where('serie_id', $serie)
            ->where('seccion_id', $seccion)
            ->count();
}

function totalesSeccionSolicitud($seccion_id, $serie_id, $fechai, $fechaf)
{
    $c=totalesSeccion($seccion_id, $serie_id, $fechai, $fechaf);
    $t=Serie::find($serie_id);
    return view('filatotales')->with('c',$c)->with('t',$t);
}


function totalesSeccion($seccion_id, $serie_id, $fechai, $fechaf)
{
    $c=array();
    $c[]=Solicitud::whereBetween('created_at',[$fechai, $fechaf])
        ->where('seccion_id', $seccion_id)
        ->where('serie_id', $serie_id)
        ->count();

    for ($estado=1; $estado<=4 ; $estado++) {
        $c[]=Solicitud::whereBetween('created_at',[$fechai, $fechaf])
        ->where('seccion_id', $seccion_id)
        ->where('serie_id', $serie_id)
        ->where('estado_id', $estado)
        ->count();
    }
    return $c;
}

function totalSeccionTipo($seccion_id, $serielogia_id, $fechai, $fechaf)
{
    $c=array();
    $c[]=Solicitud::whereBetween('created_at',[$fechai, $fechaf])
        ->where('seccion_id', $seccion_id)
        ->where('tipologia_id', $serielogia_id)
        ->count();

    $c[]=Solicitud::whereBetween('created_at',[$fechai, $fechaf])
        ->where('estado_id', 4)
        ->where('seccion_id', $seccion_id)
        ->where('tipologia_id', $serielogia_id)
        ->count();
    return $c[1].'/'.$c[0];
}

function totalSeccion($seccion_id, $fechai, $fechaf)
{
    $c=array();
    $c[]=Solicitud::whereBetween('created_at',[$fechai, $fechaf])
        ->where('seccion_id', $seccion_id)
        ->count();

    $c[]=Solicitud::whereBetween('created_at',[$fechai, $fechaf])
        ->where('estado_id', 4)
        ->where('seccion_id', $seccion_id)
        ->count();
    return $c[1].'/'.$c[0];
}

function total($fechai, $fechaf)
{

    $c=0;
    $c1=0;
    foreach (Auth::user()->empresa->secciones as $seccion) {
        $c += Solicitud::whereBetween('created_at',[$fechai, $fechaf])
        ->where('seccion_id', $seccion->id)
        ->count();

        $c1 += Solicitud::whereBetween('created_at',[$fechai, $fechaf])
        ->where('estado_id', 4)
        ->where('seccion_id', $seccion->id)
        ->count();
    }

    return $c1.'/'.$c;
}

function solictudesTipo($seccion_id, $serie_id, $fechai, $fechaf)
{
    $t=Serie::find($serie_id);
    $s = Solicitud::whereBetween('created_at',[$fechai, $fechaf])
    ->where('seccion_id', $seccion_id)
    ->where('serie_id', $serie_id)
    ->get();

    return view('solicitudesTipo')
    ->with('t', $t)
    ->with('s', $s);

}

function seguimientoRadicado($solicitud_id)
{
    $s = Solicitud::find($solicitud_id);
    try {
        $seg = $s->seguimiento->first()->id;
    } catch (\Throwable $th) {
        $seg = 0;
    }
    return $seg;

}

function enviarMailResumen()
{
    //TODO: Debe enviar los correos de resumen a los líderes que tengan pendientes por responder, estos mensajes se envían tres veces por semana
}

function actualizarEstadoSolicitudes()
{
    //TODO: Cambiar los estados de las solicitudes de activas->pendientes->vencidas
}
