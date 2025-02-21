<?php

namespace Database\Seeders;

use App\Models\Organisation\Department;
use App\Models\Organisation\Division;
use App\Models\QuizModule\Option;
use App\Models\QuizModule\Question;
use App\Models\QuizModule\Quiz;
use App\Models\QuizModule\UserAnswer;
use App\Models\QuizModule\UserSelectedOption;
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

        // $this->command->info('Seeding Trainings...');

        // $trainingBar = $this->command->getOutput()->createProgressBar($trainingCount);

        // $trainingBar->start();


        // $trainings = Training::factory($trainingCount)->create(); // Store created trainings


        // $trainingBar->advance($trainingCount);

        // $trainingBar->finish();

        // $this->command->info("\n");


        // // Start seeding Course Materials for each training

        // $this->command->info('Seeding Course Materials...');
        // $materialBar = $this->command->getOutput()->createProgressBar(12 * $trainingCount);
        // $materialBar->start();
        // $materialBar->advance(12 * $trainingCount);
        // $materialBar->finish();
        // $this->command->info("\n");
        // $this->command->info('Seeding Course Materials and Quizzes...');

        // $trainings = Training::all();
        // $trainingCount = $trainings->count();

        // $progressBar = $this->command->getOutput()->createProgressBar($trainingCount);
        // $progressBar->start();

        // // Define quiz topics
        // $quizTopics = [
        //     'Introduction to Laravel',
        //     'Advanced Eloquent ORM',
        //     'Web Security Best Practices',
        //     'Database Design Principles',
        //     'REST API Development',
        //     'Frontend & Backend Integration',
        // ];

        // foreach ($trainings as $training) {
        //     // Create course materials
        //     CourseMaterial::factory(12)->create(['training_id' => $training->id]);

        //     foreach ($quizTopics as $topic) {
        //         // Create a quiz
        //         $quiz = Quiz::factory()->create([
        //             'training_id' => $training->id,
        //             'title' => $topic,
        //             'description' => "Test your knowledge on {$topic}.",
        //         ]);

        //         foreach (range(1, 5) as $i) {
        //             // Generate only multiple-choice questions
        //             $question = Question::factory()->create([
        //                 'quiz_id' => $quiz->id,
        //                 'question_type' => 'multiple_choice',
        //                 'question_text' => $this->generateMultipleChoiceQuestion($topic),
        //             ]);

        //             // Generate realistic multiple-choice options
        //             $this->generateMultipleChoiceOptions($question);
        //         }
        //     }

        //     $progressBar->advance();
        // }

        //     $progressBar->finish();
        //     $this->command->info("\nSeeding completed successfully.");
        //     $this->command->info('Database seeding completed!');
        // }

        // /**
        //  * Generate a multiple-choice question based on a topic.
        //  */
        // private function generateMultipleChoiceQuestion(string $topic): string
        // {
        //     $sampleQuestions = [
        //         "What is the main purpose of {$topic}?",
        //         "Which of the following is a key feature of {$topic}?",
        //         "In {$topic}, what is the best practice for performance optimization?",
        //         "Which of these statements about {$topic} is correct?",
        //         "What should you consider when implementing {$topic}?",
        //     ];

        //     return $sampleQuestions[array_rand($sampleQuestions)];
        // }

        // /**
        //  * Generate multiple-choice options for a given question.
        //  */
        // private function generateMultipleChoiceOptions(Question $question): void
        // {
        //     $correctAnswers = [
        //         "Correct principle of {$question->question_text}",
        //         "Key feature of {$question->question_text}",
        //         "Best practice for {$question->question_text}",
        //     ];

        //     $incorrectAnswers = [
        //         "Misconception about {$question->question_text}",
        //         "Incorrect implementation of {$question->question_text}",
        //         "Non-relevant approach to {$question->question_text}",
        //     ];

        //     shuffle($correctAnswers);
        //     shuffle($incorrectAnswers);

        //     // Create one correct option
        //     Option::factory()->create([
        //         'question_id' => $question->id,
        //         'option_text' => $correctAnswers[0],
        //         'is_correct' => true,
        //     ]);

        //     // Create three incorrect options
        //     foreach (array_slice($incorrectAnswers, 0, 3) as $answer) {
        //         Option::factory()->create([
        //             'question_id' => $question->id,
        //             'option_text' => $answer,
        //             'is_correct' => false,
        //         ]);
        //     }




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
