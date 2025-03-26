<?php


use App\Models\User;
use App\Models\UserDetail;
use Livewire\Volt\Volt;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);


test('user cannot access user details page without authentication', function () {
    $response = $this->get('/settings/user-details');

    $response->assertRedirect('/login');
});


it('has settings/userdetails page', function () {
    $this->actingAs(User::factory()->create());

    $response = $this->get('/settings/user-details');

    $response->assertStatus(200);
});

test('user can see user details fields', function () {
    $this->actingAs(User::factory()->create());

    $response = $this->get('/settings/user-details');

    $response->assertSee('Salary Ref Number')
    ->assertSee('Gender')
    ->assertSee('Date of Birth')
    ->assertSee('Phone Number')
    ->assertSee('Address')
    ->assertSee('Division')
    ->assertSee('Department')
    ->assertSee('Supervisor')
    ->assertSee('Save');
});

test('user can complete user details form', function () {
    $user = User::factory()->create();

    $this->be($user);

    $formData = [
        'division_id' => null,
        'department_id' => null,
        'supervisor_id' => null,
        'salary_ref_number' => 12345,
        'gender' => 'male',
        'dob' => '1990-01-01',
        'phone_number' => '1234567890',
        'address' => '123 Main Street',
    ];

    Volt::test('settings.user-detail-form')
        ->set('division_id', $formData['division_id'])
        ->set('department_id', $formData['department_id'])
        ->set('supervisor_id', $formData['supervisor_id'])
        ->set('salary_ref_number', $formData['salary_ref_number'])
        ->set('gender', $formData['gender'])
        ->set('dob', $formData['dob'])
        ->set('phone_number', $formData['phone_number'])
        ->set('address', $formData['address'])
        ->call('updateUserDetails')
        ->assertDispatched('user-details-updated');

    $this->assertDatabaseHas('user_details', array_merge($formData, ['user_id' => $user->id]));
});
test('user can update user details', function () {
    $user = User::factory()->create();
    $userDetail = UserDetail::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user);

    $updatedData = [
        'division_id' => 2,
        'department_id' => 3,
        'supervisor_id' => 4,
        'salary_ref_number' => 67890,
        'gender' => 'female',
        'dob' => '1985-05-15',
        'phone_number' => '0987654321',
        'address' => '456 Another Street',
    ];

    Volt::test('settings.user-detail-form')
        ->set('division_id', $updatedData['division_id'])
        ->set('department_id', $updatedData['department_id'])
        ->set('supervisor_id', $updatedData['supervisor_id'])
        ->set('salary_ref_number', $updatedData['salary_ref_number'])
        ->set('gender', $updatedData['gender'])
        ->set('dob', $updatedData['dob'])
        ->set('phone_number', $updatedData['phone_number'])
        ->set('address', $updatedData['address'])
        ->call('updateUserDetails')
        ->assertDispatched('user-details-updated');

    $this->assertDatabaseHas('user_details', array_merge($updatedData, ['user_id' => $user->id]));
});
test('user cannot delete user details', function () {
    $user = User::factory()->create();
    $userDetail = UserDetail::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user);

    $response = $this->delete('/settings/user-details/' . $userDetail->id);

    $response->assertStatus(404);
    $this->assertDatabaseHas('user_details', ['id' => $userDetail->id, 'user_id' => $user->id]);
});
