<?php

namespace Database\Factories\QuizModule;

use App\Models\QuizModule\Question;
use App\Models\QuizModule\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuizModule\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Question::class;

    public function definition(): array
    {
        return [
            'quiz_id' => $this->faker->randomElement(Quiz::all()->pluck('id')->toArray()), // Create a related quiz
            'question_text' => $this->faker->sentence(),
            'question_type' => $this->faker->randomElement(['multiple_choice', 'short_answer', 'multiple_response', 'sequence', 'matching']),
        ];
    }
}
