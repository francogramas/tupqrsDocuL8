<div class="py-2 px-2 text-sm">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 px-2">
        <div class="">
            <div class="grid grid-cols-6 gap-3 px-2 py-2 mt-2 border-2 rounded-md">
                <div class="col-span-3  ">
                    <h1 class="font-bold">Empresa</h1>
                    <select name="" id="" wire:model="empresa_id" wire:change="cambiarEmpresa()" class="select select-sm py-1 text-sm select-primary w-full max-w-xs">
                            @foreach ($empresas as $empresa)
                                <option value="{{$empresa->id}}">{{$empresa->razonsocial}}</option>
                            @endforeach
                    </select>
                </div>
                <div class="col-span-3">
                    <a href="" class="btn btn-sm modal-button">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                          </svg>
                    </a>
                </div>
            </div>
            <div class="grid grid-cols-6 gap-3 px-2 py-2 mt-2 border-2 rounded-md">
                <div class="col-span-3">
                    <h1 class="font-bold">Secciones de la empresa</h1>
                    <div class="flow">
                        <label for="modal-secciones" class="btn btn-sm modal-button" wire:click="administrar(1)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </label>

                        <select name="" id="" wire:model="seccion_id" wire:change="findSubseries();" class="select select-sm py-1 text-sm select-primary w-full max-w-xs">
                                @foreach ($secciones as $seccion)
                                    <option value="{{$seccion->id}}">{{$seccion->nombre}}</option>
                                @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-span-3">
                    <h1 class="font-bold">Series</h1>
                    <label for="modal-secciones" class="btn btn-sm modal-button" wire:click="administrar(2)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3"  fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                          </svg>
                    </label>
                    <select name="" id="" wire:model="serie_id"  wire:change="findSubseries();"  class="select select-sm py-1 text-sm select-primary w-full max-w-xs">
                        @foreach ($series as $serie)
                            <option value="{{$serie->id}}">{{$serie->nombre}}</option>
                        @endforeach
                    </select>

                </div>
            </div>

            <div class="grid grid-cols-6 gap-3 px-2 py-2 mt-2 border-2 rounded-md">
                <div class="col-span-6">
                    <h1 class="font-bold">Crear Subseries</h1>
                </div>
                <div>
                    <label for="" class="font-bold">Código</label>
                    <input type="text" class="input input-sm input-primary w-full" wire:model="codigo">

                    @error('codigo') <span class="text-error  block text-xs">{{ $message }}</span> @enderror

                </div>
                <div class="col-span-5">
                    <label for="" class="font-bold">Nombre</label>
                    <input type="text" class="input input-sm input-primary w-full" wire:model="nombre">
                    @error('nombre') <span class="text-error  block text-xs">{{ $message }}</span> @enderror
                </div>
                @if (strlen($nombre)>0)
                <div class="col-span-2">
                    <label class="w-full block font-bold" for="">Retención en años</label>
                    <div class="flex gap-2">
                        <input type="number" placeholder="AG" class="input input-sm input-primary w-full" name="" wire:model.defer="Re_AG">
                        <input type="number" placeholder="AC" class="input input-sm input-primary w-full" name="" wire:model.defer="Re_AC">
                    </div>
                </div>

                <div class="col-span-2">
                    <label class="w-full block font-bold" for="">Disposición final</label>
                    <label for="" class="tooltip tooltip-primary" data-tip="Conservación total"><input type="checkbox" class="checkbox checkbox-sm checkbox-primary" name="disposicion" wire:model="DF_CT"> C</label>
                    <label for="" class="tooltip tooltip-primary" data-tip="Eliminación"><input type="checkbox" class="checkbox checkbox-sm checkbox-primary" name="disposicion" wire:model="DF_E">E </label>
                    <label for="" class="tooltip tooltip-primary" data-tip="Digitalización"><input type="checkbox" class="checkbox checkbox-sm checkbox-primary" name="disposicion" wire:model="DF_MD">D </label>
                    <label for="" class="tooltip tooltip-primary" data-tip="Selección"><input type="checkbox" class="checkbox checkbox-sm checkbox-primary" name="disposicion" wire:model="DF_S">S </label>
                </div>

                <div class="col-span-1">
                    <label class="w-full block font-bold" for="">Acceso</label>
                    <label for="" class="tooltip tooltip-primary" data-tip="Público"><input type="radio" class="radio radio-sm radio-primary" name="acceso" wire:click="accesoEvent(1)" checked>P </label>
                    <label for="" class="tooltip tooltip-primary" data-tip="Privado"><input type="radio" class="radio radio-sm radio-primary" name="acceso" wire:click="accesoEvent(2)">Pr </label>
                </div>
                <div class="col-span-6">
                    <label class="w-full block font-bold" for="">Procedimiento</label>
                    <textarea name="" id="" class="w-full textarea textarea-primary" rows="4" wire:model.defer="procedimiento"></textarea>
                </div>
                <div class="col-span-2">
                    <button class="btn btn-xs btn-primary mt-4 text-xs w-full" @if ($boolEditSubserie)  wire:click="updateSubserie()" @else wire:click="guardar()" @endif>@if ($boolEditSubserie) Actualizar @else Crear Subserie  @endif </button>
                </div>
                @endif
            </div>
        </div>

        <div >
            <div class="px-2 py-2 mt-2 border-2 rounded-md">
                <h1 class="font-bold">Subseries</h1>
                <label for="modal-secciones" class="btn btn-sm modal-button" wire:click="administrar(3)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3"  fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      </svg>
                </label>
                <select name="" class="select select-sm py-1 text-sm select-primary w-full max-w-xs" id="" wire:model='subserie_id'>
                    @forelse ($subseries as $subserie)
                        <option value="{{$subserie->id}}">{{$subserie->nombre}}</option>
                    @empty
                        <option value=""></option>
                    @endforelse
                </select>
        </div>
        <div class="px-2 py-2 mt-2 border-2 rounded-md">
            <h1 class="font-bold">Tipología</h1>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-2 ">
                <div class="">
                    <label class="w-full block font-bold" for="">Soporte</label>
                    <label for=""><input type="checkbox" class="tooltip tooltip-primary checkbox checkbox-primary" data-tip="Papel"  id="Pa" wire:model="So_Pa" checked>P </label>
                    <label for=""><input type="checkbox" class="tooltip tooltip-primary checkbox checkbox-primary" data-tip="Digital"  id="Di" wire:model="So_El">Di </label>
                    <label for=""><input type="checkbox" class="tooltip tooltip-primary checkbox checkbox-primary" data-tip="Electrónico" id="El" wire:model="So_Di">El </label>
                </div>
                <div class="">
                    <label class="w-full block font-bold" for="">Radicado</label>
                    <div class="flex gap-2">
                        <label for=""><input type="radio" class="radio radio-sm radio-primary" name="radicado" wire:click="radicadoEvent(1)" checked>Entrada </label>
                        <label for=""><input type="radio" class="radio radio-sm radio-primary" name="radicado" wire:click="radicadoEvent(2)">Salida </label>
                    </div>
                </div>
                <div class="">
                    <label class="w-full block font-bold" for="">PQRS</label>
                    <select name="" id="" wire:model="pqrs_id" wire:change='calDiasTermino()'  class="select select-sm py-1 text-sm select-primary w-full max-w-xs">
                            @foreach ($pqrs as $pqrsi)
                                <option value="{{$pqrsi->id}}">{{$pqrsi->nombre}}</option>
                            @endforeach
                    </select>
                </div>
                <div class="">
                    <label class="w-full block font-bold" for="">Días de término</label>
                    <div class="flex gap-2">
                        <input type="number" class="input input-sm input-primary w-full" name="" wire:model.defer="diasTermino">
                    </div>
                </div>
            </div>
            <div class="">
                <label for="" class="font-bold">Nombre</label>
                <input type="text" class="input input-sm input-primary w-full" wire:model.defer="nombreTipologia" id="nombreTipologia">
                @error('nombre') <span class="text-error  block text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="">
                <button class="btn btn-xs btn-primary mt-4 text-xs w-full" @if($boolEditTipologia) wire:click="updateTipologia()" @else wire:click="CrearTipologia()" @endif onclick='document.getElementById("nombreTipologia").focus();'>@if($boolEditTipologia) Actualizar @else Crear tipología @endif </button>
            </div>
            <div>
                <table class="table table-compact w-full">
                    <tr>
                        <th>Tipología</th>
                        <th></th>
                    </tr>
                    @foreach ($tipologias as $tipologia)
                    <tr>
                        <td>{{$tipologia->nombre}}</td>
                        <td class="flex gap-1">
                            <button class="btn btn-xs btn-secondary px-1 w-8" title="Editar" wire:click="editTipologia({{$tipologia->id}})">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                            </button>
                            <button class="btn btn-xs btn-error px-1 w-8" title="Borrar" wire:click="deleteTipologia({{$tipologia->id}})">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                  </svg>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        </div>
    </div>

        <div class="gap-3 px-2 py-2 mt-2 border-2 rounded-md w-full">
            @forelse ($secciones as $seccion1)
                <div class="w-full grid grid-cols-6">
                    <div>
                        <p>{{$seccion1->codigo.' - '.$seccion1->nombre}}</p>
                    </div>
                    <div class="col-span-5">

                        @forelse (consultarSeries($seccion1->id) as $serie1)
                            <div class="w-full grid grid-cols-4">
                                <div class="col-span-1">
                                    <p>{{$serie1->codigo.' - '.$serie1->nombre}}</p>
                                </div>
                                <div class="col-span-3">
                                    @forelse (consultarSubseries($serie1->id, $seccion1->id) as $subserie1)
                                    <div class="w-full grid grid-cols-2">
                                        <div >
                                            <p>{{$subserie1->codigo.' - '.$subserie1->nombre}}</p>
                                        </div>
                                        <div>
                                            @forelse (consultarTipologia($subserie1->id) as $tipo1)
                                            <div>
                                                <p>{{$tipo1->nombre}}</p>
                                            </div>
                                            @empty
                                            @endforelse
                                        </div>
                                    </div>
                                    <div class="divider"></div>
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                            <div class="divider"></div>
                        @empty
                        @endforelse
                    </div>
                </div>
                <div class="divider"></div>
            @empty

            @endforelse
        </div>

    <!-- Secciones de la empersa o entidad -->
    <input type="checkbox" id="modal-secciones" class="modal-toggle" />
    <label for="modal-secciones" class="modal cursor-pointer">
        <div class="modal-box relative w-11/12 max-w-5xl">
            <label for="modal-secciones" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
            <!-- -------------- Administrar secciones ---------------->
            @if ($boolSeccion)
            <h3 class="font-bold text-lg">Secciones</h3>
            <div>
                <input type="text" class="input input-sm input-bordered w-1/5 max-w-xs" placeholder="Código" wire:model.defer="codigoSeccion">
                <input type="text" class="input input-sm input-bordered w-3/5 max-w-xs" placeholder="Nombre de la Sección" wire:model.defer="nombreSeccion">
                <button class="btn btn-sm btn-primary px-2" @if ($boolEditSeccion) title="Actualizar"  wire:click="updateSeccionEmpresa();" @else title="Guardar"  wire:click="createSeccionEmpresa();" @endif>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                </button>
            </div>
            <div class="py-4">
                <table class="table table-compact w-full">
                    <tr>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th></th>
                    </tr>
                    @foreach ($secciones as $seccion)
                    <tr>
                        <td>{{$seccion->codigo}}</td>
                        <td>{{$seccion->nombre}}</td>
                        <td class="flex gap-1">
                            <button class="btn btn-xs btn-secondary px-1 w-8" title="Editar" wire:click="editSeccionEmpresas({{$seccion->id}})">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                            </button>
                            <button class="btn btn-xs btn-error px-1 w-8" title="Borrar" wire:click="deleteSeccion({{$seccion->id}})">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
            @endif
            <!-- -------------- Administrar Series ---------------->
            @if ($boolSerie)
            <h3 class="font-bold text-lg">Series</h3>
            <div class="">
                <input type="text" class="input input-sm input-bordered w-1/5 max-w-xs" placeholder="Código" wire:model.defer="codigoSerie">
                <input type="text" class="input input-sm input-bordered w-3/5 max-w-xs" placeholder="Nombre de la Serie" wire:model.defer="nombreSerie">
                <button class="btn btn-sm btn-primary px-2" @if ($boolEditSerie) title="Actualizar"  wire:click="updateSerie();" @else title="Guardar"  wire:click="crearSerie();" @endif>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                </button>
            </div>
            <div class="py-4">
                <table class="table table-compact w-full">
                    <tr>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th></th>
                    </tr>
                    @foreach ($series as $serie)
                    <tr>
                        <td>{{$serie->codigo}}</td>
                        <td>{{$serie->nombre}}</td>
                        <td class="flex gap-1">
                            <button class="btn btn-xs btn-secondary px-1 w-8" title="Editar" wire:click="editSerie({{$serie->id}})">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                            </button>
                            <button class="btn btn-xs btn-error px-1 w-8" title="Borrar" wire:click="deleteSerie({{$serie->id}})">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
            @endif

            <!-- -------------- Administrar Subserie ---------------->
            @if ($boolSubserie)
            <h3 class="font-bold text-lg">SubSeries</h3>

            <div class="py-4">
                <table class="table table-compact w-full">
                    <tr>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th></th>
                    </tr>
                    @foreach ($subseries as $subserie)
                    <tr>
                        <td>{{$subserie->codigo}}</td>
                        <td>{{$subserie->nombre}}</td>
                        <td class="flex gap-1">
                            <label class="btn btn-xs btn-secondary px-1 w-8" title="Editar" wire:click="editSubserie({{$subserie->id}});" for="modal-secciones">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                            </label>
                            <button class="btn btn-xs btn-error px-1 w-8" title="Borrar" wire:click="deleteSubserie({{$subserie->id}})">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
            @endif
            <div class="modal-action text-xs">
                <label for="modal-secciones" class="btn btn-primary" wire:click="cerrar();">Cerrar</label>
            </div>

        </div>
    </label>


</div>
