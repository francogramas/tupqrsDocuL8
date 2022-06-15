@component('mail::message')
# Bienvenido a tupqrs.com

Hola {{$user->name}}, recibe esta correo por que ha sido registrado en tupqrs.com como líder de depedencia.
al ingregar por primera vez, debe confirmar su cuenta, además debe asignar una nueva contraseña.


@component('mail::button', ['url' => url('forgot-password')])
Asignar contraseña
@endcomponent

Atentamente,<br>
{{ config('app.name') }}
@endcomponent
