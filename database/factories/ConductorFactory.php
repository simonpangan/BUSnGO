<?php

namespace Database\Factories;

use App\Models\Conductor;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConductorFactory extends Factory
{
    protected $model = Conductor::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'gender' => $this->faker->randomElement(['M', 'F']),
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'contact_no' => $this->faker->phoneNumber,
            'photo' => $this->faker->imageUrl(),
        ];
    }
}
