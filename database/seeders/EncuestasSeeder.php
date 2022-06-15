<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class EncuestasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipo = array(
            array('id' => 1, 'nombre' => 'General', 'created_at'=> now(), 'updated_at'=> now()),
        );
        DB::table('tipo_encuestas')->insert($tipo);

        $preguntas = array(
            array('id' => 1, 'tipo_id' => 1, 'pregunta' => 'Entidad', 'created_at'=> now(), 'updated_at'=> now()),
            array('id' => 2, 'tipo_id' => 1, 'pregunta' => '¿Cómo calificaría su experiencia respecto a los servicios que ha recibido a través de nuestra empresa?', 'created_at'=> now(), 'updated_at'=> now()),
            array('id' => 3, 'tipo_id' => 1, 'pregunta' => '¿Nos recomendaría a sus amigos y familiares', 'created_at'=> now(), 'updated_at'=> now()),
            array('id' => 4, 'tipo_id' => 1, 'pregunta' => '¿Considera que durante la atención recibió un trato digno y respetuoso?', 'created_at'=> now(), 'updated_at'=> now()),
            array('id' => 5, 'tipo_id' => 1, 'pregunta' => 'En general, ¿Está usted satisfecho con nuestro servicio?', 'created_at'=> now(), 'updated_at'=> now()),
        );
        DB::table('pregunta_encuestas')->insert($preguntas);

        $respuestas = array(
            array('id' => 1, 'pregunta_id' => 1, 'respuesta' => 'Entidad', 'created_at'=> now(), 'updated_at'=> now()),            
            array('id' => 2, 'pregunta_id' => 2, 'respuesta' => 'Muy Buena', 'created_at'=> now(), 'updated_at'=> now()),            
            array('id' => 3, 'pregunta_id' => 2, 'respuesta' => 'Buena', 'created_at'=> now(), 'updated_at'=> now()),            
            array('id' => 4, 'pregunta_id' => 2, 'respuesta' => 'Regular', 'created_at'=> now(), 'updated_at'=> now()),            
            array('id' => 5, 'pregunta_id' => 2, 'respuesta' => 'Malo', 'created_at'=> now(), 'updated_at'=> now()),            
            array('id' => 6, 'pregunta_id' => 2, 'respuesta' => 'Muy Malo', 'created_at'=> now(), 'updated_at'=> now()),            
            array('id' => 7, 'pregunta_id' => 2, 'respuesta' => 'No Responde', 'created_at'=> now(), 'updated_at'=> now()),            
            array('id' => 8, 'pregunta_id' => 3, 'respuesta' => 'Definitivamente si', 'created_at'=> now(), 'updated_at'=> now()),
            array('id' => 9, 'pregunta_id' => 3, 'respuesta' => 'Probablemente si', 'created_at'=> now(), 'updated_at'=> now()),
            array('id' => 10, 'pregunta_id' => 3, 'respuesta' => 'Probablemente no', 'created_at'=> now(), 'updated_at'=> now()),
            array('id' => 11, 'pregunta_id' => 3, 'respuesta' => 'Definitivamente no', 'created_at'=> now(), 'updated_at'=> now()),
            array('id' => 12, 'pregunta_id' => 3, 'respuesta' => 'No Responde', 'created_at'=> now(), 'updated_at'=> now()),
            array('id' => 13, 'pregunta_id' => 4, 'respuesta' => 'SI', 'created_at'=> now(), 'updated_at'=> now()),
            array('id' => 14, 'pregunta_id' => 4, 'respuesta' => 'NO', 'created_at'=> now(), 'updated_at'=> now()),
            array('id' => 15, 'pregunta_id' => 4, 'respuesta' => 'No Responde', 'created_at'=> now(), 'updated_at'=> now()),
            array('id' => 16, 'pregunta_id' => 5, 'respuesta' => 'SI', 'created_at'=> now(), 'updated_at'=> now()),
            array('id' => 17, 'pregunta_id' => 5, 'respuesta' => 'NO', 'created_at'=> now(), 'updated_at'=> now()),
            array('id' => 18, 'pregunta_id' => 5, 'respuesta' => 'No Responde', 'created_at'=> now(), 'updated_at'=> now()),
       
        );
        DB::table('respuesta_encuestas')->insert($respuestas);

        $estado_encuesta = array(
            array('id' => 1, 'nombre' => 'Activa'),
            array('id' => 2, 'nombre' => 'Finalizada'),
            array('id' => 3, 'nombre' => 'Cancelada'),
        );

        DB::table('estado_encuestas')->insert($estado_encuesta);        
    }
}
