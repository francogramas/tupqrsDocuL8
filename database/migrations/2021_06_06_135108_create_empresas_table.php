<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('nit',20);
            $table->string('razonsocial');
            $table->string('direccion',50)->nullable();
            $table->string('telefono',40)->nullable();
            $table->string('email',50)->nullable();
            $table->string('logo',50)->nullable();
            $table->string('url',12)->nullable();
            $table->foreignId('ciudad_id')->constrained('ciudades');            
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('estado_id')->constrained('estado_empresas');
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
        Schema::dropIfExists('empresas');
    }
}
