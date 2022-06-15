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
        </div>
        
    </div>
    
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
                <button class="ml-2 px-1 py-1 bg-blue-400 rounded-lg hover:bg-blue-600 text-gray-100 font-bold" title="Enviar mensaje" wire:click="mostrarMensaje({{$empresai->id}})">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                      </svg>
                </button>
                <button class="ml-2 px-1 py-1 bg-green-400 rounded-lg hover:bg-green-800 text-gray-100 font-bold" title="Cambiar estado" wire:click="cambiarEstado({{$empresai->id}})">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
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
            <x-jet-secondary-button wire:click="$toggle('modalFormVisible1')" wire:loading.attr="disabled">
                Cancelar
            </x-jet-secondary-button>
    
            <x-jet-button class="ml-2" wire:click="enviarMensaje()" wire:loading.attr="disabled">
                Enviar Mensaje
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
