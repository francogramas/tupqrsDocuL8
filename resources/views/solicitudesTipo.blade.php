@if ($s->count()>0)
    <div class="py-2 text-lg font-bold text-gray-600 block v-screen" id="{{$t->nombre}}">
        {{$t->nombre}}
    </div>
    <div class="py-1 block w-full">
        <table class="text-xs w-full table table-compact">
            <caption class="border font-semibold"></caption>
            <thead>
                <tr class="py-1 px-2 font-bold text-center border border-gray-400 bg-blue-300">
                    <th class="pl-2 text-center">Fecha/Solicitante</th>
                    <th class="pl-2 text-center">Solicitud</th>                                       
                </tr>
            </thead>
            <tbody>
                @forelse ($s as $s1)
                <tr class="py-1 border border-gray-500 @if($s1->estado_id==1) bg-green-100 @elseif($s1->estado_id==2) bg-yellow-100 @elseif($s1->estado_id==3) bg-red-100 @elseif($s1->estado_id==4) bg-gray-100 @endif">
                    <td class="pl-2 text-left" title="{{$s1->estado->nombre}}">
                       <span class="font-bold">{{$s1->radicado}}</span> / {{$s1->created_at->format('Y/m/d')}}<br>
                        {{$s1->subserie->serie->nombre}} / {{$s1->subserie->nombre}} / {{$s1->tipologia->nombre}}<br>
                        {{$s1->solicitante->nombrecompleto}}
                    </td>
                    <td class="pl-2 text-left">
                        <span class="font-bold">Asunto:</span>
                        {{$s1->asunto}}                        
                        <div class="block">
                        @foreach ($s1->seguimiento as $seguimiento)                            
                                <div class="font-bold">
                                    {{$seguimiento->created_at->format('M d/Y').' -> '. $seguimiento->accion->nombre}}
                                </div>
                                @if ($seguimiento->mensaje)
                                <div>
                                    {!!'<span class="font-semibold text-gray-800"> Mensaje</span> -> '. $seguimiento->mensaje!!}
                                </div>
                                @endif   
                                @if ($seguimiento->observaciones)
                                <div>
                                    {!!'<span class="font-semibold text-gray-800"> Observaciones</span> -> '. $seguimiento->observaciones!!}
                                </div>
                                @endif      
                                @if ($seguimiento->adjunto)
                                <div>
                                    {!!'<span class="font-semibold text-gray-800"> Adjunto</span> -> '. $seguimiento->adjunto!!}
                                </div>
                                @endif                                                  
                        @endforeach
                        </div>
                    </td>                    
                </tr>
                @empty
                    
                @endforelse        
            </tbody>
        </table> 
    </div>
@endif
