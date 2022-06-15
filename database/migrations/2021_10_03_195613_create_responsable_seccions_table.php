<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponsableSeccionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responsable_seccions', function (Blueprint $table) {
            $table->id();
            $table->string('nombrecompleto',100);
            $table->string('email',50);
            $table->string('telefono',50);
            $table->foreignId('seccion_id')->constrained('seccion_empresas');
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
        Schema::dropIfExists('responsable_seccions');
    }
}
