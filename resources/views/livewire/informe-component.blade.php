<div class="px-3 py-3 my-3">
    @livewireScripts                    
    @livewireChartsScripts
    {{-- Be like water. --}}
    @if ($seccion_id>0)   
    <div class="flex">
        <div class="grid grid-cols-6 mr-5 gap-4 font-semibold "> 
            <div class="w-42">
                <label class="label" for="">Fecha inicial</label>
                <input type="date" name="" id="" wire:model="fechai">
            </div>
            <div class="w-42">
                <label class="label" for="">Fecha final</label>
                <input type="date" name="" id="" wire:model="fechaf">
            </div>
            <div>
               <label class="label" for="">Secciones</label>
               <select name="" class="select select-primary w-full" id="" wire:model='seccion_id' wire:change='selSeccion();'>
                <option value="0">Todas</option>
                @foreach ($secciones as $seccion)
                    <option value="{{$seccion->id}}">{{$seccion->nombre}}</option>
                @endforeach
               </select>
            </div>
            <div>
                <label class="label" for="">Series</label>
                <select name="" class="select select-primary w-full" id="" wire:model = 'series_id'>
                    <option value="0">Todas</option>
                    @foreach ($series as $serie)
                    <option value="{{$serie->id}}">{{$serie->nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="label" for="">Subseries</label>
                <select name="" class="select select-primary w-full" id="">
                    <option value="*">Todas</option>
                </select>
            </div>
            <div>
               <label class="label" for="">Tipología</label>
               <select name="" class="select select-primary w-full" id="">
                <option value="*">Todas</option>
               </select>
            </div>
        </div>
    </div> 
      
    <div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">            
            <div class="h-96 pt-5 inline-block">                
                <livewire:livewire-pie-chart
                    key="{{ $pieChartModel->reactiveKey() }}"
                    :pie-chart-model="$pieChartModel"
                />
            </div>
            <div class="h-96 pt-5 inline-block">                
                <livewire:livewire-pie-chart
                    key="{{ $pieChartModel1->reactiveKey() }}"
                    :pie-chart-model="$pieChartModel1"
                />
            </div>
            <div class="inline-block">             
                <div class="my-3">
                    <table class="w-full text-sm">
                        <caption class="border border-gray-600 font-semibold">{{$seccion->nombre}}</caption>
                        <thead>
                            <tr class="py-2 px-2 font-bold text-center border border-gray-400 bg-blue-300">
                                <th class="pl-2">TIPO</th>
                                <th class="pl-2">TOTAL</th>
                                <th class="pl-2">ACTIVAS</th>
                                <th class="pl-2">PENDIENTES</th>
                                <th class="pl-2">VENCIDAS</th>
                                <th class="pl-2">FINALIZADAS</th>
                                <th class="pl-2"></th>
                            </tr>
                        </thead>
                        <tbody>                        
                            @forelse ($series as $serie)
                                {{totalesSeccionSolicitud($seccion_id, $serie->id, $fechai, $fechaf)}}
                            @empty
                            
                            @endforelse
                        </tbody>
                    </table>
    
                </div>
            </div>
    
            <div class="max-h-80 inline-block">                
                <livewire:livewire-column-chart
                    key="{{ $columnChartModel->reactiveKey() }}"
                    :column-chart-model="$columnChartModel"
                />        
            </div>
        </div>
        
        <div class="w-full grid lg:grid-cols-2 gap-5">
        @foreach ($series as $serie)
        <div class="mt-10 print:border print:border-black print:block">
            {{solictudesTipo($seccion_id, $serie->id, $fechai, $fechaf)}}     
        </div>                
        @endforeach
        </div>
    </div>
    @endif
    
</div>
