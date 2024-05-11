<?php

namespace Database\Factories;

use App\Models\CompanyAdmin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CompanyAdminFactory extends Factory
{
    protected $model = CompanyAdmin::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'name'       => $this->faker->name(),
            'email'      => $this->faker->unique()->safeEmail(),
            'contact_no' => $this->faker->word(),
        ];
    }
}
