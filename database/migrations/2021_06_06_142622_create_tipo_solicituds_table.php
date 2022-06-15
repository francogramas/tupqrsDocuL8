<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoSolicitudsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_solicituds', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',100);
            $table->string('codigo',5);
            $table->integer('AG'); // Archivo Gestión
            $table->integer('AC'); // Archivo Central
            $table->boolean('CT')->default(true); //Conservar en su totalidad
            $table->boolean('E')->default(false); //Eliminar en su totalidad
            $table->boolean('MD')->default(true); //Duplicar
            $table->boolean('S')->default(false); //Conservar parcialmente una serie
            $table->longText('procedimiento');
            $table->integer('diasTermino');
            $table->integer('radicadoSalida');
            $table->integer('radicadoEntrada');
            $table->boolean('pqrs')->default(false);   
            $table->foreignId('empresa_id')->constrained('empresas')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_solicituds');
    }
}
