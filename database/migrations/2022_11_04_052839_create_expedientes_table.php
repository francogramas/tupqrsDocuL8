<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpedientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expedientes', function (Blueprint $table) {
            $table->id();
            $table->integer('numero')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('empresa_id')->constrained('empresas');
            $table->foreignId('seccion_id')->constrained('seccion_empresas');
            $table->foreignId('solicitudEntrada')->constrained('solicituds');
            $table->foreignId('solicitudSalida')->constrained('solicituds');
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
        Schema::dropIfExists('expedientes');
    }
}
