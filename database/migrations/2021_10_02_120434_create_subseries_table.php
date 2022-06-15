<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubseriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subseries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('serie_id')->constrained('series');
            $table->foreignId('seccion_id')->constrained('seccion_empresas');
            $table->string('codigo',10)->nullable();
            $table->string('nombre')->nullable();
            $table->integer('Re_AG')->default(0); // Archivo Gestión -> Retención en años
            $table->integer('Re_AC')->default(0); // Archivo Central -> Retención en años
            $table->boolean('DF_CT')->default(true); //Conservar en su totalidad ->Disposición final
            $table->boolean('DF_E')->default(false); //Eliminar en su totalidad->Disposición final
            $table->boolean('DF_MD')->default(true); //Duplicar->Disposición final
            $table->boolean('DF_S')->default(false); //Conservar parcialmente una serie->Disposición final
            $table->boolean('ACC_P')->default(false); // Público -> Acceso
            $table->boolean('ACC_Pr')->default(false); // Privado -> Acceso
            $table->longText('procedimiento')->nullable();                                    
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
        Schema::dropIfExists('subseries');
    }
}
