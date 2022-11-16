<div class="px-5 py-5"
x-data="alertComponent()"
x-init="$watch('openAlertBox', value => {
  if(value){
    setTimeout(function () {
      openAlertBox = false
    }, 3000)
  }
})">

    <script src="/js/pdfjs/build/pdf.js"></script>
    <script src="/js/pdfjs/build/pdf.worker.js"></script>

    <script>
        window.alertComponent = function () {
            return {
                openAlertBox: false,
                alertBackgroundColor: '',
                alertMessage: '',
                showAlert(type) {
                this.openAlertBox = true
                switch (type) {
                    case 'success':
                    this.alertBackgroundColor = 'bg-success'
                    this.alertMessage = `${this.successIcon} ${this.defaultSuccessMessage}`
                    break

                }
                this.openAlertBox = true
                },
                successIcon: `<svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5 mr-2 text-white"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`,
                defaultSuccessMessage: `El documento ha sido radicado exitosamente`,
            }
        }
    </script>

@if (session()->has('message'))
<template x-if="openAlertBox">
  <div
    class="fixed bottom-0 right-0"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
  >
    <div class="p-10">
      <div class="flex items-center text-white text-sm font-bold px-4 py-3 rounded shadow-md" :class="alertBackgroundColor" role="alert">
        <span x-html="alertMessage" class="flex"></span>
        <button type="button" class="flex" @click="openAlertBox = false">
          <svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 ml-4"><path d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
      </div>
    </div>
  </div>
