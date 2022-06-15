@component('mail::message')
 

{{$mailEmpresa->mensaje}}


Atentamente,<br>

Equipo de trabajo
{{ config('app.name') }}

** Este mensaje es generado de forma autmática, por favor no responda a el.
@endcomponent
