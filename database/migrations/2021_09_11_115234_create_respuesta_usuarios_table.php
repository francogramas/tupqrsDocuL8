<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRespuestaUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respuesta_usuarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pregunta_id')->constrained('pregunta_encuestas');
            $table->foreignId('respuesta_id')->constrained('respuesta_encuestas');
            $table->foreignId('encuesta_id')->constrained('encuesta_usuarios');
            $table->string('respuesta_texto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('respuesta_usuarios');
    }
}
