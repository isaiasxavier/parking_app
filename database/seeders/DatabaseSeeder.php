<?php

namespace Database\Seeders;

use App\Models\Parking;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Vehicle;
use App\Models\Zone;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory(3)->create(/*[
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]*/);
        Vehicle::factory(3)->create();
        Zone::factory(3)->create();
        Parking::factory(3)->create();
    }
}
