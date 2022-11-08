<div class="px-5 py-5">
    <h1 class="font-bold text-lg">Expediente</h1>
    <div class="grid grid-cols-6 gap-3">

        <div class="col-span-2">
            <table class="table table-compact text-xs">
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
                    @forelse ($expedientes as $expediente)
                    <tr>
                        <td>{{$expediente->numero}}</td>
                        <td>{{$expediente->entrada->fecha}}</td>
                        <td>{{ Str::limit($expediente->entrada->solicitante->nombrecompleto, 15, '...')}}</td>
                        <td>{{Str::limit($expediente->entrada->asunto,20,'...')}}</td>
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

        <div class="col-span-4">
            <h3 class="font-bold">Detalle de expediente</h3>
            <h3 class="font-bold">Documentos de expediente</h3>
            <div>
                <button class="btn btn-primary">Agregar archivo</button>
            </div>
            <div>
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
                        <label for="fecha" class="block text-gray-700 text-sm font-bold">Fecha</label>
                        <input type="date" wire:model.defer="fecha" id="fecha" class="w-full px-2 py-1 rounded-md shadow-lg">
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
                    <div class="md:col-span-2">
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
                    </div>
                    <div class="md:col-span-3">
                        <label for="" class="block text-gray-700 text-sm font-bold">Descripción de adjunto</label>
                        <input type="text" wire:model.defer="descripcion" class="w-full px-2 py-1 rounded-md shadow-lg">

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
                                        <button class="btn btn-success w-44" @click="showAlert('success')" wire:click="radicar()">Radicar solicitud</button>
                                        <button class="btn btn-warning w-44" wire:click="finalizarRadicado()">Canclear</button>
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
        </div>
    </div>

</div>
