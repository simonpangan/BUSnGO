<?php

namespace Database\Factories;

use App\Models\Bus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BusFactory extends Factory
{
    protected $model = Bus::class;

    public function definition(): array
    {
        return [
            'no'                 => $this->faker->word(),
            'seat'               => $this->faker->randomNumber(),
            'engine_model'       => $this->faker->word(),
            'chassis_no'         => $this->faker->word(),
            'model'              => $this->faker->word(),
            'color'              => $this->faker->word(),
            'register_no'        => $this->faker->word(),
            'made_in'            => $this->faker->word(),
            'make'               => $this->faker->word(),
            'price'              => $this->faker->word(),
            'fuel'               => $this->faker->word(),
            'engine_capacity'    => $this->faker->word(),
            'puchase_year'       => $this->faker->randomNumber(),
            'transmission_model' => $this->faker->word(),
            'status'             => $this->faker->word(),
            'driver_id'          => $this->faker->randomNumber(),
            'conductor_id'       => $this->faker->randomNumber(),
            'created_at'         => Carbon::now(),
            'updated_at'         => Carbon::now(),
        ];
    }
}
