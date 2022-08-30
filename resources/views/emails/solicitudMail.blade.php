@component('mail::message')
# Hola {{$solicitud->solicitante->nombrecompleto}}

Usted ha realizado una {{$solicitud->tipologia->nombre}} con las siguientes características:

## Empresa:
{{$solicitud->seccionempresa->empresa->razonsocial}}
## Departamento/Sección:
{{$solicitud->seccionempresa->nombre}}
## Fecha/Hora:
{{$solicitud->created_at}}
## Estado de solictud:
{{$solicitud->estado->nombre}}
## Asunto:
{{$seguimiento->asunto}}
## Contenido:
{{$seguimiento->mensaje}}


### Este mensaje se ha generado de forma atutomática, no responda a el.


Atentamente,<br>
# {{ config('app.name') }}
@endcomponent
