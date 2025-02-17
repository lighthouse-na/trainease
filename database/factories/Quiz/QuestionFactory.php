<?php

namespace Database\Factories\Quiz;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quiz\Question>
 */
class QuestionFactory extends Factory
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
            'quiz_id' => $this->faker->randomElement([1, 2, 3]),
            'question_text' => $this->faker->randomElement(['Question 1', 'Question 2', 'Question 3']),
            'type' => $this->faker->randomElement(['multiple_choice', 'true_false', 'short_answer']),
        ];
    }
}
