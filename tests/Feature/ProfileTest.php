<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

it('should return 200 when accessing the profile page when authenticated', function () {
    $user = User::factory()->create();

    $response = actingAs($user)->getJson('/api/v1/auth/profile');

    $response->assertStatus(200)
        ->assertJsonStructure(['name', 'email'])
        ->assertJsonCount(2)
        ->assertJsonFragment([
            'name' => $user->name,
            'email' => $user->email,
        ]);
});

it('should return 401 when accessing the profile page when not authenticated', function () {
    $response = $this->getJson('/api/v1/auth/profile');

    $response->assertStatus(401);
});

it('should return 202 when updating name', function () {
    $user = User::factory()->create();

    $response = actingAs($user)->putJson('/api/v1/auth/profile', [
        'name' => 'Isaias Xavier Updated',
        'email' => $user->email,
    ]);

    $response->assertStatus(202)
        ->assertJsonStructure(['name', 'email'])
        ->assertJsonCount(2)
        ->assertJsonFragment([
            'name' => 'Isaias Xavier Updated',
            'email' => $user->email,
        ]);

    $this->assertDatabaseHas('users', [
        'name' => 'Isaias Xavier Updated',
        'email' => $user->email,
    ]);
});

it('should return 202 when updating email', function () {
    $user = User::factory()->create();

    $response = actingAs($user)->putJson('/api/v1/auth/profile', [
        'name' => $user->name,
        'email' => 'isaiasUpdated@email.com',
    ]);

    $response->assertStatus(202)
        ->assertJsonStructure(['name', 'email'])
        ->assertJsonCount(2)
        ->assertJsonFragment([
            'name' => $user->name,
            'email' => 'isaiasUpdated@email.com',
        ]);

    $this->assertDatabaseHas('users', [
        'name' => $user->name,
        'email' => 'isaiasUpdated@email.com',
    ]);
});

it('should return 422 when updating email', function () {
    $user = User::factory()->create();

    $response = actingAs($user)->putJson('/api/v1/auth/profile', [
        'name' => $user->name,
        'email' => 'wrong_email',
    ]);

    $response->assertStatus(422);

    $this->assertDatabaseMissing('users', [
        'name' => $user->name,
        'email' => 'wrong_email',
    ]);
});

it('should return 202 when updating password', function () {

    $user = User::factory()->create();
    $newPassword = Hash::make('new_password');

    $response = actingAs($user)->putJson('/api/v1/auth/password', [
        'current_password' => 'password',
        'password' => $newPassword,
        'password_confirmation' => $newPassword,
    ]);

    $this->assertTrue(Hash::check($newPassword, $user->fresh()->password));

    $response->assertStatus(202);

});
