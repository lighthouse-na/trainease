<?php

namespace Database\Factories\QuizModule;

use App\Models\QuizModule\Option;
use App\Models\QuizModule\UserAnswer;
use App\Models\QuizModule\UserSelectedOption;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuizModule\UserSelectedOption>
 */
class UserSelectedOptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = UserSelectedOption::class;

    public function definition(): array
    {
        return [
            'user_answer_id' => UserAnswer::factory(),
            'option_id' => Option::factory(),
        ];
    }
}
