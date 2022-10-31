<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Solicitud;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class actualizarSolicitudes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'actualizar:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza diariamente los estados de las solicitudes generadas';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $solicitudes = Solicitud::whereNotIn('estado_id', [3, 4])->where('entrada',1)->get();
        $vectorVencida = array();
        $seguimientoVencida = array();
        $idVencidas = [];
        $vectorPendientes = array();
        $seguimientoPendiente = array();
        $idPendientes = [];

        foreach ($solicitudes as $solicitud) {
            $fi = Carbon::parse( $solicitud->created_at)->format('Y-m-d');
            $fi = Carbon::createFromFormat('Y-m-d', $fi);
            $fv = $fi->addDays($solicitud->diasTermino);
            $d = now()->diffInDays($fv, false);

            if($d>=0 and $d<=($solicitud->diasTermino/2) and $solicitud->estado_id!=2){
                $seguimientoPendiente = array(
                    'solicitud_id' => $solicitud->id,
                    'estado_id' => '2',
                    'user_id' => 0,
                    'seccion_id' => $solicitud->seccion_id,
                    'accion_id' => 2,
                    'created_at' => now(),
                    'updated_at' => now(),
                );
                $idPendientes[]=$solicitud->id;
            }
            elseif ($d<0 and $solicitud->estado_id!=2) {
                $seguimientoVencida = array(
                    'solicitud_id' => $solicitud->id,
                    'user_id' => 0,
                    'estado_id' => '3',
                    'seccion_id' => $solicitud->seccion_id,
                    'accion_id' => 2,
                    'created_at' => now(),
                    'updated_at' => now(),
                );
                $idVencidas[]=$solicitud->id;
            }
            if($seguimientoVencida){array_push($vectorVencida, $seguimientoVencida); $seguimientoVencida = array();}
            if($seguimientoPendiente){array_push($vectorPendientes, $seguimientoPendiente);$seguimientoPendiente = array();}
        }

        DB::table('seguimiento_ordens')->insert($vectorVencida);
        DB::table('seguimiento_ordens')->insert($vectorPendientes);
        Solicitud::whereIn('id', $idVencidas)->update(['estado_id' => 3]);
        Solicitud::whereIn('id', $idPendientes)->update(['estado_id' => 2]);
        $this->info('Solicitudes actualizadas');

    }
}
