<div class="px-3 py-3 my-3 text-xs mx-2">

    <div class="border-morado border-2 px-3 py-3 shadow-md rounded-xl">
        <h3 class="block w-full text-lg font-bold">Parámetros de búsqueda</h3>
        <div class="grid grid-cols-2 md:grid-cols-6 mr-5 gap-4 font-semibold ">
            <div class="">
                <label class="label text-sm font-bold" for="">Fecha inicial</label>
                <input type="date" class="w-full" name="" id="" wire:model="fechai" wire:change='selFecha();'>
            </div>
            <div class="">
                <label class="label text-sm font-bold" for="">Fecha Final</label>
                <input type="date" class="w-full" name="" id="" wire:model="fechaf" wire:change='selFecha();'>
            </div>
            <div>
               <label class="label text-sm font-bold" for="">Secciones</label>
                @forelse  ($secciones as $seccion)
                <div class="block lowercase">
                    <input type="checkbox" name="" id="" class="checkbox checkbox-xs checkbox-primary" wire:model='secciones_id.{{$seccion->id}}'>
                    <span>{{$seccion->nombre}}</span>
                </div>
                @empty
                    No Hay Secciones disponibles
                @endforelse
            </div>
            <div>
                <label class="label text-sm font-bold" for="">Series</label>
                @forelse  ($series as $serie)
                <div class="block lowercase">
                    <input type="checkbox" name="" id="" class="checkbox checkbox-xs checkbox-primary" wire:model='serie_id.{{$serie->id}}'>
                    <span>{{$serie->nombre}}</span>
                </div>
                @empty
                    No Hay series disponibles
                @endforelse
            </div>
            <div>
                <label class="label text-sm font-bold" for="">Subseries</label>
                @forelse  ($subseries as $subserie)
                <div class="block lowercase">
                    <input type="checkbox" name="" id="" class="checkbox checkbox-xs checkbox-primary" wire:model='subserie_id.{{$subserie->id}}'>
                    <span>{{$subserie->nombre}}</span>
                </div>
                @empty
                    No Hay subseries disponibles
                @endforelse
            </div>
            <div>
               <label class="label text-sm font-bold" for="">Tipología</label>
               @forelse  ($tipologias as $tipologia)
               <div class="block lowercase">
                   <input type="checkbox" name="" id="" class="checkbox checkbox-xs checkbox-primary" wire:model='tipologia_id.{{$tipologia->id}}'>
                   <span>{{$tipologia->nombre}}</span>
               </div>
               @empty
                   No Hay tipologias disponibles
               @endforelse
            </div>
        </div>
    </div>
    <div class="">
        <table class="border mt-3 rounded-lg w-full md:text-xs">
            <tr class="border">
                <th>#</th>
                <th>Radicado</th>
                <th>Fecha</th>
                <th>Dependencia</th>
                <th>Serie</th>
                <th>Subserie</th>
                <th>Tipología</th>
                <th>Usuario</th>
                <th>Asunto</th>
                <th>Anexos</th>
            </tr>

            @forelse ($solicitudes as $solicitud)
            <tr class="border">
                <td>{{$loop->iteration}}</td>
                <td>{{$solicitud->radicado}}</td>
                <td>{{$solicitud->created_at->format('Y-m-d')}}</td>
                <td>{{$solicitud->seccionempresa->nombre}}</td>
                <td>{{$solicitud->serie->nombre}}</td>
                <td>{{$solicitud->subserie->nombre}}</td>
                <td>{{$solicitud->tipologia->nombre}}</td>
                <td>{{$solicitud->user->name}}</td>
                <td>{{$solicitud->asunto}}</td>
                <td>{{$solicitud->anexos}}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9">No existen solicitudes con el parámetro de búsqueda</td>
            </tr>
            @endforelse
        </table>


    </div>
</div>
