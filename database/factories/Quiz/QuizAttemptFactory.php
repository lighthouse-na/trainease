<?php

namespace Database\Factories\Quiz;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quiz\QuizAttempt>
 */
class QuizAttemptFactory extends Factory
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
            'user_id' => $this->faker->randomElement([1, 2, 3]),
            'quiz_id' => $this->faker->randomElement([1, 2, 3]),
            'score' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
