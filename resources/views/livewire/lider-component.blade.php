<div class="px-5 pt-5 text-sm">
    <script src="/js/pdfjs/build/pdf.js"></script>
    <script src="/js/pdfjs/build/pdf.worker.js"></script>
    @if (!is_null($seccion_empresaTodos))
    <div class="grid grid-cols-1 md:grid-cols-6 gap-3">
        <div class="grid grid-cols-1 border px-2 py-2">
            <div class="mb-2">
                <label for="" class="block text-gray-700 text-sm font-bold">Dependencias</label>
                <select wire:model="secciones_u_id" id="secciones_u_id" class="w-full mb-2" wire:change="consultarSeries();">
                    @foreach ($seccion_empresaTodos as $seccion)
                        <option value="{{$seccion->id}}">{{$seccion->nombre}}</option>
                    @endforeach
                </select>
            <div class="divide-y divide-gray-500 rounded-md shadow-lg border px-2 py-2">
            @foreach ($series as $seriei)
                <div class="w-full cursor-pointer flex text-xs gap-1 @if($seriei->id == $serie_id) bg-contenido @endif" wire:click="solicitudes({{$seriei->id}})">
                    <div class="hover:bg-contenido rounded-2xl w-full px-2 py-1">
                        {{$seriei->nombre}} <span class="badge badge-error text-xs text-white font-semibold">{{totalSolicitudes($seriei->id, $secciones_u_id)}}</span>
                    </div>
                </div>
            @endforeach
            </div>
            </div>
        </div>
        <div class="rounded-md shadow-lg border px-2 py-2">
            <div class="">
                <label for="" class="block text-gray-700 text-sm font-bold">Solicitudes</label>
                @forelse($solicitud as $sol)
                    <button wire:click="verSolicitud({{$sol->id}})" class="w-full text-left py-1 px-1 cursor-pointer border shadow-md hover:bg-contenido  @if($sol->id == $solicitudi->id) bg-contenido @endif">
                        <a href="#respuesta">
                            <p class="text-gray-700 text-sm font-semibold">{{Str::limit($sol->solicitante->nombrecompleto,20)}}</p>
                            <p class="text-gray-700 text-xs">{{Str::limit($sol->asunto, 25, '...') }}</p>
                            <p class="text-gray-500 text-xs text-right flex">

                                @if($sol->estado_id==1)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-success" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                      </svg>
                                @elseif($sol->estado_id==2)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-warning" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                @elseif($sol->estado_id==3)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-error" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                @endif
                                {{$sol->created_at->format('d/m/Y')}}

                            </p>
                        </a>
                    </button>
                @empty
                    <p class="px-2 py-2">No tienes compromisos por responder</p>
                @endforelse
                <div></div>
            </div>
        </div>

        <div class="col-span1 md:col-span-3" id="respuesta">
            @isset($solicitudi)
            <div class="rounded-lg shadow-ld border px-2 py-2">
                <h3 class="font-bold text-gray-700 text-lg">Descripción de la solicitud:</h3>
                <div class="text-sm text-gray-500 grid grid-cols-1 md:grid-cols-3">
                    <div class="mr-2">
                        <div class="font-bold">Solicitante:</div> {{$solicitudi->solicitante->nombrecompleto}}
                    </div>
                    <div class="mr-2"><div class="font-bold">Estado:</div> {{$solicitudi->estado->nombre}} </div>
                    <div class="mr-2 flex">
                        <div class="px-1">
                            <a href="{{route('impradicado',Crypt::encryptString($solicitudi->id))}}" target="_blank" title="imprimir radicado">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                </svg>
                            </a>
                        </div>
                        <div class="font-bold">Radicado:</div> {{$solicitudi->radicado}}
                    </div>
                    <div class="mr-2"><div class="font-bold">Serie:</div> {{$solicitudi->subserie->serie->nombre}} </div>
                    <div class="mr-2"><div class="font-bold">Subserie:</div> {{$solicitudi->subserie->nombre}} </div>
                    <div class="mr-2"><div class="font-bold">Tipología:</div> {{$solicitudi->tipologia->nombre}} </div>
                </div>

                <p class="text-gray-700 mt-2">
                    <span class="font-bold mt-2">Asunto:</span> {{$solicitudi->asunto}}
                </p>

                @forelse ($solicitudi->seguimiento as $seguimiento)


                        <div class="block p-2 border border-gray-400 mt-2 text-sm">
                            <div class="text-base font-bold text-gray-700">
                                {{$seguimiento->accion->nombre}}
                            </div>
                            <!--p class="text-gray-700">
                                <span class="font-bold">Mensaje: </span>{{$seguimiento->mensaje}}
                            </p-->
                            @if ($seguimiento->observaciones)
                            <p class="text-gray-700">
                                <span class="font-bold">Observaciones: </span>{{$seguimiento->observaciones}}
                            </p>
                            @endif

                            <p class="text-gray-500">
                                {{$seguimiento->created_at->format('M d/Y')}}
                            </p>
                            @if (Str::length($seguimiento->adjunto)>0)
                                <a class="font-bold mt-2  flex " href="{{route('impdocumento',Crypt::encryptString($seguimiento->id))}}" target="_blank">
                                    Documento adjunto: <button class="bg-blue-300 text-gray-800 font-bold mx-2 px-2 py-1 flex rounded">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                            </svg>
                                            Ver
                                    </button>
                                </a>
                            @endif
                        </div>
                @empty
                @endforelse

                @if (!$solicitudi->revision)

                    <div class="mt-2">
                        @error('respuesta') <span class="error text-error ">{{ '*'.$message }}</span> @enderror
                        <textarea wire:model.defer="respuesta" class="mt-2 rounded-md resize-none w-full h-full border shadow-lg px-2 py-2" rows="4" placeholder="Diligencie la respuesta a la solicitud"></textarea>
                    </div>
                    <div class="mt-2">
                        @error('observaciones') <span class="error text-error ">{{ '*'.$message }}</span> @enderror
                        <textarea wire:model.defer="observaciones" class="mt-2 rounded-md resize-none w-full h-full border shadow-lg px-2 py-2" rows="2" placeholder="Observaciones"></textarea>
                    </div>
                    <div>
                        <label for="" class="block text-gray-700 text-sm font-bold">Adjuntar archivo</label>
                        <div class="gap-2 py-2">
                            <div class="flex gap-2 py-2">
                                @error('adjunto') <span class="text-error  block text-xs">{{ $message }}</span> @enderror

                                <div x-data="{ isUploading: false, progress: 0 }"
                                    x-on:livewire-upload-start="isUploading = true"
                                    x-on:livewire-upload-finish="isUploading = false"
                                    x-on:livewire-upload-error="isUploading = false"
                                    x-on:livewire-upload-progress="progress = $event.detail.progress">
                                    <!-- File Input -->
                                    <input type="file" id="pdf-file" wire:model="adjunto" accept="application/pdf" style="display:none" />

                                    <!-- Progress Bar -->
                                    <div x-show="isUploading">
                                        <p>Cargando Archivo...</p>
                                        <progress class="progress progress-success w-56" x-bind:value="progress" max="100"></progress>
                                    </div>
                                    <div x-show="!isUploading">
                                        <button id="upload-dialog" class="btn btn-primary">Seleccionar archivo</button>
                                    </div>
                                    <div>
                                    <div x-show="!isUploading">
                                        <div wire:ignore>
                                            <div id="pdf-loader" style="display:none">Cargando previsualización ..</div>
                                            <canvas id="pdf-preview" width="350" style="display:none" class="border-2 mt-3"></canvas>
                                            <script>
                                                // will hold the PDF handle returned by PDF.JS API
                                                var _PDF_DOC;

                                                // PDF.JS renders PDF in a <canvas> element
                                                var _CANVAS = document.querySelector('#pdf-preview');

                                                // will hold object url of chosen PDF
                                                var _OBJECT_URL;

                                                // load the PDF
                                                function showPDF(pdf_url) {
                                                    PDFJS.getDocument({ url: pdf_url }).then(function(pdf_doc) {
                                                        _PDF_DOC = pdf_doc;

                                                        // show the first page of PDF
                                                        showPage(1);

                                                        // destroy previous object url
                                                        URL.revokeObjectURL(_OBJECT_URL);
                                                    }).catch(function(error) {
                                                        // error reason
                                                        alert(error.message);
                                                    });;
                                                }

                                                // show page of PDF
                                                function showPage(page_no) {
                                                    _PDF_DOC.getPage(page_no).then(function(page) {
                                                        // set the scale of viewport
                                                        var scale_required = _CANVAS.width / page.getViewport(1).width;

                                                        // get viewport of the page at required scale
                                                        var viewport = page.getViewport(scale_required);

                                                        // set canvas height
                                                        _CANVAS.height = viewport.height;

                                                        var renderContext = {
                                                            canvasContext: _CANVAS.getContext('2d'),
                                                            viewport: viewport
                                                        };

                                                        // render the page contents in the canvas
                                                        page.render(renderContext).then(function() {
                                                            document.querySelector("#pdf-preview").style.display = 'inline-block';
                                                            document.querySelector("#pdf-loader").style.display = 'none';
                                                        });
                                                    });
                                                }

                                                /* showing upload file dialog */
                                                document.querySelector("#upload-dialog").addEventListener('click', function() {
                                                    document.querySelector("#pdf-file").click();
                                                });

                                                /* when users selects a file */
                                                document.querySelector("#pdf-file").addEventListener('change', function() {
                                                    // user selected PDF
                                                    var file = this.files[0];

                                                    // allowed MIME types
                                                    var mime_types = [ 'application/pdf' ];

                                                    // validate whether PDF
                                                    if(mime_types.indexOf(file.type) == -1) {
                                                        alert('Error : Incorrect file type');
                                                        return;
                                                    }

                                                    // validate file size
                                                    if(file.size > 24*1024*1024) {
                                                        alert('Error : Exceeded size 10MB');
                                                        return;
                                                    }

                                                    // validation is successful

                                                    // hide upload dialog
                                                    document.querySelector("#upload-dialog").style.display = 'none';

                                                    // show the PDF preview loader
                                                    document.querySelector("#pdf-loader").style.display = 'inline-block';

                                                    // object url of PDF
                                                    _OBJECT_URL = URL.createObjectURL(file)

                                                    // send the object url of the pdf to the PDF preview function
                                                    showPDF(_OBJECT_URL);
                                                });
                                            </script>
                                        </div>
                                    </div>
                                    </div>
                                <div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <label for="" class="block text-gray-700 text-sm font-bold">Acciones</label>
                        <select class="w-full" wire:model="accion_id" id="accion_id">
                            @foreach ($acciones as $accion)
                                <option value="{{$accion->id}}">{{$accion->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    @if ($accion_id == 3 and !is_null($seccion_id))
                        <div class="mt-2">
                            <label for="" class="block text-gray-700 text-sm font-bold">Dependencia/Sección</label>
                            <select class="w-full" wire:model="seccion_id" id="seccion_id">
                                @foreach ($seccion_empresa as $seccion)
                                    <option value="{{$seccion->id}}">{{$seccion->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="my-3 ">
                        <button wire:click="responder()" class="w-full btn btn-primary shadow-lg rounded-md">ENVIAR RESPUESTA</button>
                    </div>
                @endif
            </div>
            @endisset
        </div>

        <div class="container mx-auto w-full h-full">
            <div class="relative wrap overflow-hidden pt-7 pl-7 h-full w-full">
              <div>
                <h3 class="mb-2 font-bold text-gray-800 text-base">Solicitudes Pendientes({{totalSolicitudesSeccion($secciones_u_id, true)}})</h3>
                @forelse($pendientes as $sol1)

                    <button wire:click="verSolicitud({{$sol1->salida->id}})" class="w-full text-left py-1 px-1 cursor-pointer border shadow-md hover:bg-contenido  ">
                        <a href="#respuesta">
                            <p class="text-gray-700 text-sm font-semibold">{{Str::limit($sol1->salida->solicitante->nombrecompleto,20)}}</p>
                            <p class="text-gray-700 text-xs">{{Str::limit($sol1->salida->asunto, 25, '...') }}</p>
                            <p class="text-gray-500 text-xs text-right flex">

                                @if($sol1->salida->estado_id==1)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-success" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @elseif($sol1->salida->estado_id==2)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-warning" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                @elseif($sol1->salida->estado_id==3)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-error" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                @endif
                                {{$sol1->salida->created_at->format('d/m/Y')}}

                            </p>
                        </a>
                    </button>
                @empty
                    <p class="px-2 py-2">No tienes compromisos por responder</p>
                @endforelse
              </div>
              <div wire:poll.30s='finalizadas()'>
                <h3 class="mb-2 font-bold text-gray-800 text-base">Solicitudes Resueltas</h3>
                @forelse($resueltas as $resu)

                    <a href="{{url('impoficio', Crypt::encryptString($resu->salida->seguimiento->last()->id)) }}" class="block border shadow-md hover:bg-contenido  ">
                        <p class="text-gray-700 text-sm font-semibold">{{Str::limit($resu->salida->solicitante->nombrecompleto,20)}}</p>
                        <p class="text-gray-700 text-xs">{{Str::limit($resu->salida->asunto, 25, '...') }}</p>
                        <p class="text-gray-500 text-xs text-right flex">

                            @if($resu->salida->estado_id==1)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-success" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @elseif($resu->salida->estado_id==2)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-warning" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            @elseif($resu->salida->estado_id==3)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-error" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            @endif
                            {{$resu->salida->created_at->format('d/m/Y')}}

                        </p>
                    </a>
                @empty
                    <p class="px-2 py-2">No tienes compromisos por responder</p>
                @endforelse
              </div>
                @isset($solicitudi)
                    <h3 class="mb-2 font-bold text-gray-800 text-base">Historial de la solicitud</h3>
                    <div class="border-2-2 absolute border-dashed border-blue-500 h-full border" style="left: 5.8%"></div>
                    @forelse ($solicitudi->seguimiento as $seguimiento)
                        <!-- First timeline -->
                        <button class="w-full text-right">
                        <div class="mb-1 flex justify-between items-center w-full">
                            <div class="order-2"></div>
                            <div class="z-20">
                            <div class="my-4 rounded-full h-8 w-8 flex items-center bg-indigo-300 ring-4 ring-indigo-400 ring-opacity-30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            </div>
                            <div class="order-1 @if ($seguimiento->estado_id==1) bg-green-300 @elseif($seguimiento->estado_id==2) bg-yellow-300 @elseif ($seguimiento->estado_id==3) bg-red-300 @endif opacity-70 rounded-lg shadow-xl w-full px-3 py-1">
                            <div class="flex flex-row">
                                <h3 class="mb-1 font-bold text-gray-800 text-sm">{{$seguimiento->accion->nombre}}</h3>
                            </div>
                            <p class="leading-snug tracking-wide text-gray-900 text-opacity-100 text-xs">{{$seguimiento->created_at->format('M d/Y')}} - {{$seguimiento->user->name}}</p>
                            </div>
                        </div>
                        </button>
                    @empty
                @endforelse
                @endisset

            </div>
          </div>
    </div>
    @else
        <p class="px-2 py-2">No tienes compromisos por responder</p>
    @endif
</div>
