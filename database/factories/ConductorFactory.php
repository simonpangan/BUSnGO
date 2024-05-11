<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Conductor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConductorFactory extends Factory
{
    protected $model = Conductor::class;

    public function definition(): array
    {
        return [
            'company_id' => Company::inRandomOrder()->first()->id,
            'user_id' => User::factory(),
            'name' => $this->faker->name,
            'gender' => $this->faker->randomElement(['M', 'F']),
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'contact_no' => $this->faker->phoneNumber,
            'photo' => $this->faker->imageUrl(),
        ];
    }
}
