<div>
    @if ($etapa==0)
        <div class="grid grid-cols-1 md:grid-cols-5 gap-5">
            <button class="w-full mx-2 my-2 btn btn-primary rounded-lg shadow-lg hover:bg-blue-700" wire:click="siguienteSolictud(1)">Radicar solicitud</button>
        </div>

        <div class="py-2 px-2 ">
            <h1 class="text-lg font-bold">Historial de radicados pendientes por responder</h1>
            <div class="py-2">
                <input type="search" wire:model="param" class="rounded-md shadow-md px-2 w-full" placeholder="Buscar documento radicado" autocomplete="off">
            </div>

            <div class="py-2 gap-4 flex flex-row">
                <div class="flex flex-row cursor-pointer" :active="$filtro==1">
                    <x-jet-nav-link href="#" :active="$filtro==1" wire:click="filtrar(1)">
                        <div class="w-4 h-4 rounded-full bg-success mt-1 mx-1"></div>Activas({{$activas}})
                    </x-jet-nav-link>
                </div>
                <div class="flex flex-row cursor-pointer">
                    <x-jet-nav-link href="#" :active="$filtro==2" wire:click="filtrar(2)">
                        <div class="w-4 h-4 rounded-full bg-warning mt-1 mx-1"></div>Por Vencer({{$pendientes}})
                    </x-jet-nav-link>
                </div>
                <div class="flex flex-row cursor-pointer">
                    <x-jet-nav-link href="#" :active="$filtro==3" wire:click="filtrar(3)">
                        <div class="w-4 h-4 rounded-full bg-error mt-1 mx-1"></div>Vencidas({{$vencidas}})
                    </x-jet-nav-link>
                </div>
                <div class="flex flex-row cursor-pointer">
                    <x-jet-nav-link href="#" :active="$filtro==4" wire:click="filtrar(4)">
                        <div class="w-4 h-4 rounded-full bg-primary mt-1 mx-1"></div>Finalizadas({{$finalizadas}})
                    </x-jet-nav-link>
                </div>
                <div class="flex flex-row cursor-pointer">
                    <x-jet-nav-link href="#" :active="$filtro==0" wire:click="filtrar(0)">
                        <div class="w-4 h-4 rounded-full mt-1 mx-1" ></div> Total({{$total}})
                    </x-jet-nav-link>
                </div>
            </div>

            <div class="py-2">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border border-t-1 border-black font-bold">
                            <td class="px-2"></td>
                            <td class="px-2">Fecha</td>
                            <td class="px-2">Vence</td>
                            <td class="px-2">Dependencia</td>
                            <td class="px-2">Remitente</td>
                            <td class="px-2">Destinatario</td>
                            <td class="px-2">Asunto</td>
                            <td class=""></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($solicitudes as $solicitud)
                        @php
                        if($solicitud->estado_id==1){
                                $clase = 'btn-success';
                            }
                            elseif ($solicitud->estado_id==2) {
                                $clase = 'btn-warning';
                            }
                            elseif ($solicitud->estado_id==3) {
                                $clase = 'btn-error';
                            }
                            elseif ($solicitud->estado_id==4) {
                                $clase = 'btn-error';
                            }
                        @endphp

                        <tr class="border border-t-1 border-black hover:bg-gray-300">
                            <td class="px-2">
                                <div class="w-4 h-4 rounded-full {{$clase}}"></div>
                            </td>
                            <td class="px-2">{{$solicitud->fecha}}</td>
                            <td class="px-2">{{Carbon\Carbon::createFromFormat('Y-m-d', $solicitud->fecha)->addDays($solicitud->diasTermino)->format('Y-m-d')}}</td>
                            <td class="px-2">{{$solicitud->seccionempresa->nombre}}</td>
                            <td class="px-2">{{$solicitud->solicitante->nombrecompleto}}</td>
                            <td class="px-2">{{$solicitud->destinatario}}</td>
                            <td class="px-2">{{Str::limit($solicitud->asunto, 50, '...') }}</td>
                            <td class="flex flex-row">
                                <a href="#" class="text-gray-500" onclick="window.open('{{route('impficha',Crypt::encryptString($solicitud->id))}}','Imprimir Radicado','width=700,height=600')" title="Imprimir Ficha">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z" />
                                    </svg>
                                </a>
                                <a href="#" class="text-gray-500" onclick="window.open('{{route('impradicado',Crypt::encryptString($solicitud->id))}}','Imprimir Radicado','width=600,height=400')" title="Imprimir Radicado">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $solicitudes->links() }}

            </div>
        </div>

    @elseif ($etapa==1)

    <!-- ------------------------------ Formulario de identifcación ----------------------- -->
    <div class="text-gray-700 font-bold text-lg px-2 text-center mb-5">
        <h1>Bienvenido al sistema para gestión de solictudes de {{$empresa->razonsocial}}</h1>
    </div>
    <p class="px-4 py-1">
        Para realizar una solicitud primero debe identificarse, por favor diligencie el formulario:
    </p>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 px-3 py-2">
        <div class="px-2">
            <label for="tipo_documento" class="block text-gray-700 text-sm font-bold">Tipo de documento</label>
            @error('tipo_documento') <span class="text-red-600 block text-xs">{{ $message }}</span> @enderror
            <select wire:model.defer="tipo_documento" id="tipo_documento" class="w-full px-2 py-1 rounded-md shadow-lg">
                @foreach ($tipodocumento as $tipo)
                    <option value="{{$tipo->id}}">{{$tipo->descripcion}}</option>
                @endforeach
            </select>
        </div>
        <div class="px-2">
            <label for="documento" class="block text-gray-700 text-sm font-bold"># de documento</label>
            @error('documento') <span class="text-red-600 block text-xs">{{ $message }}</span> @enderror
            <input id="documento" wire:model="documento" wire:change="buscarSolicitante()" type="number" class="w-full px-2 py-1 rounded-md shadow-lg">
        </div>
        <div class="px-2">
            <label for="nacimiento" class="block text-gray-700 text-sm font-bold">Fecha de nacimiento</label>
            <div class="bg-white rounded-lg shadow-xl w-full border border-black h-9">
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
            <label for="tipo_usuario_id" class="block text-gray-700 text-sm font-bold">Tipo de Solicitante/Remitente</label>
            @error('tipo_usuario_id') <span class="text-red-600 block text-xs">{{ $message }}</span> @enderror
            <select wire:model="tipo_usuario_id" id="tipo_usuario_id" class="w-full px-2 py-1 rounded-md shadow-lg">
                @foreach ($tipo_usuarios as $tipo_usuario)
                    <option value="{{$tipo_usuario->id}}">{{$tipo_usuario->nombre}}</option>
                @endforeach
            </select>
        </div>
        <div class="px-2">
            <label for="nombrecompleto" class="block text-gray-700 text-sm font-bold">Nombre completo</label>
            @error('nombrecompleto') <span class="text-red-600 block text-xs">{{ $message }}</span> @enderror
            <input id="nombrecompleto" wire:model.defer="nombrecompleto" type="text" class="w-full px-2 py-1 rounded-md shadow-lg">
        </div>
        <div class="px-2">
            <label for="telefono" class="block text-gray-700 text-sm font-bold">Celular</label>
            @error('telefono') <span class="text-red-600 block text-xs">{{ $message }}</span> @enderror
            <input id="telefono" wire:model.defer="telefono" type="tel" class="w-full px-2 py-1 rounded-md shadow-lg" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
        </div>
        <div class="px-2">
            <label for="email" class="block text-gray-700 text-sm font-bold">Correo electrónico</label>
            @error('email') <span class="text-red-600 block text-xs">{{ $message }}</span> @enderror
            <input id="email" wire:model.defer="email" type="email" class="w-full px-2 py-1 rounded-md shadow-lg">
        </div>
        <div class="py-1 px-2">
            <label class="block text-gray-700 text-sm font-bold" for="">Departamento</label>
            <select name="estado_id" wire:model="estado_id" wire:change="cargarciudades()" id="" class="w-full px-2 py-1 rounded-md shadow-lg">
                @foreach ($estados as $estado)
                    <option value="{{$estado->id}}">{{$estado->estado}}</option>
                @endforeach
            </select>
        </div>
        <div class="py-1 px-2">
            <label class="block text-gray-700 text-sm font-bold" for="">Ciudad</label>
            @error('ciudad_id') <span class="text-red-600 block text-xs">{{ $message }}</span> @enderror
            <select name="" wire:model="ciudad_id" id="" class="w-full px-2 py-1 rounded-md shadow-lg">
                @foreach ($ciudades as $ciudad)
                    <option value="{{$ciudad->id}}">{{$ciudad->ciudad}}</option>
                @endforeach
            </select>
        </div>
        <div class="py-1 px-2">
            <label for="direccion" class="block text-gray-700 text-sm font-bold">Dirección Completa</label>
            @error('direccion') <span class="text-red-600 block text-xs">{{ $message }}</span> @enderror
            <input id="direccion" wire:model.defer="direccion" type="text" class="w-full px-2 py-1 rounded-md shadow-lg">
        </div>
        <div class="px-2">
            <button id="btnguardar" wire:click="guardarSolicitante()"  class="w-full btn btn-sm mt-5 btn-primary">Continuar</button>
        </div>
    </div>
    @elseif ($etapa==2)
    <!-- ------------------------------ Formulario de Radicación ----------------------- -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-3 px-3 py-2">

        <div>
            <label for="seccion_id" class="block text-gray-700 text-sm font-bold">Secciones</label>
            <select name="" wire:model="seccion_id" wire:change="buscarSerie();" class="w-full px-2 py-1 rounded-md shadow-lg">
                @foreach ($seccion_empresa as $seccioni=>$nombre )
                    <option value="{{$seccioni}}">{{$nombre}}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="tipos_id" class="block text-gray-700 text-sm font-bold">Serie</label>
            <select id="tipos_id" name="" wire:model="serie_id" wire:change = "buscarSubSerie()" class="w-full px-2 py-1 rounded-md shadow-lg">
                @foreach ($series as $serie=>$nombre )
                    <option value="{{$serie}}">{{$nombre}}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="subserie_id" class="block text-gray-700 text-sm font-bold">Subserie</label>
            <select id="subserie_id" name="" wire:model="subserie_id" wire:change = "buscarTipologia()" class="w-full px-2 py-1 rounded-md shadow-lg">
                @foreach ($subserie as $subseri)
                    <option value="{{$subseri->id}}">{{$subseri->nombre}}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="tipologia_id" class="block text-gray-700 text-sm font-bold">Tipología</label>
            <select id="tipologia_id" name="" wire:model="tipologia_id" class="w-full px-2 py-1 rounded-md shadow-lg" wire:change="obtenerDiasTermino();">
                @foreach ($tipologia as $tipologi)
                    <option value="{{$tipologi->id}}">{{$tipologi->nombre}}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="medio_id" class="block text-gray-700 text-sm font-bold">Medio de recepción</label>
            <select name="" id="medio_id" wire:model.defer="medio_id" class="w-full px-2 py-1 rounded-md shadow-lg">
                @foreach ($medio_recepcion as $medio)
                    <option value="{{$medio->id}}">{{$medio->nombre}}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="diasTermino" class="block text-gray-700 text-sm font-bold">Días de término</label>
            <input type="number" wire:model="diasTermino" id="diasTermino" class="w-full px-2 py-1 rounded-md shadow-lg">
        </div>
        <div>
            <label for="fecha" class="block text-gray-700 text-sm font-bold">Fecha</label>
            <input type="date" wire:model.defer="fecha" id="fecha" class="w-full px-2 py-1 rounded-md shadow-lg">
        </div>
        <div>
            <label for="destinatario" class="block text-gray-700 text-sm font-bold">Destinatario</label>
            <input type="text" wire:model.defer="destinatario" id="destinatario" class="w-full px-2 py-1 rounded-md shadow-lg">
        </div>
        <div>
            <label for="folios" class="block text-gray-700 text-sm font-bold">Folios</label>
            <input type="number" wire:model.defer="folios" id="folios" class="w-full px-2 py-1 rounded-md shadow-lg">
        </div>
        <div>
            <label for="anexos" class="block text-gray-700 text-sm font-bold">Anexos</label>
                <input type="number" wire:model.defer="anexos" id="anexos" class="w-full px-2 py-1 rounded-md shadow-lg">
        </div>
        <div class="md:col-span-5">
            <label for="asunto" class="block text-gray-700 text-sm font-bold">Asunto</label>
            @error('asunto') <span class="text-red-600 block text-xs">{{ $message }}</span> @enderror
            <textarea id="asunto" wire:model.defer="asunto" rows="2" class="w-full px-2 py-1 rounded-md shadow-lg"></textarea>
        </div>
        <div class="md:col-span-5">
            <p><input type="checkbox" wire:model.defer="confidencial" class="px-2 py-1 rounded-md shadow-lg"> Marcar como confindencial el Radicado.</p>
            <p><input type="checkbox" wire:model.defer ="respuesta_email" class="px-2 py-1 rounded-md shadow-lg"> ¿Usted autoriza recibir respuesta por medio de correo electrónico?</p>
            <input type="checkbox" wire:model="copia_radicado" class="px-2 py-1 rounded-md shadow-lg"> Copia de radicado a:
            @if ($copia_radicado)
            <select name="" id="seccionCopia_id" wire:model.defer="seccionCopia_id" class="w-full px-2 my-2 rounded-md shadow-lg">
                @foreach ($seccionCopia as $seccion)
                    <option value="{{$seccion->id}}">{{$seccion->nombre}}</option>
                @endforeach
            </select>
            @endif
        </div>
        <div class="md:col-span-5">
            <label for="" class="block text-gray-700 text-sm font-bold">Descripción de adjunto</label>
            <input type="text" wire:model.defer="descripcion" class="w-full px-2 py-1 rounded-md shadow-lg">
        </div>
        <div class="md:col-span-5">
            <label for="" class="block text-gray-700 text-sm font-bold">Adjuntar archivo</label>
            <input class="bg-green-200" type="file" wire:model="adjunto" accept="application/pdf">
        </div>
        <div>
            <button class="w-full btn btn-primary" wire:click="radicar()">Radicar solicitud</button>
        </div>

    </div>
    @elseif ($etapa==3)
    <!-- ------------------------------ Formulario de Impresión y finalización ----------------------- -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 px-3 py-2">
        <div class="px-2 py-1">
        </div>
        <div class="px-2 py-1">
            <a href="#" class="w-full flex flex-row px-2 py-3 btn btn-primary shadow-lg" onclick="window.open('{{route('impradicado',Crypt::encryptString($solicitudi))}}','Imprimir Radicado','width=600,height=400')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                        </svg>
                    Imprimir Radicado
            </a>
        </div>
        <div class="px-2 py-1">
            <a wire:click="finalizarRadicado()" class="w-full flex flex-row px-2 py-3 shadow-lg btn btn-primary" onclick="window.open('{{route('impradicado',Crypt::encryptString($solicitudi))}}','Imprimir Radicado','width=600,height=400')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z" />
                    <path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd" />
                  </svg>
                Finalizar Radicado
            </a>
        </div>
        <div class="px-2 py-1">
        </div>
    </div>
    @endif

</div>
