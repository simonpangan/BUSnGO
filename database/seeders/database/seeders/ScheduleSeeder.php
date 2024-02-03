<?php

namespace Database\Seeders\database\seeders;

use App\Models\Bus;
use App\Models\Schedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schedule::factory()->count(10)->create()
            ->each(function (Schedule $schedule) {
                $tickets = Collection::times(
                    $schedule->bus->id,
                    fn(int $number) => [
                        'seat_no' => $number,
                        'status' => 'available'
                    ]
                );

                $schedule->tickets()->createMany($tickets);
            });
    }
}
