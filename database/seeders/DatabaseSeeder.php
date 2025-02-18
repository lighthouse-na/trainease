<?php

namespace Database\Seeders;

use App\Models\Organisation\Department;
use App\Models\Organisation\Division;
use App\Models\Quiz\Quiz;
use App\Models\Training\Badge;
use App\Models\Training\CourseMaterial;
use App\Models\Training\SubsistenceAndTravel;
use App\Models\Training\Training;
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
        $userCount = 50;  // Example: 50 users

        $trainingCount = 5;  // Example: 5 trainings


        // Start seeding Divisions with progress bar

        $this->command->info('Seeding Divisions...');

        $divisionBar = $this->command->getOutput()->createProgressBar(6);

        $divisionBar->start();

        Division::factory(6)->create();

        $divisionBar->advance(6);

        $divisionBar->finish();

        $this->command->info("\n");


        // Start seeding Departments with progress bar

        $this->command->info('Seeding Departments...');

        $departmentBar = $this->command->getOutput()->createProgressBar(12);

        $departmentBar->start();

        Department::factory(12)->create();

        $departmentBar->advance(12);

        $departmentBar->finish();

        $this->command->info("\n");


        // Start seeding Users with progress bar

        $this->command->info('Seeding Users...');

        $userBar = $this->command->getOutput()->createProgressBar($userCount);

        $userBar->start();

        User::factory($userCount)->create();

        $userBar->advance($userCount); // Advance to the end

        $userBar->finish();

        $this->command->info("\n");


        // Start seeding Trainings with progress bar

        $this->command->info('Seeding Trainings...');

        $trainingBar = $this->command->getOutput()->createProgressBar($trainingCount);

        $trainingBar->start();


        $trainings = Training::factory($trainingCount)->create(); // Store created trainings


        $trainingBar->advance($trainingCount);

        $trainingBar->finish();

        $this->command->info("\n");


        // Start seeding Course Materials for each training

        $this->command->info('Seeding Course Materials...');
        $materialBar = $this->command->getOutput()->createProgressBar(12 * $trainingCount);
        $materialBar->start();
        foreach ($trainings as $training) {
            // Create course materials for each training
            CourseMaterial::factory(12)->create([
                'training_id' => $training->id,
            ]);
            Quiz::factory()->create([
                'training_id' => $training->id,
                'title' => 'Dummy Quiz for ' . $training->title,
            ]);
        }
        $materialBar->advance(12 * $trainingCount);
        $materialBar->finish();
        $this->command->info("\n");


        // // Start seeding Subsistence and Travel with progress bar

        // $this->command->info('Seeding Subsistence and Travel...');

        // $subsistenceAndTravelBar = $this->command->getOutput()->createProgressBar($subsistenceAndTravelCount);

        // $subsistenceAndTravelBar->start();

        // SubsistenceAndTravel::factory($subsistenceAndTravelCount)->create();

        // $subsistenceAndTravelBar->advance($subsistenceAndTravelCount);

        // $subsistenceAndTravelBar->finish();

        // $this->command->info("\n");


        // // Start seeding Badges with progress bar

        // $this->command->info('Seeding Badges...');

        // $badgeBar = $this->command->getOutput()->createProgressBar($badgeCount);

        // $badgeBar->start();

        // Badge::factory($badgeCount)->create();

        // $badgeBar->advance($badgeCount);

        // $badgeBar->finish();

        // $this->command->info("\n");


        $this->command->info('Database seeding completed!');
    }
}
