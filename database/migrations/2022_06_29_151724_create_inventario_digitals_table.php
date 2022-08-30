<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventarioDigitalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventario_digitals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('remitente_id')->constrained('remitente_digitals');
            $table->foreignId('seccion_id')->constrained('seccion_empresas');
            $table->foreignId('empresa_id')->constrained('empresas');
            $table->foreignId('serie_id')->constrained('series');
            $table->foreignId('tipologia_id')->constrained('tipologia_documentos');
            $table->date('fecha');
            $table->string('radicado',30)->nullable();
            $table->string('destinatario',100)->nullable();
            $table->string('estante',20);
            $table->string('caja',20);
            $table->integer('folios')->default(1);
            $table->integer('anexos')->default(0);
            $table->text('descripcion')->nullable();
            $table->text('observaciones')->nullable();
            $table->boolean('confidencial')->default(false);
            $table->string('documento',50)->default(false);
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
        Schema::dropIfExists('inventario_digitals');
    }
}
