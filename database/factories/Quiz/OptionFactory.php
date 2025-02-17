<?php

namespace Database\Factories\Quiz;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quiz\Option>
 */
class OptionFactory extends Factory
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
            'question_id' => $this->faker->randomElement([1, 2, 3]),
            'option_text' => $this->faker->randomElement(['Option 1', 'Option 2', 'Option 3']),
            'is_correct' => $this->faker->boolean(),
        ];
    }
}
