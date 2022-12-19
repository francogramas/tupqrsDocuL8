<?php

namespace App\Http\Livewire;
use Livewire\Component;
use App\Models\Tipodocumento;
use App\Models\Solicitante;
use App\Models\SeccionUser;
use App\Models\Estado;
use App\Models\Ciudade;
use App\Models\SeccionEmpresa;
use App\Models\TipoUsuario;
use App\Models\MedioRecepcion;
use App\Models\Solicitud;
use App\Models\Subserie;
use App\Models\TipologiaDocumento;
use App\Models\solicitudCopia;
use App\Models\SeguimientoOrden;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use App\Mail\solicitudMail;
use App\Models\empresa;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use App\Models\User;


/**
 *  TODO: EL PREFIJO DE LOS RADICADOS DEBEN SER INTERNOs(I)
 *  TODO: CREAR UNA HERRAMIENTA DE RADICADO MASIVO PARA SOLICITUDES DE LA VENTANILLA VIRTUAL
 *  TODO: GENERAR UNA PLANTILLA DE RESPUESTA INSTITUCIONAL(EMAILS)
 *
**/


class VentanillaComponent extends Component
{
    use WithFileUploads;
    use WithPagination;
    public $empresa, $empresa_id, $tiposolicitud, $solicitante, $solicitante_id, $tipodocumento, $etapa, $documento, $nacimiento, $nombrecompleto,
    $telefono, $email, $modalFormVisible, $mensaje, $tipo_documento, $seccion_id, $adjunto,
    $asunto, $anos, $ano, $meses, $mes, $dias, $dia, $estados, $estado_id, $ciudades, $ciudad_id, $direccion, $seccion_empresa,
    $tipo_usuarios, $tipo_usuario_id, $medio_recepcion, $medio_id, $fecha, $copia_radicado, $seccionCopia, $seccionCopia_id,
    $tipos_id, $confidencial, $respuesta_email, $diasTermino, $solicitudi, $descripcion, $series, $serie_id, $subserie, $subserie_id, $tipologia,
    $tipologia_id, $tipoProceso, $max_consecutivo, $destinatario, $folios, $anexos, $param, $filtro, $solicitud1, $copias, $seguimiento, $usercopias;



    public function mount()
    {
        $this->empresa_id = Auth::user()->empresaUser->empresa_id;
        $this->empresa = empresa::find($this->empresa_id);

        $this->tipodocumento = Tipodocumento::all();
        $this->tipo_documento = Tipodocumento::first()->id;
        // $this->anos = range(now()->year-100, now()->year);
        //$this->ano = now()->year-30;
        //$this->dias = range(1,31);
        //$this->dia = 1;
        //$this->mes = 1;
        $this->tipoProceso = 1;

        $this->estados=Estado::all()->sortBy('estado');
        $this->estado_id=1;
        $this->ciudades = Ciudade::where('estado_id',$this->estado_id)->get();
        $ciudad1 = Ciudade::where('estado_id',$this->estado_id)->first();
        $this->ciudad_id = $ciudad1->id;

        $this->seccion_empresa = Subserie::seccionE($this->empresa_id);
        $this->seccion_id = $this->seccion_empresa->first()->id;

        $this->seccion_empresa = $this->seccion_empresa->pluck('nombre','id');

        $this->seccionCopia = SeccionEmpresa::where('empresa_id', $this->empresa_id)->get();
        $this->seccionCopia_id = SeccionEmpresa::where('empresa_id', $this->empresa_id)->first()->id;
        $this->buscarSerie();
        $this->buscarSubSerie();

        $this->tipo_usuarios = TipoUsuario::all();
        $this->tipo_usuario_id = TipoUsuario::first()->id;
        $this->medio_recepcion = MedioRecepcion::all();
        $this->medio_id = MedioRecepcion::first()->id;
        $this->fecha = now()->format('Y-m-d');
        /*$this->consultarTipoSerie();
        $this->diasTermino = TipoSolicitud::first()->diasTermino;*/
        $this->solicitudi = 0;


        $this->confidencial = false;
        $this->respuesta_email = false;
        $this->copia_radicado = false;
        $this->folios = 1;
        $this->anexos = 0;
        $this->filtro = 0;
        $this->etapa = 0;

    }
    public function render()
    {

        if(Str::length($this->param)>2){
            $this->filtro = 0;
            $char = [' ',',','.',';','"','?','¿','!','¡','&','$','@','#','%',')','(','/','=','+','-','*','/','_',':','>','<','{','}','[',']',"'"];
            $s = implode(" ",$char);
            $p = str_replace($char,'',$this->param);
            $solicitudes = Solicitud::select('solicituds.*')
            ->whereRaw("((replace(solicitantes.nombrecompleto,' ','') REGEXP ?)
            or (replace(concat_ws('', solicitantes.documento),' ','') REGEXP ?)
            or (replace(concat_ws('', solicituds.radicado),' ','') REGEXP ?)
            or (replace(concat_ws('', solicituds.asunto),' ','') REGEXP ?)) and (`solicituds`.`empresa_id` like ?)",
            [$p, $p, $this->param, $p, $this->empresa_id])->join('solicitantes','solicituds.solicitante_id','solicitantes.id')->paginate(10);
        }
        else{
            if ($this->filtro == 0) {
                $solicitudes = Solicitud::where('empresa_id', $this->empresa_id)
                    ->orderby('created_at','desc')
                    ->paginate(10);
            }
            else {
                $solicitudes = Solicitud::where('empresa_id', $this->empresa_id)
                    ->where('estado_id',$this->filtro)
                    ->orderby('created_at','desc')
                    ->paginate(10);
            }
        };

