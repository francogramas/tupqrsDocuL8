<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSeccionEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seccion_empresas', function (Blueprint $table) {
            $table->string('lider',50)->nullable()->after('publica');
            $table->string('firma',255)->nullable()->after('publica');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seccion_empresas', function (Blueprint $table) {
            $table->dropColumn('lider');
            $table->dropColumn('firma');
        });
    }
}
