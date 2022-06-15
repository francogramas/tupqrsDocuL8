<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(EstadosSeeder::class);
        $this->call(accionOrdenesSeeder::class);
        $this->call(EncuestasSeeder::class);
        /*\App\Models\Solicitante::factory(1000)->create();
        \App\Models\Solicitud::factory(500)->create();
        \App\Models\SeguimientoOrden::factory(500)->create(); */
    }
}
