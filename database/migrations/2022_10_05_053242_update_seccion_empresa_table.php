<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSeccionEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seccion_empresas', function (Blueprint $table) {
            $table->string('emailjefe')->nullable()->after('publica');
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
            $table->dropColumn('emailjefe');
        });
    }
}
