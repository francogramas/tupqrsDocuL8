<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'ingenius360.com') }}</title>
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        @livewireStyles
        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
        <style>
            @page {
               size: auto;   /* auto is the initial value */
               margin: 0;  /* this affects the margin in the printer settings */
            }
            @media screen {
                /* Contenido del fichero home.css */

            }
            @media print {
                /* Contenido del fichero print.css */
                .ocultar{
                    display:none;
                }

            }
        </style>
        <script type="text/javascript">
            function imprimir() {
              window.print();
            }
          </script>
    </head>

    <body>
        <div class="px-10 py-10">
            <div name="title" class="font-bold text-xl">
                Detalles de Solicitud
            </div>
            <div name="content" class="grid grid-cols-2 gap-1">
                <div class="pt-1">
                    <label class="font-bold">Fecha/hora de Radicado:</label> {{$solicitud->created_at}}
                </div>
                <div class="pt-1">
                    <label class="font-bold">Vence: </label> {{Carbon\Carbon::createFromFormat('Y-m-d', $solicitud->fecha)->addDays($solicitud->diasTermino)->format('Y-m-d')}}
                </div>
                <div class="pt-1">
                    <label class="font-bold">Estado: </label> {{$solicitud->estado->nombre}}
                </div>
                <div class="pt-1">
                    <label class="font-bold">#Radicado: </label> {{$solicitud->radicado}}
                </div>
                <div class="pt-1">
                    <label class="font-bold">Dependencia:</label> {{$solicitud->seccionempresa->nombre}}
                </div>
                <div class="pt-1">
                    <label class="font-bold">Tipo/Serie: </label> {{$solicitud->tipologia->nombre}}
                </div>
                <div class="pt-1">
                    <label class="font-bold">Subserie: </label>{{$solicitud->tipologia->subserie->nombre}}
                </div>
                <div class="pt-1">
                    <label class="font-bold">Tipo: </label>{{$solicitud->tipologia->nombre}}
                </div>
                <div class="pt-1">
                    <label class="font-bold">Medio de recepción: </label> {{$solicitud->medio->nombre}}
                </div>
                <div class="pt-1">
                    <label class="font-bold">Días de término: </label> {{$solicitud->diasTermino}}
                </div>
                <div class="pt-1">
                    <label class="font-bold">Fecha: </label> {{$solicitud->fecha}}
                </div>
                <div class="pt-1">
                    <label class="font-bold">Folios:</label> {{$solicitud->folios}}

                </div>
                <div class="pt-1">
                    <label class="font-bold">Anexos: </label>{{$solicitud->anexos}}
                </div>
                <div class="pt-1">
                    <label class="font-bold">Remitente: </label>{{$solicitud->solicitante->nombrecompleto}}
                </div>
                <div class="pt-1">
                    <label class="font-bold">Destinatario: </label>{{$solicitud->destinatario}}
                </div>
                <div class="pt-2 col-span-2">
                    <label class="font-bold">Asunto: </label> {{$solicitud->asunto}}
                </div>
                <div class="pt-2 col-span-2">
                    <h1 class="text-sm font-bold">Historial de la solicitud</h1>
                    @foreach ($solicitud->seguimiento as $seguimiento)
                        <li class="text-sm">
                            <div class="">
                                {{$seguimiento->created_at->format('M d/Y').' -> '. $seguimiento->accion->nombre}}
                            </div>
                            @if ($seguimiento->mensaje)
                            <div>
                                {!!'<span class="font-semibold text-gray-800"> Mensaje</span> -> '. $seguimiento->mensaje!!}
                            </div>
                            @endif
                            @if ($seguimiento->observaciones)
                            <div>
                                {!!'<span class="font-semibold text-gray-800"> Observaciones</span> -> '. $seguimiento->observaciones!!}
                            </div>
                            @endif
                            @if ($seguimiento->adjunto)
                            <div>
                                <a class="font-bold mt-2  flex " href="{{route('impdocumento',Crypt::encryptString($seguimiento->id))}}" target="_blank">
                                    Documento adjunto: <button class="bg-blue-300 text-gray-800 font-bold mx-2 px-2 py-1 flex rounded">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                            </svg>
                                            Ver
                                    </button>
                                </a>
                            </div>
                            @endif
                        </li>
                    @endforeach
                </div>
            </div>
            <div class="mt-4">
                <a href="#" onclick="imprimir()" class="px-2 py-1 bg-blue-600 text-white ocultar text-base w-full">
                    Imprimir Ficha</a>
            </div>
        </div>

    </body>
</html>
