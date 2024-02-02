<?php

namespace Database\Factories;

use App\Models\Bus;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ScheduleFactory extends Factory
{
    protected $model = Schedule::class;

    public function definition(): array
    {
        return [
            'bus_id'         => Bus::factory(),
            'departure_time' => Carbon::now(),
            'arrival_time'   => Carbon::now(),
            'status'         => $this->faker->word(),
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ];
    }
}