        $totales = DB::table('solicituds')
            ->select('estado_id','estado_solicituds.nombre as estado', DB::raw('count(*) as total'))
            ->join('estado_solicituds','estado_solicituds.id','solicituds.estado_id')
            ->where('empresa_id', $this->empresa_id)
            ->groupBy('estado_id')
            ->orderBy('estado_id')
            ->get();

        $total = $totales->sum('total');
        return view('livewire.ventanilla-component',['solicitudes' => $solicitudes, 'total'=>$total, 'totales'=>$totales]);
    }
    public function calcularDias()
    {
        $m31 = collect(["1","3","5","7","8","10","12"]);

        if($this->mes=="2"){
            $this->dias = range(1,28);
            if($this->ano%4==0){
                if($this->ano%100 != 0){
                    $this->dias = range(1,29);
                }
                elseif($this->ano%400 == 0){
                    $this->dias = range(1,29);
                }
            }
        }
        elseif($m31->contains($this->mes)){
            $this->dias = range(1,31);
        }
        else{
            $this->dias = range(1,30);
        }

        $this->dia = 1;
    }
    public function cargarciudades()
    {
        $this->ciudades = Ciudade::where('estado_id',$this->estado_id)->get();
        $ciudades1 = Ciudade::where('estado_id',$this->estado_id)->first();
        $this->ciudad_id = $ciudades1->id;
    }
    public function siguienteSolictud($t)
    {
        $this->etapa = $this->etapa+1;
        $this->tipoProceso = $t;
        $this->consultarTipoSerie();

    }
    public function crearFecha()
    {
        $this->calcularDias();
    }
    public function guardarSolicitante()
    {

        $this->validate([
            'tipo_documento' => 'required',
            'documento' => 'required',
            //'nacimiento' => 'required|date',
            'telefono' => 'numeric|min:10',
            'email' => 'email',
            'nombrecompleto' => 'required|min:10',
            'direccion' => 'min:5'
        ]);

        $s = Solicitante::where('documento', $this->documento)->first();
        if($s){

            //if($s){
                $s->telefono = $this->telefono;
                $s->email = $this->email;
                $s->save();
                $this->solicitante = $s;
                $this->solicitante_id = $this->solicitante->id;

            /*}
            else {
                $this->mensaje = "El usuario ya se encuentra registrado en nuestro sistema";
                $this->modalFormVisible = true;
                $this->etapa = 1;
            }*/
        }
        else {
            $this->solicitante = Solicitante::create([
                'tipo_documento' => $this->tipo_documento,
                'tipo_usuario_id' => $this->tipo_usuario_id,
                'documento' => $this->documento,
                //'nacimiento' => null,
                'nombrecompleto' => $this->nombrecompleto,
                'telefono' => $this->telefono,
                'email' => $this->email,
                'ciudad_id' => $this->ciudad_id,
                'direccion' => $this->direccion,
            ]);

            $this->solicitante_id = $this->solicitante->id;
        }

        $this->etapa = 2;
    }
    public function buscarSolicitante()
    {
        //$this->nacimiento = $this->ano.'-'.$this->mes.'-'.$this->dia;
        $s = Solicitante::where('documento', $this->documento)->first();

        if($s){
            $this->nombrecompleto = $s->nombrecompleto;
            $this->tipo_documento = $s->tipo_documento;
            $this->tipo_usuario_id = $s->tipo_usuario_id;
            $this->telefono = $s->telefono;
            $this->email = $s->email;
            $this->direccion = $s->direccion;
            $this->estado_id = $s->ciudad->estado_id;
            $this->ciudades = Ciudade::where('estado_id', $s->ciudad->estado_id)->get();
            $this->ciudad_id = $s->ciudad_id;
        }
    }
    public function buscarSerie()
    {
        $this->series = Subserie::serieSeccion($this->seccion_id);
        $this->serie_id = $this->series->first()->id;
        $this->series = $this->series->pluck('nombre', 'id');

        $seccion_empresa = SeccionEmpresa::find($this->seccion_id);
        $this->destinatario = $seccion_empresa->lider;
        $this->buscarSubSerie();
    }
    public function buscarSubSerie()
    {

        $this->subserie = Subserie::where('serie_id', $this->serie_id)->where('seccion_id', $this->seccion_id)->orderBy('nombre')->get();

        $this->subserie_id = $this->subserie->first()->id;
        $this->buscarTipologia();

    }
    public function buscarTipologia()
    {
        try {
            $this->tipologia = TipologiaDocumento::where('subserie_id', $this->subserie_id)->orderBy('nombre')->get();
            $this->tipologia_id = $this->tipologia->first()->id;
        } catch (\Throwable $th) {

            $this->tipologia = TipologiaDocumento::create([
                'subserie_id'=>$this->subserie_id,
                'nombre'=>'No Aplica',
                'So_Pa'=>false,
                'So_El'=>false,
                'So_Di'=>false,
                'diasTermino'=>0,
                'radicadoSalida'=>false,
                'radicadoEntrada'=>false,
                'pqrs_id'=>1,
            ]);

            $this->tipologia_id = $this->tipologia->first()->id;
        }
        $this->obtenerDiasTermino();
    }
    public function obtenerDiasTermino()
    {
        $this->diasTermino = TipologiaDocumento::find($this->tipologia_id)->pqrs->diastermino;
    }
    public function radicar()
    {
        $s = SeccionEmpresa::find($this->seccion_id);
        $cc=[];

        if (!is_null($s->emailjefe)) {
            $cc[]=$s->emailjefe;
        }

        if($this->copia_radicado and $this->usercopias){
            foreach ($this->usercopias as $co => $value) {
                if($value){
                    $s = User::find($co);
                        $cc[]=$s->email;
                    }
                }
            }

        $cc = array_unique($cc);
        //dd($cc);


        $this->validate([
            'fecha'=>'required|date',
            'asunto'=>'required|min:5',
            'diasTermino'=>'required|numeric',
            'adjunto' => 'required|max:24576', // Pdf máximo 24MB
        ]);

        $solicitudBD = Solicitud::create([
            'solicitante_id'=>$this->solicitante_id,
            'estado_id'=> 1,
            'seccion_id'=>$this->seccion_id,
            'empresa_id'=>$this->empresa_id,
            'serie_id'=>$this->serie_id,
            'subserie_id'=>$this->subserie_id,
            'medio_id'=>$this->medio_id,
            'user_id' => Auth::user()->id,
            'radicado'=> $this->calcularRadicado(),
            'consecutivo'=> $this->max_consecutivo,
            'diasTermino'=> $this->diasTermino,
            'folios'=>$this->folios,
            'anexos'=>$this->anexos,
            'destinatario'=>$this->destinatario,
            'asunto'=>$this->asunto,
            'fecha'=>$this->fecha,
            'confidencial'=>$this->confidencial,
            'respuesta_email'=>$this->respuesta_email,
            'tipologia_id'=>$this->tipologia_id,
        ]);

        try {
            $dataValid['adjunto'] = $this->adjunto->store('pdf','public');
            $outputFile = Storage::disk('public')->path($dataValid['adjunto']);
            $this->fillPDF(Storage::disk('public')->path($dataValid['adjunto']), $outputFile, $solicitudBD->empresa->razonsocial ,$solicitudBD->radicado);
            $seg  = SeguimientoOrden::create([
                'solicitud_id' => $solicitudBD->id,
                'user_id'=>Auth::user()->id,
                'estado_id' => 1,
                'seccion_id' => $this->seccion_id,
                'accion_id' => 1,
                'mensaje' => $this->descripcion,
                'adjunto' => $dataValid['adjunto'],
            ]);

            $this->seguimiento = $seg->id;


            if($this->copia_radicado and $this->copias){

                foreach ($this->copias as $co => $value) {
                    if($value){
                        $ccM[]=[
                            'solicitud_id' => $solicitudBD->id,
                            'seccion_id' => $co
                        ];
                    }
                }
                solicitudCopia::upsert($ccM,['solicitud_id', 'seccion_id']);
            }



            $s = SeccionEmpresa::find($this->seccion_id);


            Mail::to($this->solicitante->email)
            ->cc($cc)
            ->send(new solicitudMail($solicitudBD));
            $this->solicitudi = $solicitudBD->id;
            $this->etapa = 3;
            $this->copias = null;
            $this->copia_radicado = false;
            $this->finalizarRadicado();

        } catch (\Throwable $th) {
            $this->error('adjunto', 'EL formato del pedf no es admitido');
            $dataValid['adjunto']='';
        }



    }
    public function calcularRadicado($trd=false)
    {
        $date = Carbon::createFromDate(now()->format('Y-m-d'));
        $startOfYear = $date->copy()->startOfYear();
        $endOfYear   = $date->copy()->endOfYear();
        $c=null;

        $this->max_consecutivo = Solicitud::where('empresa_id',$this->empresa_id)
                            ->whereBetween('created_at',[$startOfYear, $endOfYear])
                            ->max('consecutivo');
        if($this->max_consecutivo>0){
            $this->max_consecutivo +=1;
        }
        else{
            $this->max_consecutivo =1;
        }

        if ($trd) {
            $t = TipologiaDocumento::find($this->tipologia_id);
            $c= $t->subserie->seccionempresa->codigo.'-'.$t->subserie->serie->codigo.'-'.$t->subserie->codigo.'-';
        }
        $radicado = 'E-'.now()->format('y').'-'.$c.$this->max_consecutivo;

        return($radicado);
    }
    public function finalizarRadicado()
    {
        $this->nombrecompleto = null;
        $this->telefono = null;
        $this->email = null;
        $this->direccion = null;
        $this->documento = null;
        $this->solicitante = null;
        $this->solicitudi = 0;
        $this->etapa = 0;
        $this->asunto = null;
        $this->destinatario = null;
        $this->etapa = 0;
        $this->filtrar(0);
        session()->flash('message', 'El documento ha sido radicado exitosamente!!');
    }
    public function filtrar($id)
    {
        $this->filtro = $id;
        $this->resetPage();
    }
    public function consultarTipoSerie()
    {
        $this->etapa = 1;
        $this->buscarSubSerie();
    }
    public function fillPDF($file, $outputFile, $empresa,$radicado)
    {
        $fpdi = new FPDI;
        $im = QrCode::size(50)->format('png')->generate($radicado);
        $output_file = 'img/qr-code/img-' . time() . '.png';
        Storage::disk('local')->put($output_file, $im);

        // merger operations
        $count = $fpdi->setSourceFile($file);
        for ($i=1; $i<=$count; $i++) {
            $template   = $fpdi->importPage($i);
            $size       = $fpdi->getTemplateSize($template);
            $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
            $fpdi->useTemplate($template);
            $left = 140;
            $top = 10;
            if ($i==1) {
                $text = " Radicado: ".$radicado." Fecha: ".now();
                $text1 = $empresa;
                $fpdi->Image(Storage::disk('local')->path($output_file),125,5);
                $fpdi->SetFont("helvetica", "", 8);
                $fpdi->SetTextColor(100,100,100);
                $fpdi->Text($left,$top,$text1);
                $fpdi->Text($left,$top+4,$text);
                $fpdi->SetCompression(true);
            }
            $text = null;
            $text1 = null;
        }

        Storage::disk('local')->delete($output_file);
        return $fpdi->Output($outputFile, 'F');
    }
    public function consultarListaEmails($seccion_id)
    {
        $s = SeccionEmpresa::find($seccion_id);
        $se = SeccionUser::where('seccion_id', $seccion_id)->get();
        $em = [];

        $em[]=["email"=>$s->emailjefe];

        foreach ($se as $sei) {
            $em[]=["email"=>$sei->user->email];
        }

        return $em;
    }
}
