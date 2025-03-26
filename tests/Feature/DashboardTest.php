<?php

use App\Models\User;
use App\Models\UserDetail;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class)->in('Feature');

test('Authenticated users are are redirected to the login page', function () {
    $response = $this->get('/dashboard');
    $response->assertRedirect('/login');
});

test('authenticated users can visit the dashboard', function () {
    $user = User::factory()->create();
    UserDetail::factory()->for($user)->create();
    $this->actingAs($user);

    $response = $this->get('/dashboard');
    $response->assertStatus(200);
});

test('staff users see the staff dashboard component', function () {
    $user = User::factory()->create();
    $user->assignRole('staff');
    UserDetail::factory()->create(['user_id' => $user->id]);
    $this->actingAs($user);

    $response = $this->get('/dashboard');
    $response->assertOk()->assertSeeLivewire('staff.staffdashboard');
});

test('trainer users see the trainer dashboard component', function () {
    $trainer = User::factory()->create();
    $trainer->assignRole('trainer');
    UserDetail::factory()->for($trainer)->create();

    $this->actingAs($trainer);

    $response = $this->get('/dashboard');
    $response->assertStatus(200)->assertSeeLivewire('trainer.trainerdashboard');
});

test('users without a role do not see any specific dashboard component', function () {
    $user = User::factory()->create();
    UserDetail::factory()->create(['user_id' => $user->id]);
    $this->actingAs($user);

    $response = $this->get('/dashboard');
    $response->assertStatus(200);
    $response->assertDontSeeLivewire('staff.staffdashboard');
    $response->assertDontSeeLivewire('trainer.trainerdashboard');
});
