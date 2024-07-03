<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

use App\Models\Parking;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Zone;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

uses(RefreshDatabase::class);

test('ONLY AUTHENTICATED User can START Parking', function () {
    postJson('api/v1/parkings/start')
        ->assertUnauthorized();
});

test('User can START Parking', function () {
    $user = User::factory()->create();
    $vehicle = Vehicle::factory()->create(['user_id' => $user->id]);

    // Ensure there's at least one Zone record
    $zone = Zone::firstOrCreate([
        'name' => 'Zone1',
        'price_per_hour' => 100, // Provide necessary attributes for Zone creation''
    ]);

    // Check if $vehicle and $zone are not null
    $this->assertNotNull($user, 'User is null.');
    $this->assertNotNull($vehicle, 'Vehicle is null.');
    $this->assertNotNull($zone, 'Zone is null.');

    $response = $this->actingAs($user)->postJson('/api/v1/parkings/start', [
        'vehicle_id' => $vehicle->id,
        'zone_id' => $zone->id,
    ]);

    $response->assertStatus(201)
        ->assertJsonStructure(['data'])
        ->assertJson([
            'data' => [
                'start_time' => now()->toDateTimeString(),
                'stop_time' => null,
                'total_price' => 0,
            ],
        ]);

    $this->assertDatabaseCount('parkings', '1');
    $this->assertDatabaseHas('parkings', ['vehicle_id' => $vehicle->id, 'zone_id' => $zone->id]);

});

test('ONLY AUTHENTICATED user can see ONGOING Parking', function () {
    getJson('/api/v1/parkings/1')
        ->assertUnauthorized();
});

test('user can see ONGOING parking with correct price', function () {
    $user = User::factory()->create();
    $vehicle = Vehicle::factory()->create(['user_id' => $user->id]);

    // Ensure there's at least one Zone record
    $zone = Zone::firstOrCreate([
        'name' => 'Zone1',
        'price_per_hour' => 100,
    ]);

    // Check if $vehicle and $zone are not null
    $this->assertNotNull($user, 'User is null.');
    $this->assertNotNull($vehicle, 'Vehicle is null.');
    $this->assertNotNull($zone, 'Zone is null.');

    $this->actingAs($user)->postJson('/api/v1/parkings/start', [
        'vehicle_id' => $vehicle->id,
        'zone_id' => $zone->id,
    ]);

    $this->travel(3)->hours();

    // Simulate the price calculation and update process as it would occur by the ServiceClasse ParkingPriceService
    $parking = Parking::first();
    $calculatedPrice = App\Services\Api\V1\ParkingPriceService::calculatePrice(
        $parking->zone_id,
        $parking->start_time,
        now()
    );
    $parking->total_price = $calculatedPrice;
    $parking->save();

    $response = $this->actingAs($user)->getJson('/api/v1/parkings/'.$parking->id);

    $response->assertStatus(200)
        ->assertJsonStructure(['data'])
        ->assertJson([
            'data' => [
                'stop_time' => null,
                'total_price' => $zone->price_per_hour * 3,
            ],
        ]);
});

test('ONLY AUTHENTICATED user can STOP Parking', function () {
    putJson('/api/v1/parkings/1')
        ->assertUnauthorized();
});

test('user can STOP parking with correct price', function () {
    $user = User::factory()->create();
    $vehicle = Vehicle::factory()->create(['user_id' => $user->id]);

    // Ensure there's at least one Zone record
    $zone = Zone::firstOrCreate([
        'name' => 'Zone1',
        'price_per_hour' => 100,
    ]);

    // Simulate the price calculation and update process as it would occur by the ServiceClasse ParkingPriceService
    $parking = Parking::firstOrCreate(['user_id' => $user->id, 'vehicle_id' => $vehicle->id, 'zone_id' => $zone->id]);
    $calculatedPrice = App\Services\Api\V1\ParkingPriceService::calculatePrice(
        $parking->zone_id,
        $parking->start_time,
        $this->travel(4)->hours()
    );
    $parking->total_price = $calculatedPrice;
    $parking->save();

    // Check if $vehicle, $zone and $user are not null
    $this->assertNotNull($vehicle, 'Vehicle is null.');
    $this->assertNotNull($zone, 'Zone is null.');
    $this->assertNotNull($user, 'User is null');

    $this->actingAs($user)->putJson('/api/v1/parkings/'.$parking->id, [])
        ->assertJsonStructure(['data'])
        ->assertJson([
            'data' => [
                'start_time' => $parking->start_time->toDateTimeString(),
                'stop_time' => now()->toDateTimeString(),
                'total_price' => $parking->total_price,
            ],
        ]);
    $this->assertDatabaseCount('parkings', '1');
    $this->assertDatabaseHas('parkings', ['id' => $parking->id]);
});
