<?php

use Livewire\Volt\Volt;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = Volt::test('auth.register')
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('password', 'password')
        ->set('password_confirmation', 'password')
        ->call('register');

    $response
        ->assertHasNoErrors()
        ->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();
});

test('registration fields are visible and adhere to UI standards', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);

    $response->assertSeeInOrder([
        'name="name"',
        'name="email"',
        'name="password"',
        'name="password_confirmation"',
    ]);
});
test('registration fails with invalid name', function () {
    $response = Volt::test('auth.register')
        ->set('name', '') // Invalid name (empty)
        ->set('email', 'valid@example.com')
        ->set('password', 'validpassword')
        ->set('password_confirmation', 'validpassword')
        ->call('register');

    $response
        ->assertHasErrors(['name']); // Ensure 'name' field has validation errors

    $this->assertGuest(); // Ensure the user is not authenticated
});
test('registration fails with invalid email', function () {
    $response = Volt::test('auth.register')
        ->set('name', 'Valid Name') // Valid name
        ->set('email', 'invalid-email') // Invalid email
        ->set('password', 'validpassword') // Valid password
        ->set('password_confirmation', 'validpassword') // Valid password confirmation
        ->call('register');

    $response
        ->assertHasErrors(['email']) // Ensure 'email' field has validation errors
        ->assertDontSee(route('dashboard', absolute: false)); // Ensure user is not redirected to the dashboard

    $this->assertGuest(); // Ensure the user is not authenticated
});
test('registration fails with duplicate email', function () {
    // Create an existing user with the same email
    \App\Models\User::factory()->create([
        'email' => 'duplicate@example.com',
    ]);

    // Attempt to register with the same email
    $response = Volt::test('auth.register')
        ->set('name', 'New User')
        ->set('email', 'duplicate@example.com') // Duplicate email
        ->set('password', 'password')
        ->set('password_confirmation', 'password')
        ->call('register');

    $response
        ->assertHasErrors(['email']) // Ensure 'email' field has validation errors
        ->assertSee('The email has already been taken.'); // Ensure appropriate error message is displayed

    $this->assertGuest(); // Ensure the user is not authenticated
});
test('registration fails with invalid password', function () {
    $response = Volt::test('auth.register')
        ->set('name', 'Valid Name') // Valid name
        ->set('email', 'valid@example.com') // Valid email
        ->set('password', 'short') // Invalid password (too short)
        ->set('password_confirmation', 'short') // Invalid password confirmation
        ->call('register');

    $response
        ->assertHasErrors(['password']) // Ensure 'password' field has validation errors
        ->assertDontSee(route('dashboard', absolute: false)); // Ensure user is not redirected to the dashboard

    $this->assertGuest(); // Ensure the user is not authenticated
});
