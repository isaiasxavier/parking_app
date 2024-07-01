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
use function Pest\Laravel\getJson;
use function Pest\Laravel\putJson;

uses(RefreshDatabase::class);

it('should return 200 when accessing the PROFILE page when user IS AUTHENTICATED', function () {
    $user = User::factory()->create();

    actingAs($user)->getJson('/api/v1/auth/profile')
        ->assertStatus(200)
        ->assertJsonStructure(['name', 'email'])
        ->assertJsonCount(2)
        ->assertJsonFragment([
            'name' => $user->name,
            'email' => $user->email,
        ]);
});

it('should return 401 when accessing the PROFILE page when user IS NOT AUTHENTICATED', function () {
    getJson('/api/v1/auth/profile')
        ->assertStatus(401);
});

it('should return 202 when updating NAME with CORRECT NAME', function () {
    $user = User::factory()->create();
    $oldName = $user->name;

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

    $this->assertDatabaseMissing('users', [
        'name' => $oldName,
        'email' => $user->email,
    ]);

});

it('should return 422 when updating NAME with NULL NAME', function () {
    $user = User::factory()->create();

    $response = actingAs($user)->putJson('/api/v1/auth/profile', [
        'name' => '',
        'email' => $user->email,
    ]);

    $response->assertStatus(422);

    $this->assertDatabaseMissing('users', [
        'name' => '',
        'email' => $user->email,
    ]);

    $this->assertDatabaseHas('users', [
        'name' => $user->name,
        'email' => $user->email,
    ]);

});

it('should return 422 when updating NAME with INVALID NAME', function () {
    $user = User::factory()->create();

    $response = actingAs($user)->putJson('/api/v1/auth/profile', [
        'name' => 'Invalid#Name',
        'email' => $user->email,
    ]);

    $response->assertStatus(422);

    $this->assertDatabaseMissing('users', [
        'name' => 'Invalid#Name',
        'email' => $user->email,
    ]);

    $this->assertDatabaseHas('users', [
        'name' => $user->name,
        'email' => $user->email,
    ]);
});

it('should return 202 when updating EMAIL with CORRECT EMAIL', function () {
    $user = User::factory()->create();
    $oldEmail = $user->email;

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

    $this->assertDatabaseMissing('users', [
        'name' => $user->name,
        'email' => $oldEmail,
    ]);

    $this->assertDatabaseHas('users', [
        'name' => $user->name,
        'email' => 'isaiasUpdated@email.com',
    ]);

});

it('should return 422 when updating EMAIL with NULL EMAIL', function () {
    $user = User::factory()->create();

    $response = actingAs($user)->putJson('/api/v1/auth/profile', [
        'name' => $user->name,
        'email' => '',
    ]);

    $response->assertStatus(422);

    $this->assertDatabaseHas('users', [
        'name' => $user->name,
        'email' => $user->email,
    ]);

    $this->assertDatabaseMissing('users', [
        'name' => $user->name,
        'email' => '',
    ]);
});

it('should return 422 when updating email with INVALID EMAIL', function () {
    $user = User::factory()->create();

    $response = actingAs($user)->putJson('/api/v1/auth/profile', [
        'name' => $user->name,
        'email' => 'wrong_email',
    ]);

    $response->assertStatus(422);

    $this->assertDatabaseHas('users', [
        'name' => $user->name,
        'email' => $user->email,
    ]);

    $this->assertDatabaseMissing('users', [
        'name' => $user->name,
        'email' => 'wrong_email',
    ]);
});

it('should return 401 when accessing the PASSWORD page when user IS NOT AUTHENTICATED', function () {
    putJson('/api/v1/auth/password')
        ->assertStatus(401);
});

it('should return 202 when updating password with CORRECT PASSWORD', function () {

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

it('should return 422 when updating password with INVALID CURRENT PASSWORD', function () {

    $user = User::factory()->create();
    $newPassword = Hash::make('new_password');

    actingAs($user)->putJson('/api/v1/auth/password', [
        'current_password' => 'wrong_password',
        'password' => $newPassword,
        'password_confirmation' => $newPassword,
    ])
        ->assertStatus(422);

    $this->assertFalse(Hash::check($newPassword, $user->fresh()->password));

});

it('should return 422 when updating password with WRONG CONFIRMATION PASSWORD', function () {

    $user = User::factory()->create();
    $newPassword = Hash::make('new_password');

    actingAs($user)->putJson('/api/v1/auth/password', [
        'current_password' => 'password',
        'password' => $newPassword,
        'password_confirmation' => 'wrong_password',
    ])
        ->assertStatus(422);

    $this->assertFalse(Hash::check($newPassword, $user->fresh()->password));

});
