<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory(1000)->create()->each(function ($user) {
            \App\Models\UserDetail::create([
                'user_id' => $user->id,
                'division_id' => rand(1, 10), // Assuming you have divisions with IDs 1-10
                'department_id' => rand(1, 20), // Assuming you have departments with IDs 1-20
                'supervisor_id' => rand(1, 50), // Assuming some users are supervisors
                'salary_ref_number' => rand(10000, 99999),
                'gender' => ['male', 'female', 'other'][rand(0, 2)],
                'dob' => now()->subYears(rand(20, 60))->subDays(rand(0, 365))->format('Y-m-d'),
                'phone_number' => '+1' . rand(1000000000, 9999999999),
                'address' => fake()->address(),
            ]);
        });
    }
}
