<?php

namespace Database\Factories\QuizModule;

use App\Models\QuizModule\Quiz;
use App\Models\Training\Training;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuizModule\Quiz>
 */
class QuizFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Quiz::class;

    public function definition(): array
    {


            return [
                'training_id' => $this->faker->randomElement(Training::all()->pluck('id')->toArray()), // Create a related training
                'title' => $this->faker->sentence(3),
                'description' => $this->faker->paragraph(),
            ];
        }

}
