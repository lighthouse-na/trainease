<?php

namespace Database\Factories\Organisation;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Organisation\Department>
 */
class DepartmentFactory extends Factory
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
            'department_name' => $this->faker->unique()->word(),
            'division_id' => \App\Models\Organisation\Division::factory(),
        ];
    }
}
