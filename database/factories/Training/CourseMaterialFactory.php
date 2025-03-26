<?php

namespace Database\Factories\Training;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Training\CourseMaterial>
 */
class CourseMaterialFactory extends Factory
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
            'course_id' => 1,
            'material_name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(3),
            'material_content' => $this->faker->text(),

        ];
    }
}
