<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSolicituds1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('solicituds', function (Blueprint $table) {
            $table->boolean('revision')->default(false);
            $table->boolean('aprobada')->default(false);
            $table->boolean('cancelada')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('solicituds', function (Blueprint $table) {
            $table->dropColumn('revision');
            $table->dropColumn('aprobada');
            $table->dropColumn('cancelada');
        });
    }
}
