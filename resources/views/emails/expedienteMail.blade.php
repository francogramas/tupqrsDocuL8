@component('mail::message')
# Se ha actualizado el expediente # {{$detalle->expediente->numero}}

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
