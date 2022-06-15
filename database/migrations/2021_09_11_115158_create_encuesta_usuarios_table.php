<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEncuestaUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encuesta_usuarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('solicitante_id')->constrained('solicitantes');
            $table->foreignId('empresa_id')->constrained('empresas');
            $table->foreignId('estado_id')->constrained('estado_encuestas')->default(1);            
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
        Schema::dropIfExists('encuesta_usuarios');
    }
}
