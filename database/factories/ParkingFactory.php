<?php

namespace Database\Factories;

use App\Models\Parking;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Zone;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ParkingFactory extends Factory
{
    protected $model = Parking::class;

    public function definition()
    : array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'start_time' => Carbon::now(),
            'stop_time' => Carbon::now(),
            'total_price' => $this->faker->randomNumber(),

            'user_id' => User::factory(),
            'vehicle_id' => Vehicle::factory(),
            'zone_id' => Zone::factory(),
        ];
    }
}
