<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Role::count() == 0) {
            Role::create(['name' => 'passenger']);
            Role::create(['name' => 'driver']);
            Role::create(['name' => 'conductor']);
            Role::create(['name' => 'admin']);
        }

        if (User::count() === 0) {
            $admin = User::factory()->create([
                'name' => 'Test Admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
            ]);

            $admin->assignRole('admin');

            // Create a test driver user
            $driver = User::factory()->create([
                'name' => 'Test Driver',
                'email' => 'driver@example.com',
                'password' => bcrypt('password'),
            ]);

            $driver->assignRole('driver');

            // Create a test passenger user
            $passenger = User::factory()->create([
                'name' => 'Test Passenger',
                'email' => 'passenger@example.com',
                'password' => bcrypt('password'),
            ]);

            $passenger->assignRole('passenger');

            // Create a test conductors user
            $conductor = User::factory()->create([
                'name' => 'Test Conductor',
                'email' => 'conductors@example.com',
                'password' => bcrypt('password'),
            ]);

            $conductor->assignRole('conductor');
        }
    }
}
