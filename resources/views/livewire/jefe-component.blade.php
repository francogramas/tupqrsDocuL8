<div class="grid grid-cols-6">
    @if (is_null($pendientes))
        No tiene solicitudes por responder
    @else

    <div class="p-3 col-span-1">
        <div>
            <label for="" class="block text-gray-700 text-sm font-bold">Dependencias</label>
            <select wire:model="seccion_id" id="seccion_id" class="w-full mb-2" wire:change="consultarSeries();">
                @foreach ($secciones as $seccion)
                    <option value="{{$seccion->id}}">{{$seccion->nombre}}</option>
                @endforeach
            </select>
        </div>
        <div class="" wire:poll.30s="cargarPendientes()">
            <label for="" class="block text-gray-700 text-sm font-bold">Solicitudes por responder</label>
            @forelse($pendientes as $sol)
                @isset($sol->salida)
                    <button wire:click="verSolicitud({{$sol->salida->id}})" class="w-full text-left py-1 px-1 cursor-pointer border shadow-md hover:bg-contenido  @if($sol->salida->id == $solicitud->id) bg-contenido @endif">
                        <a href="#respuesta">
                            <p class="text-gray-700 text-sm font-semibold">{{Str::limit($sol->salida->solicitante->nombrecompleto,20)}}</p>
                            <p class="text-gray-700 text-xs">{{Str::limit($sol->salida->asunto, 25, '...') }}</p>
                            <p class="text-gray-500 text-xs text-right flex">

                                @if($sol->salida->estado_id==1)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-success" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @elseif($sol->salida->estado_id==2)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-warning" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                @elseif($sol->salida->estado_id==3)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-error" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                @endif
                                {{$sol->salida->created_at->format('d/m/Y')}}

                            </p>
                        </a>
                    </button>
                @endisset
            @empty
                <p class="px-2 py-2">No tienes compromisos por responder</p>
            @endforelse

        </div>
    </div>

    @isset($solicitud)
        <div class="p-3 col-span-5">
            <div class="mt-3">
                <p>
                    <span class="font-bold">Solicitante:</span> {{$solicitud->solicitante->nombrecompleto}}</p>
                <p>
                    {{$solicitud->tipologia->nombre}} <span class="font-bold">Fecha: </span>{{$solicitud->created_at}}
                </p>

                <p>
                    <span class="font-bold">Empresa:</span> {{$solicitud->seccionempresa->empresa->razonsocial}}
                </p>
                <p>
                    <span class="font-bold">Departamento/Sección:</span>
                    {{$solicitud->seccionempresa->nombre}}
                </p>
                <p>
                    <span class="font-bold">Estado de solictud:</span> {{$solicitud->estado->nombre}}
                </p>
                <p>
                    <span class="font-bold">Asunto: </span>{{$solicitud->asunto}}
                </p>
                <p>
                    <span class="font-bold">No de Radicado: </span>{{$solicitud->radicado}}
                </p>
                <p>
                    <h1 class="font-bold">Contenido:</h1>
                    @foreach ($solicitud->seguimiento as $seguimiento)
                        {{$seguimiento->created_at->format('M d/Y').' -'.$seguimiento->accion->nombre}}

                        @if ($seguimiento->mensaje and !$loop->last)
                        <br>
                            {{'Mensaje - '. $seguimiento->mensaje}}
                        @endif
                        @if ($seguimiento->observaciones)
                        <br>
                            {{'Observaciones - '. $seguimiento->observaciones}}
                        @endif
                        @if ($seguimiento->observaciones)
                        <br>
                        <span class="font-bold">Adjuntos</span>
                        @endif

                    @endforeach

                </p>
                <p>
                    Auxiliar: {{$solicitud->seccionempresa->userSeccion->user->name}}
                </p>
            </div>
            <div class="mt-3">
            </div>
            <div class="mt-3">
                <h1 class="font-bold">Respuesta</h1>
                <textarea name="respuesta" wire:model='respuesta' id="" class="w-full" rows="10">{{$cola->salida->seguimiento->last()->mensaje}}</textarea>
            </div>
            <div class="mt-3">
                <button class="btn btn-primary" wire:click='responderSolicitud();'>Responder</button>
            </div>
        </div>
    @endisset
    @endif

</div>
