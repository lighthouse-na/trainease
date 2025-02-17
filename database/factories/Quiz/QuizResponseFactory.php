<?php

namespace Database\Factories\Quiz;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quiz\QuizResponse>
 */
class QuizResponseFactory extends Factory
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
            'attempt_id' => $this->faker->randomElement([1, 2, 3]),
            'question_id' => $this->faker->randomElement([1, 2, 3]),
            'option_id' => $this->faker->randomElement([1, 2, 3]),
            'answer_text'=> $this->faker->randomElement(['Answer 1', 'Answer 2', 'Answer 3']),

        ];
    }
}
