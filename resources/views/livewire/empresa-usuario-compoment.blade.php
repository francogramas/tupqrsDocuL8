<section class="px-5 pt-5" x-data="{ ver: true, ver1: true }">
    <h3 class="text-2xl">Administrar Empresa</h3>
    @if ($countempresa==0)
    <section class="grid grid-cols-1 md:grid-cols-3 md:gap-2">
        <div class="grid grid-cols-1 md:grid-cols-2 md:gap-1 text-sm border-morado border-2 px-3 py-3 shadow-md rounded-x">
            <div class="py-1 px-2">
                <label class="font-bold" for="">Nit</label>
                @error('nit') <span class="text-error  block text-xs">{{ $message }}</span> @enderror
                <input type="text" wire:model.defer="nit" class="w-full px-2 py-1 rounded-md border-morado" required>
            </div>
            <div class="py-1 px-2">
                <label class="font-bold" for="">Razón Social</label>
                @error('razonsocial') <span class="text-error  block text-xs">{{ $message }}</span> @enderror
                <input type="text" wire:model.defer="razonsocial" class="w-full px-2 py-1 rounded-md border-morado" required>
            </div>
            <div class="py-1 px-2">
                <label class="font-bold" for="">Teléfono</label>
                @error('telefono') <span class="text-error  block text-xs">{{ $message }}</span> @enderror
                <input type="text" wire:model.defer="telefono" class="w-full px-2 py-1 rounded-md border-morado" required>
            </div>
            <div class="py-1 px-2">
                <label class="font-bold" for="">Email</label>
                @error('email') <span class="text-error  block text-xs">{{ $message }}</span> @enderror
                <input type="email" wire:model.defer="email" class="w-full px-2 py-1 rounded-md border-morado" required>
            </div>
            <div class="py-1 px-2">
                <label class="font-bold" for="">Departamento</label>
                <select name="estado_id" wire:model.defer="estado_id" wire:change="cargarciudades()" id="" class="w-full px-2 py-1 rounded-md">
                    @foreach ($estados as $estado)
                        <option value="{{$estado->id}}">{{$estado->estado}}</option>
                    @endforeach
                </select>
            </div>
            <div class="py-1 px-2">
                <label class="font-bold" for="">Ciudad</label>
                @error('ciudad_id') <span class="text-error  block text-xs">{{ $message }}</span> @enderror
                <select name="" wire:model="ciudad_id" id="" class="w-full px-2 py-1 rounded-md">
                    @foreach ($ciudades as $ciudad)
                        <option value="{{$ciudad->id}}">{{$ciudad->ciudad}}</option>
                    @endforeach
                </select>
            </div>
            <div class="py-1 px-2">
                <label class="font-bold" for="">Dirección</label>
                @error('direccion') <span class="text-error  block text-xs">{{ $message }}</span> @enderror
                <input wire:model="direccion" type="text" class="w-full px-2 py-1 rounded-md border-morado" required>
            </div>
            <div class="py-1 px-2 md:py-6">
                @if ($boolguardar)
                    <input type="submit" wire:click="store" class="w-full px-2 py-2 btn btn-primary" value="Guardar">
                @else
                    <input type="submit" wire:click="update()" class="w-full px-2 py-2 btn btn-primary" value="Actualizar">
                @endif
            </div>
        </div>
    </section>
    @else

    <section class="text-sm border-morado border-2 px-3 py-3 shadow-md rounded-xl">
        <section class="flex flex-wrap">
            <div class="flex-initial px-2 py-1">
                <label for="" class="font-bold block">Nit:</label>
                {{$empresa->nit}}
            </div>
            <div class="flex-initial px-2 py-1">
                <label for="" class="font-bold block">Razón Social:</label>
                {{$empresa->razonsocial}}
            </div>
            <div class="flex-initial px-2 py-1">
                <label for="" class="font-bold block">Email:</label>
                {{$empresa->email}}
            </div>
            <div class="flex-initial px-2 py-1">
                <label for="" class="font-bold block">Teléfono:</label>
                {{$empresa->telefono}}
            </div>
            <div class="flex-initial px-2 py-1">
                <label for="" class="font-bold block">Link de acceso:</label>
                <a href="{{url('h?e='.$empresa->url)}}">{{url('h?e='.$empresa->url)}}</a>
                <a target="_blank" href="{{url('qrcode',$empresa->url)}}">
                    <button class="ml-2 px-1 py-1 bg-green-400 rounded-lg hover:bg-green-800 text-gray-100 font-bold" title="Generar código QR">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                        </svg>
                    </button>
                </a>
                <input type="hidden" id="urlecrypt" value="{{url('h?e='.$empresa->url)}}">
                <button class="ml-2 px-1 py-1 bg-green-400 rounded-lg hover:bg-green-800 text-gray-100 font-bold" title="Copiar URL" onclick="CopyToClipboard('urlecrypt')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                    </svg>
                </button>
            </div>
            <div class="flex-initial px-2 py-1">
                <label for="" class="font-bold block"><br></label>
                <a href="#" wire:click = "edit();">Editar</a>
            </div>
        </section>

        <section class="">
            <div class="py-2 px-2">
                <label for="" class="font-bold block">Crear dependencia:</label>
                <div class="flex">
                    <div class="w-5/12 mr-3 py-1">
                        <input class=" rounded-md border-morado shadow-md w-full" type="text" wire:model.defer="dependencia" required placeholder="Nombre de Sección/Dependencia">
                        @error('dependencia') <span class="text-error  block text-xs">{{ '*'.$message }}</span> @enderror
                    </div>
                    <div class="w-1/12 mr-3 py-1">
                        <input class=" rounded-md border-morado shadow-md w-full" type="text" wire:model.defer="codigo" required placeholder="Código">
                        @error('codigo') <span class="text-error  block text-xs">{{ '*'.$message }}</span> @enderror
                    </div>
                    <div class="w-3/12 mr-3 py-1">
                        <input class=" rounded-md border-morado shadow-md w-full" type="text" wire:model.defer="lider" required placeholder="Jefe de la oificia">
                        @error('lider') <span class="text-error  block text-xs">{{ '*'.$message }}</span> @enderror
                    </div>
                    <div class="w-3/12 mr-3 py-1">
                        <input class=" rounded-md border-morado shadow-md w-full" type="email" wire:model.defer="emailjefe" required placeholder="Email de Jefe">
                        @error('emailjefe') <span class="text-error  block text-xs">{{ '*'.$message }}</span> @enderror
                    </div>




                </div>
            <div class="py-2 flex">
                <select name="publica" wire:model="publica" class="w-1/4 mr-3 px-2 py-1 rounded-md  select select-bordered max-w-xs">
                    <option value="1" selected>Pública</option>
                    <option value="0">Oculta</option>
                </select>
                <div class="w-3/12 mr-3 px-2 py-1 rounded-md shadow-md">
                    <label for="">Firma</label>
                    <input type="file" wire:model="firma" accept="image/*">
                    <img src="{{asset('/storage/'.$urlFirma)}}" alt="" width="100">
                </div>
                    @if ($boolguardarDep)
                        <button wire:click="crearDependencia()" class=" shadow-md rounded-lg btn btn-primary" title="Crear dependencia">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                        </button>
                    @else
                        <button wire:click="updateDependencia({{$dependencia_id}})" class="shadow-md rounded-lg btn btn-primary" title="Actualizar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                        </button>
                    @endif

            </div>
            <div class="px-2 overflow-x-auto">
                <div class="shadow overflow-hidden border border-morado rounded-lg">
                <table class="w-full table table-compact">
                    <thead class="font-bold uppercase">
                        <tr class="my-2 text-left border h-8">
                            <th class="pl-2">Dependencia</th>
                            <th class="pl-2">Líder</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($empresa->secciones as $seccion)
                            <tr class="border h-8">
                                <td class="py-1 pl-2">{{$seccion->nombre}}</td>
                                <td>
                                    @if ($seccion->userSeccion)
                                        {{$seccion->userSeccion->user->name}}
                                    @endif
                                </td>
                                <td class="text-right py-1 pl-2">
                                    <button wire:click="adminUsuario({{$seccion->id}})" class="rounded-md text-purple-500 font-bold" title="Agregar lider" >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                            </svg>
                                    </button>
                                    <button wire:click="editDependencia({{$seccion->id}})" class="rounded-md text-green-500 font-bold" title="Editar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <button wire:click="confirmarBorrarDependencia({{$seccion->id}})" class="rounded-md text-error  font-bold" title="Eliminar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>

        </section>
    </section>
    @endif




