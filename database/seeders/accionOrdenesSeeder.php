<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

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
            array('id' => 4, 'nombre'=> 'Respuesta parcial'),
            array('id' => 5, 'nombre'=> 'Llamada telefónica para seguimiento'),
            array('id' => 6, 'nombre'=> 'Llamada telefónica para finalización'),
            array('id' => 7, 'nombre'=> 'Finalizar solicitud con respuesta negativa'),
            array('id' => 8, 'nombre'=> 'Finalizar solicitud con respuesta positiva'),
            
        );
        DB::table('accion_ordenes')->insert($acciones);
    }
}
