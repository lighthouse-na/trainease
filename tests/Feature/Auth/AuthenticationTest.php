<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt as LivewireVolt;

uses(RefreshDatabase::class);

test('login screen is visible', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('email and password fields are visible on the login page', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
    $response->assertSee('email');
    $response->assertSee('password');
});

test('users can login with valid credentials', function () {
    $user = User::factory()->create();

    $response = LivewireVolt::test('auth.login')
        ->set('email', $user->email)
        ->set('password', 'password')
        ->call('login');

    $response
        ->assertHasNoErrors()
        ->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();
});

test('users can not login with invalid password', function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('users can not login with invalid email address', function () {
    $this->post('/login', [
        'email' => 'wrongemail',
        'password' => 'password',
    ]);

    $this->assertGuest();
});

test('users are redirected to the dashboard after successful login', function () {
    $user = User::factory()->create();

    $response = LivewireVolt::test('auth.login')
        ->set('email', $user->email)
        ->set('password', 'password')
        ->call('login');

    $response
        ->assertHasNoErrors()
        ->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticatedAs($user);

});

use App\Http\Middleware\VerifyCsrfToken;

test('users can logout', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $response = $this->withoutMiddleware(VerifyCsrfToken::class)->post(route('logout'));
    $response->assertRedirect(route('home'));
    $this->assertGuest();
});
