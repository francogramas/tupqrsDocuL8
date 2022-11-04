<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleExpedientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_expedientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('expediente_id')->constrained('expedientes');
            $table->foreignId('seccion_id')->constrained('seccion_empresas');
            $table->foreignId('empresa_id')->constrained('empresas');
            $table->foreignId('serie_id')->constrained('series');
            $table->foreignId('subserie_id')->constrained('subseries');
            $table->foreignId('medio_id')->constrained('medio_recepcions');
            $table->integer('folios')->default(1);
            $table->integer('anexos')->default(0);
            $table->string('asunto',100)->nullable();
            $table->text('observaciones')->nullable();

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
        Schema::dropIfExists('detalle_expedientes');
    }
}
