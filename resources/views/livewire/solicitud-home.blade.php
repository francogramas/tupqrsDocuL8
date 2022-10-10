<div class="items-center justify-center py-3 grid grid-cols-1 md:grid-cols-4">
    <div></div>
    <div class="col-span-2">
        <div class="w-full max-w-3xl">
            @if ($etapa == 1)
                <!-- ------------------------------ Formulario de identifcación ----------------------- -->
                <div class="text-gray-700 font-bold text-lg px-2 text-center mb-5">
                    <h1>Bienvenido al sistema para gestión de solictudes de {{$empresa->razonsocial}}</h1>
                </div>
                <p class="px-4 py-1">
                    Para realizar una solicitud primero debe identificarse, por favor diligencie el formulario:
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 px-3 py-2">
                    <div class="px-2">
                        <label for="tipo_documento" class="block text-gray-700 text-sm font-bold">Tipo de documento</label>
                        @error('tipo_documento') <span class="text-error  block text-xs">{{ $message }}</span> @enderror
                        <select wire:model="tipo_documento" id="tipo_documento" class="w-full px-2- py-1 rounded-md shadow-lg">
                            @foreach ($tipodocumento as $tipo)
                                <option value="{{$tipo->id}}">{{$tipo->descripcion}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="px-2">
                        <label for="documento" class="block text-gray-700 text-sm font-bold"># de documento</label>
                        @error('documento') <span class="text-error  block text-xs">{{ $message }}</span> @enderror
                        <input id="documento" wire:model="documento" wire:change="buscarSolicitante()" type="number" class="w-full px-2- py-1 rounded-md shadow-lg">
                    </div>

                    <div class="px-2">
                        <label for="nacimiento" class="block text-gray-700 text-sm font-bold">Fecha de nacimiento</label>
                        <div class="rounded-lg shadow-xl w-full border border-black h-9">
                            <div class="flex">
                                <select wire:model="ano" wire:change="crearFecha()" class="bg-transparent border-transparent" style="background-image: none">
                                @foreach ($anos as $anoi)
                                    <option value="{{$anoi}}">{{$anoi}}</option>
                                @endforeach
                                </select>
                                <span class="mr-2 mt-2">/</span>
                                <select wire:model="mes" wire:change="crearFecha()" class="bg-transparent border-transparent" style="background-image: none">
                                <option value="1">ENE</option>
                                <option value="2">FEB</option>
                                <option value="3">MAR</option>
                                <option value="4">ABR</option>
                                <option value="5">MAY</option>
                                <option value="6">JUN</option>
                                <option value="7">JUL</option>
                                <option value="8">AGO</option>
                                <option value="9">SEP</option>
                                <option value="10">OCT</option>
                                <option value="11">NOV</option>
                                <option value="12">DIC</option>
                                </select>
                                <span class="mr-2 mt-2">/</span>
                                <select select wire:model="dia" wire:change="buscarSolicitante()" class="bg-transparent border-transparent" style="background-image: none">
                                    @foreach ($dias as $diai)
                                    <option value="{{$diai}}">{{$diai}}</option>
                                    @endforeach
                                </select>
                            </div>
                            </div>
                    </div>

                    <div class="px-2">
                        <label for="nombrecompleto" class="block text-gray-700 text-sm font-bold">Nombre completo</label>
                        @error('nombrecompleto') <span class="text-error  block text-xs">{{ $message }}</span> @enderror
                        <input id="nombrecompleto" wire:model.defer="nombrecompleto" type="text" class="w-full px-2- py-1 rounded-md shadow-lg">
                    </div>
                    <div class="px-2">
                        <label for="telefono" class="block text-gray-700 text-sm font-bold">Celular</label>
                        @error('telefono') <span class="text-error  block text-xs">{{ $message }}</span> @enderror
                        <input id="telefono" wire:model.defer="telefono" type="tel" class="w-full px-2- py-1 rounded-md shadow-lg" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
                    </div>
                    <div class="px-2">
                        <label for="email" class="block text-gray-700 text-sm font-bold">Correo electrónico</label>
                        @error('email') <span class="text-error  block text-xs">{{ $message }}</span> @enderror
                        <input id="email" wire:model.defer="email" type="email" class="w-full px-2- py-1 rounded-md shadow-lg">
                    </div>
                    <div class="px-2">
                        <button id="btnguardar" wire:loading.remove wire:click="guardarSolicitante()"  class="w-full max-w-4xl bg-blue-500 py-2 px-2 text-white font-bold text-lg shadow-lg rounded-md">Continuar</button>
                    </div>
                </div>
            @endif

            @if ($etapa == 2)
                <!-- ------------------------------ Tipo de solicitud --------------------------------- -->
                <div class="text-gray-700 font-bold px-2 text-center mb-5 min-w-full">
                    <h1>Bienvenido {{$solicitante->nombrecompleto}}, ¿Qué tipo de solicitud desea realizar?</h1>
                </div>
                @foreach ($tiposolicitud as $tipo)
                    <div class="px-3 py-3">
                        <button wire:click="tipoSolicitud({{$tipo->id}})"  class="w-full max-w-4xl bg-blue-500 py-2 px-2 text-white font-bold text-lg shadow-lg rounded-md">
                            {{$tipo->nombre}}
                        </button>
                    </div>
                @endforeach
            @endif
            @if ($etapa == 3)
                <!-- ------------------------------ Departamento donde radica  ------------------------ -->
                <div class="text-gray-700 font-bold px-2 text-center mb-5">
                    ¿A que departamento desea dirigir la solicitud?
                </div>
                @foreach ($empresa->secciones->where('publica', 1) as $seccion)
                    <div class="px-3 py-3">
                        <button  wire:click="seccionSolicitud({{$seccion->id}})" class="w-full max-w-4xl bg-blue-500 py-2 px-2 text-white font-bold text-lg shadow-lg rounded-md">
                            {{$seccion->nombre}}
                        </button>
                    </div>
                @endforeach
            @endif
            @if ($etapa == 4)
                <form wire:submit.prevent="enviarSolicitud()" class="px-5">
                    <!-- ------------------------------ descripción de solicitud  ------------------------- -->
                    <div class="">
                        <label for="" class="block text-gray-700 text-sm font-bold">Asunto de solicitud</label>
                        @error('asunto') <span class="text-error  block text-xs">{{ $message }}</span> @enderror
                        <input type="text" wire:model.defer="asunto" class="mt-2 rounded-lg resize-none w-full h-full border shadow-lg px-2 py-2" placeholder="Asunto">
                    </div>
                    <div class="">
                        <label for="" class="block text-gray-700 text-sm font-bold">Descripción de la solicitud</label>
                        @error('solicitud') <span class="text-error  block text-xs">{{ $message }}</span> @enderror
                        <textarea wire:model.defer="solicitud" class="mt-2 rounded-lg resize-none w-full h-full border shadow-lg px-2 py-2" rows="15" placeholder="Describa la solicitud que desea enviar a nuestra empresa"></textarea>
                    </div>
                    <div>
                        <label for="" class="block text-gray-700 text-sm font-bold">Adjuntar archivo</label>
                        <input class="bg-green-200" type="file" accept="application/pdf" wire:model="adjunto">
                        @error('adjunto') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="confidencial" class="block text-gray-700 text-sm font-bold">¿Tratar como confidencial?</label>
                        <select wire:model.defer="confidencial" id="confidencial" class="px-2- py-1 rounded-md shadow-lg">
                            <option value="0" selected>No</option>
                            <option value="1">Si</option>
                        </select>
                        @error('confidencial') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="">
                        <button wire:loading.remove class="my-4 w-full max-w-4xl bg-blue-500 py-2 px-2 text-white font-bold text-lg shadow-lg rounded-md">Enviar Solicitud</button>
                    </div>
                </form>
            @endif
            @if ($etapa == 5)
                <div class="px-5">
                    <p class="font-bold text-gray-700 text-lg pb-5">
                        ¡¡Su solicitud fue radicada exitosamente!!
                    </p>
                    <p class="pb-7">
                        Se envío un mensaje a su correo electrónico con los detalles de la misma.
                        Nuestro equipo de trabajo tramitará su solicitud, y le hará llegar una respuesta en poco tiempo.
                    </p>
                    <p class="pb-7">
                        Agradecemos sus aportes para ayudarnos a mejorar continuamente.
                    </p>
                    <p class="pb-7">
                        Atentamente,
                    </p>
                    <p>
                        <span class="font-bold text-gray-700 text-lg">{{$empresa->razonsocial}}</span>, equipo de trabajo
                    </p>
                    <p>
                        <button wire:click="nuevaSolicitud()" wire:loading.remove class="my-4 w-full max-w-4xl bg-blue-500 py-2 px-2 text-white font-bold text-lg shadow-lg rounded-md">Radicar nueva solicitud<button>

                    </p>
                </div>
            @endif

        </div>
        <button wire:loading.delay class="px-4 py-2 flex">
                <svg class="animate-spin -ml-1 mr-3 h-7 w-7 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            <div class="-mt-7 -ml-10">
                Procesando, por favor espere...
            </div>
        </button>
        <!-- ------------------------------ Modal 1: Advertencia, usuario corresponde a otra empresa ---------------------- -->
        <x-jet-confirmation-modal wire:model="modalFormVisible" >
            <x-slot name="title">
                ADVERTENCIA
            </x-slot>

            <x-slot name="content">
                {{$mensaje}}
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button  wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                    Cerrar
                </x-jet-secondary-button>
            </x-slot>
        </x-jet-confirmation-modal>
    </div>
    <div></div>

</div>