<!-- ------------------------------ Modal 1: Borrar dependencia ---------------------------------------- -->
    <x-jet-confirmation-modal wire:model="modalFormVisible" >
        <x-slot name="title">
            BORRAR DEPENDENCIA
        </x-slot>

        <x-slot name="content">
            ¿Realmente desea elimininar la dependencia?
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                No
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2 btn btn-error" wire:click="deleteDependencia()" wire:loading.attr="disabled">
                Borrar Dependencia
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>

    <!-- ------------------------------ Modal 2: Asignar lider de dependencia ---------------------------------------- -->
    <x-jet-dialog-modal wire:model="modalFormVisible1" >
        <x-slot name="title">
            ASIGNAR AUXILIAR
        </x-slot>

        <x-slot name="content">
                <div class="pt-2">
                    <x-jet-label for="" value="Email" autocomplete="off" />
                    @error('userEmail') <span class="text-error  block text-xs">{{ $message }}</span> @enderror
                    <x-jet-input wire:model.defer="userEmail"  wire:change="revisarEmail()" class="block mt-1 w-full" type="text" />
                </div>
                <div class="pt-2">
                    <x-jet-label for=""  value="Nombre completo" autocomplete="off"/>
                    @error('userName') <span class="text-error  block text-xs">{{ $message }}</span> @enderror
                    <x-jet-input wire:model.defer="userName" class="block mt-1 w-full" type="text" />
                </div>
                <div class="pt-2 relative">
                    <x-jet-label for="" value="Contraseña" />
                    @error('password') <span class="text-error  block text-xs">{{ $message }}</span> @enderror
                    <input id="password" wire:model.defer="password" required autocomplete="current-password" placeholder="" :type="ver ? 'password' : 'text'" class="text-md block px-3 py-2 rounded-lg w-full
                    bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md
                    focus:placeholder-gray-500
                    focus:bg-white
                    focus:border-gray-600
                    focus:outline-none">
                    <div class="absolute top-10 right-3 flex items-center text-sm leading-5 z-10">
                        <svg class="h-6 text-gray-700" fill="none" @click="ver = !ver"
                          :class="{'hidden': !ver, 'block':ver }" xmlns="http://www.w3.org/2000/svg"
                          viewbox="0 0 576 512">
                          <path fill="currentColor"
                            d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z">
                          </path>
                        </svg>

                        <svg class="h-6 text-gray-700" fill="none" @click="ver = !ver"
                          :class="{'block': !ver, 'hidden':ver }" xmlns="http://www.w3.org/2000/svg"
                          viewbox="0 0 640 512">
                          <path fill="currentColor"
                            d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z">
                          </path>
                        </svg>
                </div>
                <div class="pt-2 relative">
                    <x-jet-label for="" value="Confirmar contraseña" />
                    <input id="password_confirmation" wire:model.defer="password_confirmation" required autocomplete="current-password" placeholder="" :type="ver1 ? 'password' : 'text'" class="text-md block px-3 py-2 rounded-lg w-full
                    bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md
                    focus:placeholder-gray-500
                    focus:bg-white
                    focus:border-gray-600
                    focus:outline-none">
                    <div class="absolute top-10 right-3 flex items-center text-sm leading-5 z-10">
                        <svg class="h-6 text-gray-700" fill="none" @click="ver1 = !ver1"
                          :class="{'hidden': !ver1, 'block':ver1 }" xmlns="http://www.w3.org/2000/svg"
                          viewbox="0 0 576 512">
                          <path fill="currentColor"
                            d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z">
                          </path>
                        </svg>

                        <svg class="h-6 text-gray-700" fill="none" @click="ver1 = !ver1"
                          :class="{'block': !ver1, 'hidden':ver1 }" xmlns="http://www.w3.org/2000/svg"
                          viewbox="0 0 640 512">
                          <path fill="currentColor"
                            d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z">
                          </path>
                        </svg>
                </div>

                @if (is_null($seccionUser))
                @else
                <div class="mt-4 pt-2 border-2 rounded-lg">
                    <h1 class="w-full text-center bold uppercase mb-2">Listado de usuarios</h1>
                    @forelse ($seccionUsers as $seccionU)
                    <div class="flex">
                        <div class="mr-2">
                            <button wire:click="confirmarBorrarUsuario({{$seccionU->id}})" class="rounded-md text-error  font-bold" title="Eliminar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div>
                            {{$seccionU->user->name}}
                        </div>
                    </div>
                    @empty

                    @endforelse
                </div>
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalFormVisible1')" wire:loading.attr="disabled">
                Cerrar
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="saveUser()" wire:loading.attr="disabled" class="btn btn-primary ml-2">
                Guardar
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

    <!-- ------------------------------ Modal 3: Advertencia, usuario corresponde a otra empresa ---------------------- -->
    <x-jet-confirmation-modal wire:model="modalFormVisible2" >
        <x-slot name="title">
            ADVERTENCIA
        </x-slot>

        <x-slot name="content">
            {{$mensaje}}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalFormVisible2')" wire:loading.attr="disabled">
                Cerrar
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-confirmation-modal>

    <script>
        function CopyToClipboard(containerid) {
            var copyText = document.getElementById(containerid);
            var tempInput = document.createElement("input");
            tempInput.value = copyText.value;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);
            /* Select the text field */
            alert('Enlace copiado');
        };
    </script>


</div>
