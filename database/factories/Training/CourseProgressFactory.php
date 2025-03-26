<?php

namespace Database\Factories\Training;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Training\CourseProgress>
 */
class CourseProgressFactory extends Factory
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
            'status' => $this->faker->randomElement(['in-progress', 'completed']),
            'course_material_id' => 1,
        ];
    }
}
