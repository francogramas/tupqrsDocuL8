<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
                <!-- Fonts -->
                <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
                <!-- Styles -->
                <link rel="stylesheet" href="{{ mix('css/app.css') }}">
                <!-- Scripts -->
                <script src="{{ mix('js/app.js') }}" defer></script>
        <title>Respuesta de radicado</title>
        <style>
            body{
                size: letter;
            }
        </style>
    </head>
    <body class="px-5 py-5" style="width: 8.5in">
        <header>
            <img src="{{$urlLogo}}" alt="" width="240px">
            <p class="font-bold text-lg text-center">{{$s->solicitud->empresa->razonsocial}}</p>
            <p class="pt-7">{{$s->solicitud->empresa->ciudad->ciudad}} - {{$s->solicitud->empresa->ciudad->estado->estado}}, {{ \Carbon\Carbon::parse($s->created_at)->locale('es_CO')->isoFormat('LL')}}</p>
            <br>
            <p>Señor(a):</p>
            <p>{{$s->solicitud->solicitante->nombrecompleto}}</p>
            <br>
            <br>
            <p> <span class="font-bold">Asunto:</span> Respuesta radicado # {{$s->solicitud->radicado}}</p>
            <br>
            <br>
            <br>
            <p>
                En respuesta a la solcitud radicada el/la  {{$s->seccionempresa->nombre}} se permite responderle de la siguiente manera:
            </p>

        </header>
        <section class="py-5">
            {{$s->mensaje}}
        </section>
    </body>
    <footer>
        <p>Atentamente:</p>
        <br>
        <br>
        <br>
        <p>
            <img src="{{$urlFirma}}" alt="" width="180px" class="-my-4">
        </p>
        <p>_____________________________</p>
        <p><span class="text-xs">(firma autorizada)</span></p>
        <p class="font-bold">{{$s->seccionempresa->lider}}</p>
        {{$s->seccionempresa->nombre}}
    </footer>

</html>
