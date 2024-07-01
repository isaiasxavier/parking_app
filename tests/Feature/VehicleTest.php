<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;

uses(RefreshDatabase::class);

test('ONLY authenticated user can access VEHICLES page', function () {
    getJson('/api/v1/vehicles')
        ->assertStatus(401);
});

test('user can see ONLY their own vehicles', function () {
    $isaiasUser = User::factory()->create();
    $vehicleIsaias = Vehicle::factory()->create([
        'user_id' => $isaiasUser->id,
    ]);

    $felipeUser = User::factory()->create();
    $vehicleFelipe = Vehicle::factory()->create([
        'user_id' => $felipeUser->id,
    ]);

    actingAs($isaiasUser);
    $response = getJson('/api/v1/vehicles');
    /*// Imprime a resposta JSON
    Log::debug($response->getContent());*/
    $response
        ->assertJsonStructure(['data'])
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.id', $vehicleIsaias->id)
        ->assertJsonPath('data.0.plate_number', $vehicleIsaias->plate_number)
        ->assertJsonMissing($vehicleFelipe->toArray())
        ->assertStatus(200);

});

test('Only AUTHENTICATED user can register VEHICLES', function () {
    $user = User::factory()->create();
    $vehicle = Vehicle::factory()->create([
        'user_id' => $user->id,
    ]);

    actingAs($user)->postJson('/api/v1/vehicles', [
        'user_id' => $vehicle->user_id,
        'plate_number' => $vehicle->plate_number,
    ])
        ->assertStatus(201)
        ->assertJsonStructure(['data'])
        ->assertJsonCount(2, 'data')
        ->assertJsonStructure([
            'data' => ['0' => 'plate_number'],
        ])
        ->assertJsonPath('data.plate_number', $vehicle->plate_number);

    $this->assertDatabaseHas('vehicles', [
        'user_id' => $vehicle->user_id,
        'plate_number' => $vehicle->plate_number,
    ]);

});

test('Only AUTHENTICATED user can updated their VEHICLES ONLY', function () {
    $user = User::factory()->create();
    $vehicle = Vehicle::factory()->create([
        'user_id' => $user->id,
    ]);
    $oldPlate = $vehicle->plate_number;
    $newPlate = 'ABS123';

    actingAs($user)->putJson('/api/v1/vehicles/'.$vehicle->id, [
        'user_id' => $vehicle->user_id,
        'plate_number' => $newPlate,
    ])
        ->assertStatus(202)
        ->assertJsonStructure(['plate_number'])
        ->assertJsonPath('plate_number', $newPlate);

    $this->assertDatabaseHas('vehicles', [
        'user_id' => $vehicle->user_id,
        'plate_number' => $newPlate,
    ]);

    $this->assertDatabaseMissing('vehicles', [
        'user_id' => $vehicle->user_id,
        'plate_number' => $oldPlate,
    ]);

});
