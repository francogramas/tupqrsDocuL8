<div class="px-5 py-5 my-5">
    
    @if ($seccion_id>0)   
        <div class="flex">
            <div class="grid grid-cols-1 mr-5"> 
                <div class="w-42 font-semibold px-2 py-2">
                    <label class="block" for="">Fecha inicial</label>
                    <input type="date" name="" id="" wire:model="fechai">
                </div>
                <div class="w-42 font-semibold px-2 py-2">
                    <label class="block" for="">Fecha final</label>
                    <input type="date" name="" id="" wire:model="fechaf">
                </div>
            </div>
        
            <table class="w-full my-3 text-sm">
                <caption class="font-bold" >INFORME GLOBAL: Total Solicitudes {{$total}}</caption>
                <thead>
                    <tr class="py-2 px-2 font-bold text-center border border-gray-400 bg-blue-300">
                        <th class="pl-2">SECCIÓN</th>
                        <th class="pl-2">TOTAL</th>
                        <th class="pl-2">PETICIONES</th>
                        <th class="pl-2">QUEJAS</th>
                        <th class="pl-2">RECLAMOS</th>
                        <th class="pl-2">SUGERENCIAS</th>
                        <th class="pl-2">FELICITACIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse (Auth::user()->empresa->secciones as $seccioni)
                        <tr>
                            <td>{{$seccioni->nombre}}</td>
                            <td class="pl-2 text-center">{{totalSeccion($seccioni->id, $fechai, $fechaf)}}</td>
                            <td class="pl-2 text-center">{{totalSeccionTipo($seccioni->id, 1, $fechai, $fechaf)}}</td>
                            <td class="pl-2 text-center">{{totalSeccionTipo($seccioni->id, 2, $fechai, $fechaf)}}</td>
                            <td class="pl-2 text-center">{{totalSeccionTipo($seccioni->id, 3, $fechai, $fechaf)}}</td>
                            <td class="pl-2 text-center">{{totalSeccionTipo($seccioni->id, 4, $fechai, $fechaf)}}</td>
                            <td class="pl-2 text-center">{{totalSeccionTipo($seccioni->id, 5, $fechai, $fechaf)}}</td>                        
                        </tr>
                    @empty
                        
                    @endforelse
                </tbody>
            </table>
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
                                @forelse ($tipos as $tipo)
                                    {{totalesSeccionSolicitud($seccion_id, $tipo->id, $fechai, $fechaf)}}
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
                    @livewireScripts                    
                    @livewireChartsScripts

                </div>        
                @foreach ($tipos as $tipo)
                <div class="mt-10 h-full  print:border  print:border-black print:block">
                    {{solictudesTipo($seccion_id, $tipo->id, $fechai, $fechaf)}}     
                </div>                
                @endforeach                        
            </div>           
        </div> 
    @else
        <div class="w-full my-3 text-gray-400 text-center">
            Debe crear las dependencias de la empresa para visualizar los datos.
        </div>
    @endif
</div>
