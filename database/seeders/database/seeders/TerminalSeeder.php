<?php

namespace Database\Seeders\database\seeders;

use App\Models\Terminal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class TerminalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $terminals = Collection::times(10, function() {
            return [
                'from' => fake()->name(),
                'to' => fake()->name()
            ];
        });

        Terminal::insert($terminals->toArray());
    }
}
