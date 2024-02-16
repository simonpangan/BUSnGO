<?php

namespace Database\Factories;

use App\Models\Bus;
use App\Models\Conductor;
use App\Models\Driver;
use App\Models\Schedule;
use App\Models\Terminal;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ScheduleFactory extends Factory
{
    protected $model = Schedule::class;

    public function definition(): array
    {
        return [
            'bus_id'         => Bus::factory(),
            'ticket_cost'     => $this->faker->numberBetween(100, 1000),
            'terminal_id'    => Terminal::inRandomOrder()->first()->id,
            'departure_time' => Carbon::now(),
            'arrival_time'   => Carbon::now(),
            'status'         => $this->faker->randomElement(Schedule::STATUS),
            'driver_id'          => Driver::factory(),
            'conductor_id'       => Conductor::factory(),
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ];
    }
}
