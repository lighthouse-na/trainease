<?php

namespace Database\Factories\QuizModule;

use App\Models\QuizModule\Option;
use App\Models\QuizModule\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuizModule\Option>
 */
class OptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Option::class;

    public function definition(): array
    {
        return [
            'question_id' => $this->faker->randomElement(Question::all()->pluck('id')->toArray()), // Create a related question
            'option_text' => $this->faker->word(),
            'is_correct' => $this->faker->boolean(30), // 30% chance of being correct
        ];
    }
}
