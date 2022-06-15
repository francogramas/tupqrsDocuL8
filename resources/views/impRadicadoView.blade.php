<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'tupqrs.co') }}</title>
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

    <body class="">
        <div class="w-full px-3 py-3 text-xs">      
            <h1 class="-mt-0 font-bold">{{$solicitud->empresa->razonsocial}}</h1>             
            <div class="">
                <img src="data:image/png;base64,{!! DNS1D::getBarcodePNG($solicitud->radicado, 'CODABAR', 3,33) !!}" alt="">
            </div>
            <div>                
                <h1 class="-mt-0 font-bold">Rad #: {{$solicitud->radicado}}  Folios: {{$solicitud->folios}}   Anexos: {{$solicitud->anexos}} </h1> 
                <h1 class="-mt-1">Fecha: {{$solicitud->created_at}} Usu: {{Str::limit($solicitud->user->name, 10, '...') }}</h1>
                <h1 class="-mt-1">Destino: {{$solicitud->seccionempresa->nombre}} </h1>
                <h1 class="-mt-1">Destinatario: {{$solicitud->destinatario}} </h1>
                <h1 class="-mt-1">Remitente: {{$solicitud->solicitante->nombrecompleto}} </h1>
                <h1 class="-mt-1 font-bold">Asunto: {{Str::limit($solicitud->asunto,40)}} </h1>    
                @if ($solicitud->copia)<h1 class="-mt-1">CC: {{$solicitud->copia->seccion->nombre}}</h1>@endif            
                @if ($solicitud->confidencial)<h1 class="-mt-1 font-bold text-red-800 text-lg">CONFIDENCIAL</h1>@endif            
            </div>
            <div class="mt-4">
                <a href="#" onclick="imprimir()" class="px-2 py-1 bg-blue-600 text-white ocultar text-base w-full">
                    Imprimir radicado</a>                
            </div>                            
        </div>
        
    </body>
</html>