<div class="px-3 py-3 my-3">
    
    <div class="flex">
        <div class="grid grid-cols-6 mr-5 gap-4 font-semibold "> 
            <div class="w-42">
                <label class="label" for="">Fecha</label>
                <input type="date" name="" id="" wire:model="fechai" wire:change='selFecha();'>
            </div>            
            <div>
               <label class="label" for="">Secciones</label>
               <select name="" class="select select-primary w-full" id="" wire:model='seccion_id' wire:change='selSeccion();'>
                <option value="0">Todas</option>
                @forelse  ($secciones as $seccion)
                <option value="{{$seccion->id}}">{{$seccion->nombre}}</option>                        
                @empty                    
                @endforelse
                </select>
            </div>
            <div>
                <label class="label" for="">Series</label>
                <select name="" class="select select-primary w-full" id="" wire:model = 'series_id' wire:change='selSerie();'>
                    <option value="0">Todas</option>
                    @forelse ($series as $serie)
                    <option value="{{$serie->id}}">{{$serie->nombre}}</option>
                    @empty
                    @endforelse
                </select>
            </div>
            <div>
                <label class="label" for="">Subseries</label>
                <select name="" class="select select-primary w-full" id="" wire:model='subseries_id' wire:change='selSubserie();'>
                    <option value="0">Todas</option>
                    @forelse ($subseries as $subserie)
                    <option value="{{$subserie->id}}">{{$subserie->nombre}}</option>
                    @empty
                    @endforelse
                </select>
            </div>
            <div>
               <label class="label" for="">Tipología</label>
               <select name="" class="select select-primary w-full" id="" wire:model='tipologias_id'>
                <option value="*">Todas</option>
                @forelse ($tipologias as $tipologia)
                <option value="{{$tipologia->id}}">{{$tipologia->nombre}}</option>
                @empty
                @endforelse
               </select>
            </div>
        </div>
    </div>    
</div>
