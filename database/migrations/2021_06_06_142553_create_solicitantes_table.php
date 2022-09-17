<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('solicitantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_documento')->constrained('tipodocumentos');
            $table->foreignId('tipo_usuario_id')->constrained('tipodocumentos');
            $table->string('documento',20);
            $table->string('nombrecompleto',100);
            $table->string('email',50);
            $table->string('telefono',50);
            $table->date('nacimiento')->nullable();
            $table->foreignId('ciudad_id')->constrained('ciudades');
            $table->string('direccion');
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
        Schema::dropIfExists('solicitantes');
    }
}
