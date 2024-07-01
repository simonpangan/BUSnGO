<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Conductor;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
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
            Role::create(['name' => 'bus admin']);
            Role::create(['name' => 'super admin']);
        }

        if (User::count() === 0) {
            $admin = User::factory()->create([
                'name' => 'Test Admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
            ]);

            $admin->assignRole('super admin');

            // Create a test driver user
            $driver = User::factory()->create([
                'name' => 'Test Driver',
                'email' => 'driver@example.com',
                'password' => bcrypt('password'),
            ]);

            Driver::create([
                'company_id' => Company::inRandomOrder()->first()->id,
                'user_id' => $driver->id,
                'name' => 'Test Driver',
                'gender' => "M",
                'address' => "7353 Hammes Locks Suite 979 Lake Emely, OR 01718-0153",
                'city' => "Miguelmouth",
                'contact_no' => "09999351568",
                'photo' => "https://via.placeholder.com/640x480.png/0099cc?text=enim",
            ]);

            $driver->assignRole('driver');

            // Create a test passenger user
            $passenger = User::factory()->create([
                'name' => 'Test Passenger',
                'email' => 'passenger@example.com',
                'password' => bcrypt('password'),
                'contact_no' => '09694834343'
            ]);

            $passenger->assignRole('passenger');

            // Create a test conductor user
            $conductor = User::factory()->create([
                'name' => 'Test Conductor',
                'email' => 'conductor@example.com',
                'password' => bcrypt('password'),
            ]);

            Conductor::create([
                'company_id' => Company::inRandomOrder()->first()->id, //Add this line
                'user_id' => $conductor->id,
                'name' => 'Test Conductor',
                'gender' => "M",
                'address' => "7353 Hammes Locks Suite 979 Lake Emely, OR 01718-0153",
                'city' => "Miguelmouth",
                'contact_no' => "09999351568",
                'photo' => "https://via.placeholder.com/640x480.png/0099cc?text=enim",
            ]);

            Conductor::create([
                'company_id' => Company::inRandomOrder()->first()->id,
                'user_id' =>  $conductor->id,
                'name' =>  "Allek Esteban",
                'gender' =>  'M',
                'address' => '6215 Prudence Mission Apt. 055 Kelsistad, IA 15415',
                'city' => 'East Adriennemouth',
                'contact_no' => '1-229-325-8870',
                'photo' => 'https://via.placeholder.com/640x480.png/008822?text=eos',
            ]);

            $conductor->assignRole('conductor');
        }
    }
}
