<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'ingenius360.com') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased text-titulo">
        <form method="POST" action="{{ url('respsolicitud',Crypt::encryptString($cola->salida->seguimiento->last()->id)) }}">
            @csrf
            <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">

                    @if (Route::has('login'))
                        <div class="fixed top-0 left-0 px-6 py-2 sm:block w-full md:w-auto bg-white md:bg-transparent text-right">
                            <div class="flex items-center">
                                <img src="/src/img/logo.svg" alt="" class="w-36 md:w-48">
                            </div>
                        </div>
                        <div class="fixed top-0 right-0 px-6 py-6 sm:block w-full  md:w-auto md:bg-transparent text-right">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-sm text-gray-800 underline">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm text-gray-800 underline">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-800 underline">Registro</a>
                                @endif
                            @endauth
                        </div>
                    @endif

                <div class="w-full mx-auto sm:px-6 lg:px-8 md:mt-3 px-6">

                    <div class="dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg md:-mt-10">
                        <div class="">
                            <div class="mt-3">
                                <p>
                                    <span class="font-bold">Solicitante:</span> {{$solicitud->solicitante->nombrecompleto}}</p>

                                <p>
                                    {{$solicitud->tipologia->nombre}} <span class="font-bold">Fecha: </span>{{$solicitud->created_at}}
                                </p>

                                <p>
                                    <span class="font-bold">Empresa:</span> {{$solicitud->seccionempresa->empresa->razonsocial}}
                                </p>
                                <p>
                                    <span class="font-bold">Departamento/Sección:</span>
                                    {{$solicitud->seccionempresa->nombre}}
                                </p>
                                <p>
                                    <span class="font-bold">Estado de solictud:</span> {{$solicitud->estado->nombre}}
                                </p>
                                <p>
                                    <span class="font-bold">Asunto: </span>{{$solicitud->asunto}}
                                </p>
                                <p>
                                    <span class="font-bold">No de Radicado: </span>{{$solicitud->radicado}}
                                </p>
                                <p>
                                    <h1 class="font-bold">Contenido:</h1>
                                    @foreach ($solicitud->seguimiento as $seguimiento)
                                        {{$seguimiento->created_at->format('M d/Y').' -'.$seguimiento->accion->nombre}}

                                        @if ($seguimiento->mensaje and !$loop->last)
                                        <br>
                                            {{'Mensaje - '. $seguimiento->mensaje}}
                                        @endif
                                        @if ($seguimiento->observaciones)
                                        <br>
                                            {{'Observaciones - '. $seguimiento->observaciones}}
                                        @endif
                                        @if ($seguimiento->observaciones)
                                        <br>
                                        <span class="font-bold">Adjuntos</span>
                                        @endif

                                    @endforeach

                                </p>
                                <p>
                                    Auxiliar: {{$solicitud->seccionempresa->userSeccion->user->name}}
                                </p>
                            </div>
                            <div class="mt-3">

                            </div>
                            <div class="mt-3">
                                <h1 class="font-bold">Respuesta</h1>
                                <textarea name="respuesta" id="" class="w-full" rows="10">{{$cola->salida->seguimiento->last()->mensaje}}</textarea>
                            </div>
                            <div class="mt-3 ">
                                <button class="btn btn-primary">Responder</button>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </form>
        <footer class="w-full bg-morado text-white py-4 px-3 md:px-10">
            <div class="">
                <div class="">
                    <img src="/src/img/logoBlanco.svg" alt="">
                </div>
            </div>
            <div class="">
                ingenius360.com, todos los derechos reservados ©2020 - <?php echo date('Y'); ?>
            </div>
        </footer>
    </body>
</html>
