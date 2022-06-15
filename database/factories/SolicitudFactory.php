<?php

namespace Database\Factories;

use App\Models\Solicitud;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;


class SolicitudFactory extends Factory
{
    private static $order = 1;
    private static $order1 = 1;
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Solicitud::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {        
        $pqrs = [21, 17, 18, 19, 20];
        return [
            
            'solicitante_id' => mt_rand(1,1000),
            'estado_id' => 1,
            'seccion_id' => mt_rand(1,3),
            'empresa_id' => 1,
            'tipo_id' =>$pqrs[mt_rand(0,4)],
            'tipologia_id'=>170,
            'medio_id' => 5,
            'radicado'=>self::$order1++,
            'consecutivo'=>self::$order++,
            'asunto'=>$this->faker->realText(100,2),
            'created_at' => $this->faker->dateTimeBetween('-180 days', 'now'),
            'diasTermino' => mt_rand(0,30),
            'user_id' => 1,
            'fecha'=> now()->format('Y-m-d'),
        ];
    }
}
