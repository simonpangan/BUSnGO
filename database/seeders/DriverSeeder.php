<?php

namespace Database\Seeders;

use App\Models\Driver;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DriverSeeder extends Seeder
{
    public function run(): void
    {
        Driver::factory()
            ->count(10)
            ->for(User::factory())
            ->create();
    }
}
