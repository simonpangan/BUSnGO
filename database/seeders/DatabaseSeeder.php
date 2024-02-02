<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Database\Seeders\database\seeders\ScheduleSeeder;
use DB;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(DriverSeeder::class);
        $this->call(BusSeeder::class);
        $this->call(ScheduleSeeder::class);

        DB::unprepared(file_get_contents(__DIR__ . '/../dump/philippines_local_government_units.sql'));
    }
}
