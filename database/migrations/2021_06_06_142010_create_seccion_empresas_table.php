<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeccionEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seccion_empresas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',50);
            $table->string('codigo',50)->nullable();
            $table->foreignId('empresa_id')->constrained('empresas');
            $table->foreignId('estado_id')->constrained('estado_seccions');
            $table->boolean('publica')->default(true);
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
        Schema::dropIfExists('seccion_empresas');
    }
}
