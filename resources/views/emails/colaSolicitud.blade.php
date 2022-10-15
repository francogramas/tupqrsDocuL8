@component('mail::message')
# Datos de seguimiento de respuesta
# Solicitante: {{$solicitud->solicitante->nombrecompleto}}

Tipo de solicitud {{$solicitud->tipologia->nombre}}, realizada el {{$solicitud->created_at}} con las siguientes características:

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

## Para dar seguimiento a la respuesta y aprobarla haga click en el siguiente enlace
@component('mail::button', ['url' => url('respsolicitud', Crypt::encryptString($solicitud->id))])
Ver Solicitud
@endcomponent
### Este mensaje se ha generado de forma atutomática, no lo responda.


### {{ config('app.name') }}
@endcomponent

