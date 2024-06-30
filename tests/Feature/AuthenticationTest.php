<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

use App\Models\User;

test('', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('user can login in with correct credentials', static function () {
    $user = User::factory()->create();

});
