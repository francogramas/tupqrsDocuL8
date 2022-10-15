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

            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 md:mt-3">

                <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <div class="p-3 md:p-6 mt-3 md:mt-6">
                            <div class="items-center">
                                <div class="text-3xl lg:text-5xl leading-7 font-semibold">
                                    <h3 class="text-gray-900 dark:text-white">Bienvenido a<a href=""></a></h3>
                                    <h3 class="text-gray-900 dark:text-white font-bold pt-3">ingenius360.com</h3>
                                </div>
                                <div class="pb-5 pt-5 text-contenido text-sm lg:text-lg">
                                    <div class="mt-2 text-gray-600 dark:text-gray-400">
                                        Este es un espacio diseñado para ayudarte a manejar las solicitudes de peticiones, quejas, reclamos, sugerencias y felicitaciones de tu empresa, desde la comodidad de tu equipo preferido, online, dinámico y en tiempo real.
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 pt-2">
                                    <a href="{{ route('login') }}" class="btn mx-3 mt-3 font-extrabold">Inicia Sesión</a>
                                    <a href="{{ route('register') }}" class="btn mx-3 mt-3 font-extrabold bg-white text-titulo hover:text-contenido">Registrate</a>
                                </div>
                            </div>
                        </div>
                        <div class="relative top-10 right-10 w-10/12 ">
                            <div class="ml-12 pb-3 -mt-10 -mr-24">
                                <img class="hidden md:block " src="/src/img/banner_home.svg" alt="" class="w-full">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg md:-mt-10">
                    <div class="grid grid-cols-1 md:grid-cols-3">
                        <div class="">
                            <div class="ml-12 flex">
                                <div class="w-12">
                                    <img src="/src/img/1.svg" alt="">
                                </div>
                                <div class="-ml-5 mt-4 text-gray-600 dark:text-gray-400 text-md text-2xl font-extrabold">
                                   <a class="font-bold" href="{{route('register')}}">Registrate</a>
                                </div>
                            </div>
                            <div>
                                <img src="/src/img/registrate.svg" alt="" class="max-h-60">
                            </div>
                            <div class="px-3 text-contenido">
                                Crea tu buzón virtual con sus dependencias y colaboradores, todo este proceso no tomará mas de 10 minutos.
                            </div>
                        </div>
                        <div class="">
                            <div class="ml-12 flex items-center">
                                <div class="w-12">
                                    <img src="/src/img/2.svg" alt="" >
                                </div>
                                <div class="-ml-5 text-gray-600 dark:text-gray-400 text-md text-2xl font-extrabold">
                                   <a class="font-bold" href="{{route('register')}}">Comparte</a>
                                </div>
                            </div>
                            <div>
                                <img src="/src/img/comparte.svg" alt="" class="max-h-60">
                            </div>
                            <div class="pb-3 mt-8">
                                <div class="px-3 mt-2 text-contenido dark:text-gray-400 text-md">
                                    Comparte el link de tu buzón por los medios digitales, página web, redes sociales, o código QR.
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="ml-12 flex items-center">
                                <div class="w-12">
                                    <img src="/src/img/3.svg" alt="">
                                </div>
                                <div class="-ml-5 text-gray-600 dark:text-gray-400 text-md text-2xl font-extrabold">
                                   <a class="font-bold" href="{{route('register')}}">Analiza</a>
                                </div>
                            </div>
                            <div>
                                <img src="/src/img/seguimiento.svg" alt="" class="max-h-60">
                            </div>
                            <div class="pb-3 mt-8">
                                <div class="px-3 mt-2 text-contenido dark:text-gray-400 text-md">
                                    Haga seguimientos y análisis de las solicitudes gestionadas para un proceso de mejora continua.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <footer class="w-full bg-morado text-white py-4 px-3 md:px-10">
            <div class="">
                <div class="">
                    <img src="/src/img/logoBlanco.svg" alt="">
                </div>
            </div>
            <div class="">
                www.ingenius360.co, todos los derechos reservados ©2020 - <?php echo date('Y'); ?>
            </div>
        </footer>
    </body>
</html>
