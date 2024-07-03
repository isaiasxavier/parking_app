<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\postJson;

uses(RefreshDatabase::class);

test('user can login in with CORRECT credentials', function () {
    $user = User::factory()->create();

    postJson('/api/v1/auth/login', [
        'email' => $user->email,
        'password' => 'password',
    ])
        ->assertStatus(201);

});

test('user cannot login in with WRONG credentials', function () {
    $user = User::factory()->create();

    postJson('/api/v1/auth/login', [
        'email' => $user->email,
        'password' => 'wrong_password',
    ])
        ->assertStatus(422);

});

test('user cannot login in when ALREADY AUTHENTICATED (403)', function () {
    $user = User::factory()->create();

    Sanctum::actingAs($user);

    postJson('/api/v1/auth/login', [
        'email' => $user->email,
        'password' => 'password',
    ])
        ->assertForbidden();

});

test('user can register in with the CORRECT credentials', function () {

    postJson('/api/v1/auth/register', [
        'name' => 'Isaias Xavier',
        'email' => 'isaias@email.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])
        ->assertStatus(201)
        ->assertJsonStructure([
            'access_token',
        ]);

    $this->assertDatabaseHas('users', [
        'name' => 'Isaias Xavier',
        'email' => 'isaias@email.com',
    ]);

});

test('user cannot register in when ALREADY AUTHENTICATED (403)', function () {
    $user = User::factory()->create();

    Sanctum::actingAs($user);

    postJson('/api/v1/auth/register', [
        'email' => $user->email,
        'password' => 'password',
    ])
        ->assertForbidden();

});

test('user cannot register with WRONG credentials', function () {
    postJson('/api/v1/auth/register', [
        'name' => 'Isaias##Xavier', //invalid name
        'email' => 'isaias@email.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])
        ->assertStatus(422);

    $this->assertDatabaseMissing('users', [
        'name' => 'Isaias$$Xavier', //invalid name
        'email' => 'isaias@email.com',
    ]);
});

it('user can logout after performed a login in', function () {
    $user = User::factory()->create();
    $response = postJson('/api/v1/auth/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $token = $response['access_token'];

    // Logout
    $this->withHeaders(['Authorization' => 'Bearer '.$token])
        ->postJson('/api/v1/auth/logout')
        ->assertStatus(204);
});

it('user cannot logout without valid authentication token', function () {
    $token = Str::random(80);

    $this->withHeaders(['Authorization' => 'Bearer '.$token])
        ->postJson('/api/v1/auth/logout')
        ->assertStatus(401);
});

it('should return 401 when accessing the LOGOUT page when user IS NOT AUTHENTICATED', function () {
    postJson('/api/v1/auth/logout')
        ->assertStatus(401);
});
