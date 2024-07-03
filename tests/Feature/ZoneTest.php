<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

use App\Models\Zone;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\getJson;

uses(RefreshDatabase::class);

it('ANY USER (Authenticated or not) can see the page ZONES', function () {
    getJson('/api/v1/zones')
        ->assertOk();
});

it('should return 200 and correct data when accessing ZONES page for ANY USER', function () {

    $zones = [
        ['name' => 'Zone1', 'price_per_hour' => 100],
        ['name' => 'Zone2', 'price_per_hour' => 200],
        ['name' => 'Zone3', 'price_per_hour' => 300],
    ];

    foreach ($zones as $zone) {
        Zone::factory()->create($zone);
    }

    getJson('/api/v1/zones')
        ->assertStatus(200)
        ->assertJsonStructure(['data'])
        ->assertJsonCount(3, 'data')
        ->assertJsonStructure([
            'data' => ['*' => ['id', 'name', 'price_per_hour']],
        ])
        /*->assertJsonPath('data.0.id', 1)*/
        ->assertJsonPath('data.0.name', 'Zone1')
        ->assertJsonPath('data.0.price_per_hour', 100)

        /*->assertJsonPath('data.1.id', 2)*/
        ->assertJsonPath('data.1.name', 'Zone2')
        ->assertJsonPath('data.1.price_per_hour', 200)

        /*->assertJsonPath('data.2.id', 3)*/
        ->assertJsonPath('data.2.name', 'Zone3')
        ->assertJsonPath('data.2.price_per_hour', 300);
});
