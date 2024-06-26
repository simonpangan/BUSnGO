<?php

namespace Database\Seeders\database\seeders;

use App\Models\Company;
use App\Models\Terminal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class TerminalSeeder extends Seeder
{
    public function run(): void
    {
        $terminals = Collection::times(10, fn() => [
            'company_id' => Company::inRandomOrder()->first()->id,
            'from' => fake()->city(),
            'to' => fake()->city(),
            'ticket_cost'     => fake()->numberBetween(1, 10000),
            'transit_points' => json_encode(Collection::times(random_int(2, 5),
                static fn() => fake()->city()
            )->toArray()),
        ]);

        Terminal::insert($terminals->toArray());
    }
}
