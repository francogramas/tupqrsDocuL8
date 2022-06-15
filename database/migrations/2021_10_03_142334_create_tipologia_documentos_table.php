<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipologia_documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subserie_id')->constrained('subseries');
            $table->string('nombre');
            $table->boolean('So_Pa')->default(false); //Soporte -> Papel
            $table->boolean('So_El')->default(false); //Soporte -> Electrónico
            $table->boolean('So_Di')->default(false); //Soporte -> Digital
            $table->foreignId('pqrs_id')->constrained('pqrs');
            $table->integer('diasTermino')->default(0);
            $table->boolean('radicadoSalida')->default(false);
            $table->boolean('radicadoEntrada')->default(false);
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
        Schema::dropIfExists('tipologia_documentos');
    }
};
