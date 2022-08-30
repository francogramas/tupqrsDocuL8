@if ($s->count()>0)
<div class="text-sm border">
    <div class="py-2 text-lg font-bold text-gray-600 block v-screen text-center border" id="{{$t->nombre}}">
        {{$t->nombre}}
    </div>
    <div class="block w-full">
        <div class="grid grid-cols-2 gap-3 border">
            <div class="font-bold text-lg text-center">Fecha/Solicitante</div>
            <div class="font-bold text-lg text-center">Solicitud</div>
        </div>

        @forelse ($s as $s1)
        <div class="grid grid-cols-2 gap-3 py-2 px-2 border">
            <div title="{{$s1->estado->nombre}}">
                <span class="font-bold">{{$s1->radicado}}</span> / {{$s1->created_at->format('Y/m/d')}}<br>
                {{$s1->subserie->serie->nombre}} / {{$s1->subserie->nombre}} / {{$s1->tipologia->nombre}}<br>
                {{$s1->solicitante->nombrecompleto}}
            </div>
            <div>
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
                                <div class="flex align-middle">
                                    <span class="font-semibold text-gray-800"> Adjunto</span> ->
                                    <a target="_blank" href="{{route('impdocumento',Crypt::encryptString($seguimiento->id))}}">
                                        <img src="src/img/pdf.svg" class="w-6" alt="">
                                    </a>

                                </div>
                                @endif
                        @endforeach
                        </div>
            </div>
        </div>
        @empty

        @endforelse
    </div>
</div>
@endif
