@component('mail::message')
# Hola {{$solicitud->solicitante->nombrecompleto}}

usted ha recibido una respuesta a la {{$solicitud->tipologia->nombre}} realizada el {{$solicitud->created_at}} con las siguientes características:

## Empresa:
{{$solicitud->seccionempresa->empresa->razonsocial}}

## Departamento/Sección:
{{$solicitud->seccionempresa->nombre}}

Estado de solictud: {{$solicitud->estado->nombre}}
Asunto: {{$solicitud->adjunto}}
No de Radicado: {{$solicitud->radicado}}

## Contenido:
@foreach ($solicitud->seguimiento as $seguimiento)
    {{$seguimiento->created_at->format('M d/Y').' -'.$seguimiento->accion->nombre}}
@if ($seguimiento->mensaje)
    {{'Mensaje - '. $seguimiento->mensaje}}
@endif
@if ($seguimiento->observaciones)
    {{'Observaciones - '. $seguimiento->observaciones}}
@endif
@endforeach

Atentamente: {{$solicitud->seccionempresa->userSeccion->user->name}}
Líder de {{$solicitud->seccionempresa->nombre}}

@component('mail::button', ['url' => url('impoficio', Crypt::encryptString($seguimiento->id))])
Ver Respuesta
@endcomponent

### Este mensaje se ha generado de forma atutomática, no lo responda.



### {{ config('app.name') }}
@endcomponent

