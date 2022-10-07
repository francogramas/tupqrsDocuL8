<div class="px-3 py-2">
    <div class="grid grid-cols-1 md:grid-cols-3">
        <div class="px-2 mx-1">
            <h1 class="font-bold text-xl">Gestión de las empresas</h1>
            <input type="text" class="w-full" placeholder="Buscar empresa" wire:model="param" wire:click="clickParam()">
        </div>
        <div class="px-2 mx-1">
            <h1 class="font-bold text-xl">Mostrar</h1>
            <select name="" id="" class="w-full" wire:model="estado_id">
                <option value="_">Todos</option>
                <option value="1">Activa</option>
                <option value="2">Vencida</option>
            </select>
        </div>
        <div class="px-2 mx-1">
            <button class="mt-9 ml-2 px-1 py-1 bg-blue-400 rounded-lg hover:bg-blue-600 text-gray-100 font-bold" title="Enviar mensaje masivo" wire:click="mostrarMensajeMasivo()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                  </svg>
            </button>
            <button class="mt-9 ml-2 px-1 py-1 bg-blue-400 rounded-lg hover:bg-blue-600 text-gray-100 font-bold" title="Crear empresa nueva" wire:click="crearNueva()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                  </svg>
            </button>
        </div>
    </div>
    @if ($boolGuardar)
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mt-5" >
            <div class="form-control">
                <label for="" class="input-group input-group-vertical">
                    <span>Nit @error('nit') <span class="text-error font-bold text-sm">*{{ $message }}</span> @enderror</span>

                    <input type="text" class="input input-bordered" placeholder="Nit" wire:model='nit'>
                </label>
            </div>
            <div class="form-control">
                <label for="" class="input-group input-group-vertical">
                    <span>Razón Social @error('razonsocial') <span class="text-error font-bold text-sm">* {{ $message }}</span> @enderror</span>
                    <input type="text" class="input input-bordered" placeholder="Razón Social" wire:model='razonsocial'>
                </label>
            </div>
            <div class="form-control">
                <label for="" class="input-group input-group-vertical">
                    <span>Departamento</span>
                    <select name="estado_id" wire:model="estados_id" wire:change="cargarciudades()" id="" class="w-full px-2 pt-3 rounded-md select select-bordered">
                        @foreach ($estados as $estado)
                            <option value="{{$estado->id}}">{{$estado->estado}}</option>
                        @endforeach
                    </select>
                </label>
            </div>
            <div class="form-control">
                <label for="" class="input-group input-group-vertical">
                    <span>Ciudad @error('ciudad_id') <span class="text-error font-bold text-sm">* {{ $message }}</span> @enderror</span>
                    <select name="" wire:model="ciudad_id" id="" class="w-full px-2 py-1 rounded-md select select-bordered" wire:model='ciudad_id'>
                        @foreach ($ciudades as $ciudad)
                            <option value="{{$ciudad->id}}">{{$ciudad->ciudad}}</option>
                        @endforeach
                    </select>
                </label>
            </div>
            <div class="form-control col-span-2">
                <label for="" class="input-group input-group-vertical">
                    <span>Dirección @error('direccion') <span class="text-error font-bold text-sm">* {{ $message }}</span> @enderror</span>
                    <input type="text" class="input input-bordered" placeholder="Dirección" wire:model='direccion'>
                </label>
            </div>
            <div class="form-control">
                <label for="" class="input-group input-group-vertical">
                    <span>Teléfono @error('telefono') <span class="text-error font-bold text-sm">* {{ $message }}</span> @enderror</span>
                    <input type="text" class="input input-bordered" placeholder="Teléfono" wire:model='telefono'>
                </label>
            </div>
            <div class="form-control">
                <label for="" class="input-group input-group-vertical">
                    <span>Email @error('email') <span class="text-error font-bold text-sm">* {{ $message }}</span> @enderror</span>
                    <input type="text" class="input input-bordered" placeholder="Email" wire:model='email'>
                </label>
            </div>
            <div class="form-control">
                <label for="" class="input-group input-group-vertical">
                    <span>Dominio @error('dominio') <span class="text-error font-bold text-sm">* {{ $message }}</span> @enderror</span>
                    <input type="text" class="input input-bordered" placeholder="Dominio" wire:model='dominio'>
                </label>
            </div>
            <div class="form-control">
                <label for="" class="input-group input-group-vertical">
                    <span>Logo @error('logo') <span class="text-error font-bold text-sm">* {{ $message }}</span> @enderror</span>
                    <input type="file" class="input input-bordered" placeholder="Logo" wire:model='logo' accept="image/*">
                    <img src="{{$urlLogo}}" alt="" width="150">
                </label>
            </div>
            <div class="form-control">
                <label for="" class="label">
                    <span class="label-text"></span>
                </label>
                <label for="" class="">
                    <span></span>
                    @if ($boolUpdate)
                        <input type="submit" class="btn btn-primary" value="Actualizar" wire:click="update()">
                    @else
                        <input type="submit" class="btn btn-primary" value="Crear nueva" wire:click="guardarNueva()">
                    @endif
                </label>
            </div>
            <div class="form-control">
                <label for="" class="label">
                    <span class="label-text"></span>
                </label>
                <label for="" class="">
                    <span></span>
                    <input type="submit" class="btn btn-warning" value="Cancelar" wire:click="cancelarNueva()">
                </label>
            </div>
        </div>
    @endif

    <div class="border-b border-gray-400 block mx-3 mt-2">
        <div class="hidden lg:grid grid-cols-1 md:grid-cols-7 gap-3 border-t border-r border-l border-gray-400 font-bold">
            <div class="px-2">
                Razón Social
            </div>
            <div class="px-2">
                Teléfono
            </div>
            <div class="px-2">
                Email
            </div>
            <div class="px-2">
                Ciudad
            </div>
            <div class="px-2">
                Departamento
            </div>
            <div class="px-2">
                Estado
            </div>
        </div>
    @forelse ($empresas as $empresai)
        <div class="grid grid-cols-1 md:grid-cols-7 gap-3 border-t border-r border-l border-gray-400">
            <div class="px-2">
                <div class="lg:hidden font-semibold">Razón Social</div>
                {{$empresai->razonsocial}}
            </div>
            <div class="px-2">
                <div class="lg:hidden font-semibold">Teléfono</div>
                {{$empresai->telefono}}
            </div>
            <div class="px-2">
                <div class="lg:hidden font-semibold">Email</div>
                {{$empresai->email}}
            </div>
            <div class="px-2">
                <div class="lg:hidden font-semibold">Ciudad</div>
                {{$empresai->ciudad->ciudad}}
            </div>
            <div class="px-2">
                <div class="lg:hidden font-semibold">Departamento</div>
                {{$empresai->ciudad->estado->estado}}
            </div>
            <div class="px-2">
                <div class="lg:hidden font-semibold">Estado</div>
                {{$empresai->estado->nombre}}
            </div>
            <div class="px-2">
                <button class="ml-2 px-1 py-1 rounded-lg font-bold tooltip tooltip-primary"  data-tip="Enviar Mensaje" wire:click="mostrarMensaje({{$empresai->id}})">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                      </svg>
                </button>
                <button class="ml-2 px-1 py-1 rounded-lg font-bold tooltip tooltip-primary"  data-tip="Cambiar estado" wire:click="cambiarEstado({{$empresai->id}})">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                      </svg>
                </button>
                <button class="ml-2 px-1 py-1 rounded-lg font-bold tooltip tooltip-primary"  data-tip="Editar" wire:click="edit({{$empresai->id}})">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                      </svg>
                </button>
            </div>
        </div>
    @empty

    @endforelse
        <div>
            {{ $empresas->links() }}
        </div>
    </div>
    <!-- ------------------------------ Modal 2: Asignar lider de dependencia ---------------------------------------- -->
    @if ($empresa)


    <x-jet-dialog-modal wire:model="modalFormVisible1" >
        <x-slot name="title">
            Enviar Mensaje a {{$empresa->razonsocial}}

        </x-slot>

        <x-slot name="content">
            <div class="pt-2">
                <input type="text" class="w-full mx-3 px-2" placeholder="Asunto" wire:model.defer="asunto">
            </div>
            <div class="pt-2">
                <textarea  rows="10" class="w-full mx-3 px-2" placeholder="Mensaje" wire:model.defer="mensaje"></textarea>
            </div>
        </x-slot>

        <x-slot name="footer">
            <button wire:click="$toggle('modalFormVisible1')" wire:loading.attr="disabled" class="btn btn-warning">
                Cancelar
            </button>

            <button class="ml-2 btn btn-primary" wire:click="enviarMensaje()" wire:loading.attr="disabled" >
                Enviar Mensaje
            </button>
        </x-slot>
    </x-jet-dialog-modal>
    @endif
</div>
