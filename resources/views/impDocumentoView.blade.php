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
            @media screen {
                /* Contenido del fichero home.css */            
                .page {
                    /* Styles for better appearance on screens only -- are reset to defaults in print styles later */

                    /* Reflect the paper width in the screen rendering (must match size from @page rule) */
                    width: 21.6cm;
                    /* Reflect the paper height in the screen rendering (must match size from @page rule) */
                    min-height: 27.9cm;

                    /* Reflect the actual page margin/padding on paper in the screen rendering (must match margin from @page rule) */
                    padding-left: 2cm;
                    padding-top: 0.3cm;
                    padding-right: 0.5cm;
                    padding-bottom: 2cm;
                    border: black 1px solid;
                }
            }
        </style>
    </head>

    <body>        
        <object class="w-screen h-screen" data="{{url($url)}}" type="application/pdf">
            <embed src="{{url($url)}}" type="application/pdf" />
        </object>
    </body> 
</html>