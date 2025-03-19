<?php

use App\Models\User;
use App\Models\UserDetail;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('Authenticated users are are redirected to the login page', function () {
    $response = $this->get('/dashboard');
    $response->assertRedirect('/login');
});

test('authenticated users can visit the dashboard', function () {
    $user = User::factory()->create();
    UserDetail::factory()->create(['user_id' => $user->id]);
    $this->actingAs($user);

    $response = $this->get('/dashboard');
    $response->assertStatus(200);
});
