<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeguimientoOrdensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seguimiento_ordens', function (Blueprint $table) {
            $table->id();            
            $table->foreignId('solicitud_id')->constrained('solicituds');
            $table->foreignId('estado_id')->constrained('estado_solicituds');
            $table->foreignId('seccion_id')->constrained('seccion_empresas');
            $table->foreignId('accion_id')->constrained('accion_ordenes');
            $table->text('mensaje')->nullable();
            $table->text('observaciones')->nullable();
            $table->string('adjunto',100)->nullable();
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
        Schema::dropIfExists('seguimiento_ordens');
    }
}
