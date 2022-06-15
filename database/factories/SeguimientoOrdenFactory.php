<?php

namespace Database\Factories;

use App\Models\SeguimientoOrden;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeguimientoOrdenFactory extends Factory
{
    private static $order = 1;

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SeguimientoOrden::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = $this->faker;
        return [
            'solicitud_id' => self::$order++,
            'estado_id' => 1,
            'seccion_id' => mt_rand(1,3),
            'accion_id' => 1,
            'mensaje' => $faker->paragraph(),
            'observaciones' => null,
            'adjunto' => null,
        ];
    }
}
