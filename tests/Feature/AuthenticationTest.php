<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user can login in with correct credentials', function () {
    $user = User::factory()->create();

    $response = $this->postJson('/api/v1/auth/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertStatus(201);

});

test('user cannot login in with wrong credentials', function () {
    $user = User::factory()->create();

    $response = $this->postJson('/api/v1/auth/login', [
        'email' => $user->email,
        'password' => 'wrong_password',
    ]);

    $response->assertStatus(422);

});

test('user can register in with the correct credentials', function () {

    $response = $this->postJson('/api/v1/auth/register', [
        'name' => 'Isaias Xavier',
        'email' => 'isaias@email.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'access_token',
        ]);

    $this->assertDatabaseHas('users', [
        'name' => 'Isaias Xavier',
        'email' => 'isaias@email.com',
    ]);

});

test('user cannot register with incorrect credentials', function () {
    $response = $this->postJson('/api/v1/auth/register', [
        'name' => 'Isaias Xavier',
        'email' => 'isaias@email.com',
        'password' => 'password',
        'password_confirmation' => 'wrong_password',
    ]);

    $response->assertStatus(422);

    $this->assertDatabaseMissing('users', [
        'name' => 'Isaias Xavier',
        'email' => 'isaias@email.com',
    ]);
});
