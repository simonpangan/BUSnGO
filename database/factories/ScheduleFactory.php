<?php

namespace Database\Factories;

use App\Models\Bus;
use App\Models\Company;
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
            'company_id' => Company::inRandomOrder()->first()->id,
            'bus_id'         => Bus::factory(),
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
