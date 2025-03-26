<?php

namespace Database\Factories\Training;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Training\Enrollment>
 */
class EnrollmentFactory extends Factory
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
            'course_id' => 1,
            'user_id' => 1,
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            'enrolled_at' => $this->faker->dateTimeBetween('-1 month', 'now'),

        ];
    }
}