</template>
@endif
    <h1 class="font-bold text-lg">Expediente</h1>
    <div class="grid grid-cols-6 gap-3">
        <div class="col-span-2">
            <div class="py-2">
                <input type="search" class="w-full input input-primary" placeholder="Parámetro de busqueda:">
            </div>
            <table class="table table-compact text-xs w-full border-1">
                <caption class="font-bold">Listado de Expedientes</caption>
                <thead>
                    <tr>
                        <th class="text-xs">#</th>
                        <th class="text-xs">Fecha</th>
                        <th class="text-xs">Remitente</th>
                        <th class="text-xs">Asunto</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($expedientes as $expedientei)
                    <tr wire:click="seleccionar({{$expedientei->id}})" class="hover:border-2 hover:border-primarprimaryy cursor-pointer @if ($expediente_id ==$expedientei->id) border-2 @endif" >
                        <td>{{$expedientei->numero}}</td>
                        <td>{{$expedientei->entrada->fecha}}</td>
                        <td>{{ Str::limit($expedientei->entrada->solicitante->nombrecompleto, 15, '...')}}</td>
                        <td>{{Str::limit($expedientei->entrada->asunto,20,'...')}}</td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="3">
                            No existen expdientes abiertos
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
                {{$expedientes->links()}}
        </div>

        @if ($expediente)
        <div class="col-span-4 overflow-hidden bg-white shadow sm:rounded-lg text-sm">
            <div class="gap-3 px-4 py-5 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-primary">Detalle de expediente</h3>
                <div class="flex gap-3">
                    @if (!$boolAgregar and !$expediente->finalizada)
                    <div class="tooltip tooltip-right" data-tip="Agregar Archivo">
                        <button class="btn btn-sm btn-primary rounded-md shadow-lg" wire:click="Agregar(true);">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>

                        </button>
                    </div>
                    @endif
                    <h3> <span class="font-bold">Numero: </span>{{$expediente->numero}}</h3>
                    <h3> <span class="font-bold">Remitente: </span>{{$expediente->entrada->solicitante->nombrecompleto}}</h3>
                    <h3> <span class="font-bold">Estado:</span>  @if ($expediente->finalizada) Finalizada @else Activa @endif</h3>
                </div>
            </div>


            <div class="w-full border-t border-contenido">
                <dl>
                    <div class="px-4 py-1 sm:grid sm:grid-cols-5 sm:gap-4 sm:px-6">
                        <dt class="font-medium text-secondary"><h3 class="font-bold"></h3> </dt>
                        <dd class="mt-1 text-primary sm:col-span-2 sm:mt-0 font-bold">Entrada</dd>
                        <dd class="mt-1 text-primary sm:col-span-2 sm:mt-0 font-bold">Salida</dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-1 sm:grid sm:grid-cols-5 sm:gap-4 sm:px-6">
                        <dt class="font-medium text-secondary"><h3 class="font-bold">Fecha:</h3> </dt>
                        <dd class="mt-1 text-primary sm:col-span-2 sm:mt-0">{{$expediente->entrada->created_at}}</dd>
                        <dd class="mt-1 text-primary sm:col-span-2 sm:mt-0">{{$expediente->salida->created_at}}</dd>
                    </div>
                    <div class="px-4 py-1 sm:grid sm:grid-cols-5 sm:gap-4 sm:px-6">
                        <dt class="font-medium text-secondary"><h3 class="font-bold">Radicado:</h3> </dt>
                        <dd class="mt-1 text-primary sm:col-span-2 sm:mt-0">{{$expediente->entrada->radicado}}</dd>
                        <dd class="mt-1 text-primary sm:col-span-2 sm:mt-0">{{$expediente->salida->radicado}}</dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-1 sm:grid sm:grid-cols-5 sm:gap-4 sm:px-6">
                        <dt class="font-medium text-secondary"><h3 class="font-bold">Asunto:</h3> </dt>
                        <dd class="mt-1 text-primary sm:col-span-2 sm:mt-0">{{$expediente->entrada->asunto}}</dd>
                        <dd class="mt-1 text-primary sm:col-span-2 sm:mt-0">{{$expediente->salida->asunto}}</dd>
                    </div>
                    <div class="px-4 py-1 sm:grid sm:grid-cols-5 sm:gap-4 sm:px-6">
                        <dt class="font-medium text-secondary"><h3 class="font-bold">Adjunto:</h3> </dt>
                        <dd class="mt-1 text-primary sm:col-span-2 sm:mt-0">
                            @foreach ($expediente->entrada->seguimiento as $seguimientoi)
                            @if ($seguimientoi->adjunto)
                                <div>
                                    <a href="{{route('impdocumento',Crypt::encryptString($seguimientoi->id))}}" target="_blank" class="link">Ver Documento</a>
                                </div>
                            @endif
                            @endforeach
                        </dd>
                        <dd class="mt-1 text-primary sm:col-span-2 sm:mt-0">
                            @foreach ($expediente->salida->seguimiento as $seguimientoi)
                            @if ($seguimientoi->adjunto)
                                <div>
                                    <a href="{{route('impdocumento',Crypt::encryptString($seguimientoi->id))}}" target="_blank" class="link">Ver Documento</a>
                                </div>
                            @endif
                            @endforeach
                        </dd>
                    </div>
                </dl>
            </div>


            @if ($boolAgregar)
            <div class="py-2 my-2 border border-gray-300">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-3 px-3 py-2">
                    <div>
                        <label for="seccion_id" class="block text-gray-700 text-sm font-bold">Oficinas</label>
                        <select name="" wire:model="seccion_id" wire:change="buscarSerie();" class="w-full px-2 py-1 rounded-md shadow-lg">
                            @foreach ($seccion_empresa as $seccioni=>$nombre )
                                <option value="{{$seccioni}}">{{$nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="tipos_id" class="block text-gray-700 text-sm font-bold">Tipo de solictud</label>
                        <select id="tipos_id" name="" wire:model="serie_id" wire:change = "buscarSubSerie()" class="w-full px-2 py-1 rounded-md shadow-lg">
                            @foreach ($series as $serie=>$nombre )
                                <option value="{{$serie}}">{{$nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="">
                        <label for="subserie_id" class="block text-gray-700 text-sm font-bold">Subserie</label>
                        <select id="subserie_id" name="" wire:model="subserie_id" wire:change = "buscarTipologia()" class="w-full px-2 py-1 rounded-md shadow-lg">
                            @foreach ($subserie as $subseri)
                                <option value="{{$subseri->id}}">{{$subseri->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="">
                        <label for="tipologia_id" class="block text-gray-700 text-sm font-bold">Tipología</label>
                        <select id="tipologia_id" name="" wire:model="tipologia_id" class="w-full px-2 py-1 rounded-md shadow-lg" wire:change="obtenerDiasTermino();">
                            @foreach ($tipologia as $tipologi)
                                <option value="{{$tipologi->id}}">{{$tipologi->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="medio_id" class="block text-gray-700 text-sm font-bold">Medio de recepción</label>
                        <select name="" id="medio_id" wire:model.defer="medio_id" class="w-full px-2 py-1 rounded-md shadow-lg">
                            @foreach ($medio_recepcion as $medio)
                                <option value="{{$medio->id}}">{{$medio->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="diasTermino" class="block text-gray-700 text-sm font-bold">Días de término</label>
                        <input type="number" wire:model="diasTermino" id="diasTermino" class="w-full px-2 py-1 rounded-md shadow-lg">
                    </div>
                    <div>
                        <label for="destinatario" class="block text-gray-700 text-sm font-bold">Destinatario</label>
                        <input type="text" wire:model.defer="destinatario" id="destinatario" class="w-full px-2 py-1 rounded-md shadow-lg">
                    </div>
                    <div>
                        <label for="folios" class="block text-gray-700 text-sm font-bold">Folios</label>
                        <input type="number" wire:model.defer="folios" id="folios" class="w-full px-2 py-1 rounded-md shadow-lg">
                    </div>
                    <div>
                        <label for="anexos" class="block text-gray-700 text-sm font-bold">Anexos</label>
                            <input type="number" wire:model.defer="anexos" id="anexos" class="w-full px-2 py-1 rounded-md shadow-lg">
                    </div>
                    <div class="md:col-span-5">
                        <label for="asunto" class="block text-gray-700 text-sm font-bold">Asunto</label>

                        @error('asunto') <span class="text-error  block text-xs">{{ $message }}</span> @enderror
                        <textarea id="asunto" wire:model.defer="asunto" rows="2" class="w-full px-2 py-1 rounded-md shadow-lg"></textarea>
                    </div>
                    <!--div class="md:col-span-2">
                        <p><input type="checkbox" wire:model.defer="confidencial" class="px-2 py-1 rounded-md shadow-lg"> Marcar como confindencial.</p>
                        <input type="checkbox" wire:model="copia_radicado" class="px-2 py-1 rounded-md shadow-lg"> Copia de radicado a:
                        @if ($copia_radicado)
                        <div class="py-2 px-2 mt-2 w-full border-2 rounded-lg">
                            @foreach ($seccionCopia as $seccion)
                                <div class="block">
                                    <h1 class="font-bold">{{$seccion->nombre}}</h1>
                                    @foreach ($seccion->usuarios as $usuario)
                                        <p>

                                        </p>
                                        <input type="checkbox" wire:model='usercopias.{{$usuario->user_id}}' name="usercopias[]" id="" value="{{$usuario->user_id}}">{{$usuario->user->name}}
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                        @endif
                    </!--div-->
                    <div class="md:col-span-3">
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
                                        <button class="btn btn-success" @click="showAlert('success')" wire:click="radicar()">Actualizar Expediente</button>
                                        <button class="btn btn-warning" wire:click="Agregar(false)">Cancelar</button>
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

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif


            <div class="pt-3 px-3">
                <h3 class="font-bold py-1 uppercase">Documentos de expediente</h3>
                <table class="table table-compact table-zebra w-full text-sm">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Oficina</th>
                            <th>Clasificación</th>
                            <th>Recepción</th>
                            <th>Folios</th>
                            <th>Asunto</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($expediente->detalles as $detalle)
                        <tr>
                            <td>{{$detalle->created_at->format('Y/m/d')}}</td>
                            <td>{{$detalle->seccionempresa->nombre}}</td>
                            <td>
                                <p>{{$detalle->serie->nombre}}</p>
                                <p>{{$detalle->subserie->nombre}}</p>
                                <p>{{$detalle->tipologia->nombre}}</p>
                            </td>
                            <td></td>
                            <td>{{$detalle->folios}}</td>
                            <td>{{$detalle->asunto}}</td>
                            <td><a target="_blank" href="{{url(Storage::url('public/'.$detalle->adjunto))}}">Ver</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            <div class="md:col-span-3 pt-3 px-3 py-3">
                <button class="btn btn-primary" wire:click="boolCerrar(true);">
                    Cerrar Expediente
                </button>
            </div>
        </div>
        @endif
    </div>

    <x-jet-dialog-modal wire:model="modalFormVisible1" >
        <x-slot name="title">
            Cerrar Expediente
        </x-slot>

        <x-slot name="content">
            <div class="pt-2">
                ¿Desear cerrar el expediente?
            </div>
        </x-slot>

        <x-slot name="footer">
            <button wire:click="$toggle('modalFormVisible1')" wire:loading.attr="disabled" class="btn btn-warning">
                Cancelar
            </button>

            <button class="ml-2 btn btn-primary" wire:click="enviarMensaje()" wire:loading.attr="disabled" >
                Cerrar Expediente
            </button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
