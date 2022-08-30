<div class="px-3 py-2">
    <ul>
    @foreach ($errors as $error)
        <li class="text-error text-xs">{{ $error }}</li>
    @endforeach
    </ul>
    <h1 class="text-xl font-bold text-center">Digitalzacion de documentos</h1>
        <div class=" border rounded-lg">
            <h3 class="text-lg px-2 py-1">Datos de radicación</h3>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-3 px-3 py-2">
                <div class="">
                    <label for="radicado" class="block text-sm font-bold"># de radicado @error('radicado') <span  class="text-error  text-xs">(*) </span> @enderror</label>
                    <input id="radicado" type="text" wire:model.debounce.300ms="radicado" wire:change="buscarRadicado();" class="w-full px-2 py-1 rounded-md shadow-lg">
                </div>
                <div class="">
                    <label for="seccion_id" class="block text-sm font-bold">Secciones</label>
                    <select name="" id="seccion_id" wire:model="seccion_id" wire:change="buscarSerie();" class="w-full px-2 py-1 rounded-md shadow-lg">
                        @foreach ($seccion_empresa as $seccioni=>$nombre )
                            <option value="{{$seccioni}}">{{$nombre}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="">
                    <label for="tipos_id" class="block text-sm font-bold">Serie</label>
                    <select id="tipos_id" name="" wire:model="serie_id" wire:change = "buscarSubSerie()" class="w-full px-2 py-1 rounded-md shadow-lg">
                        @foreach ($series as $serie=>$nombre )
                            <option value="{{$serie}}">{{$nombre}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="">
                    <label for="subserie_id" class="block text-sm font-bold">Subserie</label>
                    <select id="subserie_id" name="" wire:model="subserie_id" wire:change = "buscarTipologia()" class="w-full px-2 py-1 rounded-md shadow-lg">
                        @foreach ($subserie as $subseri)
                            <option value="{{$subseri->id}}">{{$subseri->nombre}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="">
                    <label for="tipologia_id" class="block text-sm font-bold">Tipología</label>
                    <select id="tipologia_id" name="" wire:model="tipologia_id" class="w-full px-2 py-1 rounded-md shadow-lg" wire:change="obtenerDiasTermino();">
                        @foreach ($tipologia as $tipologi)
                            <option value="{{$tipologi->id}}">{{$tipologi->nombre}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="">
                    <label for="fecha" class="block text-sm font-bold">Fecha @error('fecha') <span  class="text-error  text-xs">(*)</span> @enderror</label>
                    <input type="date" wire:model.defer="fecha" id="fecha" class="w-full px-2 py-1 rounded-md shadow-lg">
                </div>
                <div class="">
                    <label for="destinatario" class="block text-sm font-bold">Destinatario @error('destinatario') <span  class="text-error  text-xs">(*)</span> @enderror</label>
                    <input type="text" wire:model.defer="destinatario" id="destinatario" class="w-full px-2 py-1 rounded-md shadow-lg">
                </div>
                <div class="">
                    <label for="estante" class="block text-sm font-bold">Estante @error('estante') <span  class="text-error  text-xs">(*)</span> @enderror</label>
                    <input type="text" wire:model.defer="estante" id="estante" class="w-full px-2 py-1 rounded-md shadow-lg">
                </div>
                <div class="">
                    <label for="caja" class="block text-sm font-bold">Caja @error('caja') <span  class="text-error  text-xs">(*)</span> @enderror</label>
                    <input type="number" id="caja" wire:model.defer="caja" class="w-full px-2 py-1 rounded-md shadow-lg">
                </div>
                <div class="">
                    <label for="folios" class="block text-sm font-bold">Folios @error('folios') <span  class="text-error  text-xs">(*)</span> @enderror</label>
                    <input type="number" id="folios" wire:model.defer="folios" class="w-full px-2 py-1 rounded-md shadow-lg">
                </div>
                <div class="">
                    <label for="anexos" class="block text-sm font-bold">Anexos @error('anexos') <span  class="text-error  text-xs">(*)</span> @enderror</label>
                    <input type="number" wire:model.defer="anexos" id="anexos" class="w-full px-2 py-1 rounded-md shadow-lg">
                </div>

                <div class="md:col-span-5">
                    <label for="descripcion" class="block text-sm font-bold">Descripción del archivo @error('descripcion') <span  class="text-error  text-xs">(*)</span> @enderror</label>
                    <textarea id="descripcion" wire:model.defer="descripcion" rows="2" class="w-full px-2 py-1 rounded-md shadow-lg"></textarea>
                </div>
                <div class="md:col-span-5">
                    <label for="observaciones" class="block text-sm font-bold">Observaciones @error('observaciones') <span  class="text-error  text-xs">(*)</span> @enderror</label>
                    <textarea id="observaciones" wire:model.defer="observaciones" rows="2" class="w-full px-2 py-1 rounded-md shadow-lg"></textarea>
                </div>
                <div class="">
                    <p><input type="checkbox" wire:model.defer="confidencial" class="px-2 py-1 rounded-md shadow-lg"> Marcar como confindencial.</p>
                </div>
                <div class="md:col-span-2">
                    <label for="" class="block text-sm font-bold">Adjuntar archivo @error('adjunto') <span class="text-error text-xs">{{ $message }}</span> @enderror</label>
                    <input class="bg-green-200" type="file" wire:model="adjunto" accept="application/pdf">
                </div>
            </div>
        </div>
        <div class="border rounded-lg my-3">
            <h3 class="text-lg">Datos de remintente</h3>
            <div class="grid lg:grid-cols-6 gap-3">
                <div class="mx-2">
                    <label for="tipo_documento" class="block text-sm font-bold">Tipo de documento</label>
                    <select name="" id="tipo_documento" wire:model="tipo_documento" class="w-full px-2 py-1 rounded-md shadow-lg">
                        @forelse ($tipoUsuario as $tipousuario)
                            <option value="{{$tipousuario->id}}">{{$tipousuario->nombre}}</option>
                        @empty

                        @endforelse
                    </select>
                </div>
                <div class="px-2"><label for="documento" class="block text-sm font-bold"># de Documento @error('documento') <span  class="text-error  text-xs">(*)</span> @enderror</label>
                    <input id="documento" wire:model.debounce.300ms="documento" wire:change="buscarRemitente()" type="text" class="w-full px-2 py-1 rounded-md shadow-lg">
                </div>
                <div class="px-2"><label for="nombrecompleto" class="block text-sm font-bold">Nombre / razón social @error('nombrecompleto') <span  class="text-error  text-xs">(*)</span> @enderror</label>
                    <input id="nombrecompleto" wire:model.defer="nombrecompleto" type="text" class="w-full px-2 py-1 rounded-md shadow-lg">
                </div>
                <div class="px-2"><label for="email" class="block text-sm font-bold">Email @error('email') <span  class="text-error  text-xs">(*)</span> @enderror</label>
                    <input id="email" wire:model.defer="email" type="email" class="w-full px-2 py-1 rounded-md shadow-lg">
                </div>
                <div class="px-2"><label for="telefono" class="block text-sm font-bold">Teléfono @error('telefono') <span  class="text-error  text-xs">(*)</span> @enderror</label>
                    <input id="telefono" wire:model.defer="telefono" type="text" class="w-full px-2 py-1 rounded-md shadow-lg">
                </div>
                <div class="px-2 py-2">
                    <div class="tooltip" data-tip="Archivar documento">
                        <button class="px-5 btn btn-primary" wire:click="archivarDocumento()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="pt-3 overflow-x-auto">
            <h3 class="font-bold text-lg text-center uppercase"> Gestión de documentos archivados</h3>
            <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-gray-300">Search</label>
            <div class="relative">
                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="search" wire:model = "param" id="default-search" class="block p-4 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ingrese su parámetro de busqueda" required>
            </div>
            <h3 class="font-bold text-center uppercase pt-3 mt-3"> Consolidado de documentos archivados</h3>

            <table class="table table-compact w-full ">
                <caption class="uppercase font-bold"></caption>
                <thead>
                    <tr>
                        <th>Radicado</th>
                        <th>Fecha</th>
                        <th>Remitente</th>
                        <th>Destinatario</th>
                        <th>Estante</th>
                        <th>Caja</th>
                        <th>Descripción</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inventarioDigital as $inventario)
                        <tr>
                            <td>{{$inventario->radicado}}</td>
                            <td>{{$inventario->fecha}}</td>
                            <td>{{$inventario->nombrecompleto}}</td>
                            <td>{{$inventario->destinatario}}</td>
                            <td>{{$inventario->estante}}</td>
                            <td>{{$inventario->caja}}</td>
                            <td>{{$inventario->descripcion}}</td>
                            <td>
                                  <div class="tooltip" data-tip="Administrar Documento" wire:click="administrarDoc('{{Crypt::encryptString($inventario->id)}}');">
                                    <label for="admin-documento" class="modal-button cursor-pointer" >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                          </svg>
                                    </label>
                                </div>
                                <div class="tooltip" data-tip="Ver documento">
                                    <a href="#" onclick="window.open('{{route('imparchivo', Crypt::encryptString($inventario->id))}}','Ver documento','width=700,height=900')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="8">
                            {{ $inventarioDigital->links() }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>
</div>
