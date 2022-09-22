<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class accionOrdenesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $acciones = array(
            array('id' => 1, 'nombre' => 'Radicación de PQRS'),
            array('id' => 2, 'nombre'=> 'Cambio de estado por sistema'),
            array('id' => 3, 'nombre'=> 'Cambio de dependencia'),
            array('id' => 8, 'nombre'=> 'Finalizar solicitud'),

        );
        DB::table('accion_ordenes')->insert($acciones);
    }
}
