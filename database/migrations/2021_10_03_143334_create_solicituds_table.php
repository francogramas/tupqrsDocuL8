<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicituds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('solicitante_id')->constrained('solicitantes');
            $table->foreignId('estado_id')->constrained('estado_solicituds');
            $table->foreignId('seccion_id')->constrained('seccion_empresas');
            $table->foreignId('empresa_id')->constrained('empresas');
            $table->foreignId('serie_id')->constrained('series');
            $table->foreignId('subserie_id')->constrained('subseries');
            $table->foreignId('medio_id')->constrained('medio_recepcions');
            $table->foreignId('user_id')->constrained('users');
            $table->string('radicado',30)->nullable();
            $table->integer('consecutivo');
            $table->integer('diasTermino');
            $table->integer('folios')->default(1);
            $table->integer('anexos')->default(0);
            $table->string('destinatario',100)->nullable();
            $table->string('asunto',100)->nullable();
            $table->date('fecha');
            $table->boolean('confidencial')->default(false);
            $table->boolean('respuesta_email')->default(false);
            $table->foreignId('tipologia_id')->constrained('tipologia_documentos');
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
        Schema::dropIfExists('solicituds');
    }
}
