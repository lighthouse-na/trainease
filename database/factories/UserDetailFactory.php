<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserDetail>
 */
class UserDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        'user_id' => \App\Models\User::factory(),
        'division_id' => \App\Models\Organisation\Division::factory(),
        'department_id' => \App\Models\Organisation\Department::factory(),
        'supervisor_id' => \App\Models\User::factory(),
        'salary_ref_number' => $this->faker->unique()->numberBetween(10000, 99999),
        'gender' => $this->faker->randomElement(['male', 'female', 'other']),
        'dob' => $this->faker->date('Y-m-d', '-18 years'),
        'phone_number' => $this->faker->phoneNumber(),
        'address' => $this->faker->address(),
        ];
    }
}
