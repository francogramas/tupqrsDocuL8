<?php

namespace Database\Factories;

use App\Models\Solicitante;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;


class SolicitanteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Solicitante::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tipo_documento' => mt_rand(1,6),
            'tipo_usuario_id' => 4,
            'documento' => $this->faker->numberBetween(100000,99999999),
            'nombrecompleto' =>$this->faker->firstName().' '.$this->faker->firstName().' '.$this->faker->lastName().' '.$this->faker->lastName(),
            'email' => $this->faker->email(),
            'telefono' => $this->faker->phoneNumber(),
            'nacimiento' => $this->faker->dateTimeBetween('-85 years','now')->format('Y-m-d'),
            'ciudad_id' =>mt_rand(1,1126),
            'direccion' => $this->faker->address(),
        ];
    }
}
