<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>
    <div class="text-center pt-16">
        <div class="visible-print text-center">
            <div class="text-center font-bold text-3xl" >
                Para radicar  Peticiones, Quejas, Reclamos, Sugerencias o Felicitaciones, escanea el código
            </div>
            <div class="pt-10 max-w-2xl object-none object-center pl-36">
                {!! QrCode::size(400)->generate(url('h?e='.$url)) !!}
            </div>
            <div class="pt-5">Tu opinión es importante para nosotros. Ayúdanos a prestarte un mejor servicio</div>

            <div class="text-right pr-10 pt-2">
                www.ingenius360.com
            </div>
        </div>
        <div>

        </div>
    </div>
</body>
</html>
