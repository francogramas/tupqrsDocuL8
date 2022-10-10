<div class="items-center justify-center py-3 grid grid-cols-1">
    <div class="w-full max-w-3xl">
        @if ($etapa == 1)
            <!-- ------------------------------ Formulario de identifcación ----------------------- -->
            <div class="text-gray-700 font-bold text-lg px-2 text-center mb-5">
                <h1>Bienvenido al sistema de encuestas de satisfacción de {{$empresa->razonsocial}}</h1>
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
                    <button id="btnguardar" wire:loading.remove wire:click="guardarSolicitante()"
                    class="w-full max-w-4xl bg-blue-500 py-2 px-2 text-white font-bold text-lg shadow-lg rounded-md">Continuar</button>
                </div>
            </div>
        @endif
        @if ($etapa == 2)
        <p class="px-8 py-1 font-bold text-lg">
            Por favor diligencie la siguiente encuesta.
        </p>
        <div class="grid grid-cols-1 gap-3 px-8 py-2">
            @foreach ($preguntas as $pregunta)
                <div>
                    <span class="font-semibold">{{$pregunta->pregunta}}</span>
                    <ul>
                    @foreach ($pregunta->respuestas as $respuesta)
                        <li>
                            <input wire:click="responder({{$pregunta->id}}, {{$respuesta->id}})" type="radio" name="{{'preg'.$pregunta->id}}" value="{{$respuesta->id}}">  {{$respuesta->respuesta}}
                        </li>
                    @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
        <div class="grid grid-cols-1 gap-3 px-8 py-2">
            <button id="btnguardar" wire:loading.remove wire:click="guardarEncuesta()"
                    class="w-full max-w-4xl bg-blue-500 py-2 px-2 text-white font-bold text-lg shadow-lg rounded-md">Finalizar</button>
        </div>
        @endif
        @if ($etapa == 5)
            <div class="px-5">
                <p class="font-bold text-gray-700 text-lg pb-5">
                    ¡¡Su encuesta fue registrada exitosamente!!
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
                    <button wire:click="nuevaSolicitud()" wire:loading.remove class="my-4 w-full max-w-4xl bg-blue-500 py-2 px-2 text-white font-bold text-lg shadow-lg rounded-md">Realizar nueva encuesta<button>

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
