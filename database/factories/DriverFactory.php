<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Driver>
 */
class DriverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id' => Company::inRandomOrder()->first()->id,
            'user_id' => User::factory(),
            'name' => $this->faker->name,
            'gender' => $this->faker->randomElement(['M', 'F']),
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'contact_no' => "09{$this->faker->randomNumber(9, true)}",
            'photo' => $this->faker->imageUrl(),
        ];
    }
}
