<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ColaSolicituds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cola_solicituds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('solicitudEntrada')->constrained('solicituds');
            $table->foreignId('solicitudSalida')->constrained('solicituds');
            $table->foreignId('seccion_id')->constrained('seccion_empresas');
            $table->boolean('finalizada')->default(false);
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
        Schema::dropIfExists('cola_solicituds');
    }
}
