<?php

namespace Database\Factories\QuizModule;

use App\Models\QuizModule\Question;
use App\Models\QuizModule\UserAnswer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuizModule\UserAnswer>
 */
class UserAnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = UserAnswer::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'question_id' => Question::factory(),
            'answer_text' => $this->faker->sentence(), // Used for short answer
        ];
    }
}
