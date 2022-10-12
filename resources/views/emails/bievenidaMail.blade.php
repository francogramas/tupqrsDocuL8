@component('mail::message')
# Bienvenido a ingenius360.com

Hola {{$user->name}}, recibe esta correo por que ha sido registrado en www.ingenius360.com como líder de depedencia.
al ingregar por primera vez, debe confirmar su cuenta, además debe asignar una nueva contraseña.


@component('mail::button', ['url' => url('forgot-password')])
Asignar contraseña
@endcomponent

Atentamente,<br>
{{ config('app.name') }}
@endcomponent
