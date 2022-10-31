<div
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

    @if ($etapa==0)
        <div class="grid grid-cols-1 md:grid-cols-5 gap-5">
            <button class="w-full mx-2 my-2 btn btn-primary rounded-lg shadow-lg hover:bg-blue-700" wire:click="siguienteSolictud(1)">Radicar solicitud</button>
        </div>

        <div class="py-2 px-2 ">
            <h1 class="text-lg font-bold">Historial de radicados pendientes por responder</h1>
            <div class="py-2">
                <input type="search" wire:model="param" class="rounded-md shadow-md px-2 w-full" placeholder="Buscar documento radicado" autocomplete="off">
            </div>

            <div class="py-2 gap-4 flex flex-row">
                <div class="flex flex-row cursor-pointer">
                    <x-jet-nav-link href="#" :active="$filtro==0" wire:click="filtrar(0)">
                        <div class="w-4 h-4 rounded-full mt-1 mx-1 bg-success "></div>{{'Todos: '.$total}}
                    </x-jet-nav-link>
                </div>
                @foreach ($totales as $totali)
                <div class="flex flex-row cursor-pointer">
                    <x-jet-nav-link href="#" :active="$filtro==$totali->estado_id" wire:click="filtrar({{$totali->estado_id}})">
                        <div class="w-4 h-4 rounded-full mt-1 mx-1 @if ($totali->estado_id==1)bg-success
                            @elseif($totali->estado_id==2)bg-warning
                            @elseif($totali->estado_id==3)bg-error
                            @elseif($totali->estado_id==4)bg-primary
                            @elseif($totali->estado_id==5)bg-primary
                            @endif "></div>{{$totali->estado. ': '.$totali->total}}
                    </x-jet-nav-link>
                </div>
                @endforeach

            </div>

            <div class="py-2">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border border-t-1 border-black font-bold">
                            <td class="px-2"></td>
                            <td class="px-2">Radicado</td>
                            <td class="px-2">Fecha</td>
                            <td class="px-2">Vence</td>
                            <td class="px-2">Recepción</td>
                            <td class="px-2">Clase</td>
                            <td class="px-2">Dependencia</td>
                            <td class="px-2">Remitente</td>
                            <td class="px-2">Destinatario</td>
                            <td class="px-2">Asunto</td>
                            <td class=""></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($solicitudes as $solicitud)
                        @php

                        if($solicitud->estado_id==1){
                                $clase = 'btn-success';
                            }
                            elseif ($solicitud->estado_id==2) {
                                $clase = 'btn-warning';
                            }
                            elseif ($solicitud->estado_id==3) {
                                $clase = 'btn-error';
                            }
                            elseif ($solicitud->estado_id==4) {
                                $clase = 'btn-error';
                            }
                            elseif ($solicitud->estado_id==5) {
                                $clase = 'btn-error';
                            }
                        @endphp

                        <tr class="border border-t-1 border-black hover:bg-gray-300">
                            <td class="px-2">
                                <div class="w-4 h-4 rounded-full {{$clase}}"></div>
                            </td>
                            <td class="px-2">{{$solicitud->radicado}}</td>
                            <td class="px-2">{{$solicitud->fecha}}</td>
                            <td class="px-2">{{Carbon\Carbon::createFromFormat('Y-m-d', $solicitud->fecha)->addDays($solicitud->diasTermino)->format('Y-m-d')}}</td>
                            <td class="px-2">{{$solicitud->medio->nombre}}</td>
                            <td class="px-2">{{$solicitud->tipologia->nombre}}</td>
                            <td class="px-2">{{$solicitud->seccionempresa->nombre}}</td>
                            <td class="px-2">{{$solicitud->solicitante->nombrecompleto}}</td>
                            <td class="px-2">{{$solicitud->destinatario}}</td>
                            <td class="px-2">{{Str::limit($solicitud->asunto, 50, '...') }}</td>
                            <td class="flex flex-row">
                                <a href="#" class="text-gray-500" onclick="window.open('{{route('impdocumento',Crypt::encryptString(seguimientoRadicado($solicitud->id)))}}','Imprimir Radicado','width=600,height=400')" title="Imprimir Radicado">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $solicitudes->links() }}

            </div>
        </div>

    @elseif ($etapa==1)

    <!-- ------------------------------ Formulario de identifcación ----------------------- -->
    <div class="text-gray-700 font-bold text-lg px-2 text-center mb-5">
        <h1>Bienvenido al sistema para gestión de solictudes de {{$empresa->razonsocial}}</h1>
    </div>
    <p class="px-4 py-1">
        Para realizar una solicitud primero debe identificarse, por favor diligencie el formulario:
    </p>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 px-3 py-2">
        <div class="px-2">
            <label for="tipo_documento" class="block text-gray-700 text-sm font-bold">Tipo de documento</label>
            @error('tipo_documento') <span class="text-error  block text-xs">{{ $message }}</span> @enderror
            <select wire:model.defer="tipo_documento" id="tipo_documento" class="w-full px-2 py-1 rounded-md shadow-lg">
                @foreach ($tipodocumento as $tipo)
                    <option value="{{$tipo->id}}">{{$tipo->descripcion}}</option>
                @endforeach
            </select>
        </div>
        <div class="px-2">
            <label for="documento" class="block text-gray-700 text-sm font-bold"># de documento</label>
            @error('documento') <span class="text-error  block text-xs">{{ $message }}</span> @enderror
            <input id="documento" wire:model="documento" wire:change="buscarSolicitante()" type="number" class="w-full px-2 py-1 rounded-md shadow-lg">
        </div>
        <div class="px-2">
            <label for="tipo_usuario_id" class="block text-gray-700 text-sm font-bold">Tipo de Solicitante/Remitente</label>
            @error('tipo_usuario_id') <span class="text-error  block text-xs">{{ $message }}</span> @enderror
            <select wire:model="tipo_usuario_id" id="tipo_usuario_id" class="w-full px-2 py-1 rounded-md shadow-lg">
                @foreach ($tipo_usuarios as $tipo_usuario)
                    <option value="{{$tipo_usuario->id}}">{{$tipo_usuario->nombre}}</option>
                @endforeach
            </select>
        </div>
        <div class="px-2">
            <label for="nombrecompleto" class="block text-gray-700 text-sm font-bold">Nombre completo</label>
            @error('nombrecompleto') <span class="text-error  block text-xs">{{ $message }}</span> @enderror
            <input id="nombrecompleto" wire:model.defer="nombrecompleto" type="text" class="w-full px-2 py-1 rounded-md shadow-lg">
        </div>
        <div class="px-2">
            <label for="telefono" class="block text-gray-700 text-sm font-bold">Celular</label>
            @error('telefono') <span class="text-error  block text-xs">{{ $message }}</span> @enderror
            <input id="telefono" wire:model.defer="telefono" type="tel" class="w-full px-2 py-1 rounded-md shadow-lg" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
        </div>
        <div class="px-2">
            <label for="email" class="block text-gray-700 text-sm font-bold">Correo electrónico</label>
            @error('email') <span class="text-error  block text-xs">{{ $message }}</span> @enderror
            <input id="email" wire:model.defer="email" type="email" class="w-full px-2 py-1 rounded-md shadow-lg">
        </div>
        <div class="py-1 px-2">
            <label class="block text-gray-700 text-sm font-bold" for="">Departamento</label>
            <select name="estado_id" wire:model="estado_id" wire:change="cargarciudades()" id="" class="w-full px-2 py-1 rounded-md shadow-lg">
                @foreach ($estados as $estado)
                    <option value="{{$estado->id}}">{{$estado->estado}}</option>
                @endforeach
            </select>
        </div>
        <div class="py-1 px-2">
            <label class="block text-gray-700 text-sm font-bold" for="">Ciudad</label>
            @error('ciudad_id') <span class="text-error  block text-xs">{{ $message }}</span> @enderror
            <select name="" wire:model="ciudad_id" id="" class="w-full px-2 py-1 rounded-md shadow-lg">
                @foreach ($ciudades as $ciudad)
                    <option value="{{$ciudad->id}}">{{$ciudad->ciudad}}</option>
                @endforeach
            </select>
        </div>
        <div class="py-1 px-2">
            <label for="direccion" class="block text-gray-700 text-sm font-bold">Dirección Completa</label>
            @error('direccion') <span class="text-error  block text-xs">{{ $message }}</span> @enderror
            <input id="direccion" wire:model.defer="direccion" type="text" class="w-full px-2 py-1 rounded-md shadow-lg">
        </div>
        <div class="px-2 flex gap-2">
            <button id="btnguardar" wire:click="guardarSolicitante()"  class="w-1/2 btn btn-sm mt-5 btn-primary">Continuar</button>
            <button id="btnguardar" wire:click="finalizarRadicado()"  class="w-1/2 btn btn-sm mt-5 btn-warning">Cancelar</button>
        </div>
    </div>
    @elseif ($etapa==2)
    <!-- ------------------------------ Formulario de Radicación ----------------------- -->
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
            <p><input type="checkbox" wire:model.defer="confidencial" class="px-2 py-1 rounded-md shadow-lg"> Marcar como confindencial el Radicado.</p>
            <p><input type="checkbox" wire:model.defer ="respuesta_email" class="px-2 py-1 rounded-md shadow-lg"> ¿Usted autoriza recibir respuesta por medio de correo electrónico?</p>
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
                    <div>

                    </div>

                </div>
            </div>

            </div>

        </div>

    </div>
    @elseif ($etapa==3)
    <!-- ------------------------------ Formulario de Impresión y finalización ----------------------- -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 px-3 py-2">
        <div class="px-2 py-1">
        </div>
        <div class="px-2 py-1">
            <a href="#" class="w-full flex flex-row px-2 py-3 btn btn-primary shadow-lg" onclick="window.open('{{route('impdocumento',Crypt::encryptString($seguimiento))}}','Imprimir Radicado','width=600,height=400')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                        </svg>
                    Imprimir Radicado
            </a>
        </div>
        <div class="px-2 py-1">
            <a wire:click="finalizarRadicado()" class="w-full flex flex-row px-2 py-3 shadow-lg btn btn-primary" onclick="window.open('{{route('impdocumento',Crypt::encryptString($seguimiento))}}','Imprimir Radicado','width=600,height=400')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z" />
                    <path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd" />
                  </svg>
                Finalizar Radicado
            </a>
        </div>
        <div class="px-2 py-1">
        </div>
    </div>
    @endif



</div>
