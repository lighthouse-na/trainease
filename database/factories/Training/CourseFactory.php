<?php

namespace Database\Factories\Training;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Training\Course>
 */
class CourseFactory extends Factory
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
            'course_name' => $this->faker->sentence(3),
            'course_description' => $this->faker->paragraph(3),
            'course_type' => $this->faker->randomElement(['online', 'hybrid', 'face-to-face']),
            'start_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'end_date' => $this->faker->dateTimeBetween('+1 month', '+2 months'),
            'course_fee' => $this->faker->randomFloat(2, 0, 1000),
            'course_image' => $this->faker->imageUrl(),
            'user_id' => 1,
            'is_stem' => false,

        ];
    }
}
