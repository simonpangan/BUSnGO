<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition(): array
    {
        return [
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
            'name'          => $this->faker->name(),
            'address'       => $this->faker->address(),
            'phone_number'  => $this->faker->phoneNumber(),
            'email_address' => $this->faker->unique()->safeEmail(),
        ];
    }
}
