<?php

use App\Models\Training\Course;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Volt\Volt;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

// Setup function to create a logged-in user
function createLoggedInUser()
{
    $user = User::factory()->create();
    $user->assignRole('trainer');
    actingAs($user);

    return $user;
}

// Basic course creation tests
it('renders the course creation form', function () {
    createLoggedInUser();

    Volt::test('trainer.create-course')
        ->assertSee('Create Course')
        ->assertSee('Course Title')
        ->assertSee('Description')
        ->assertSet('activeTab', 'course');
});
it('validates course creation input', function () {
    createLoggedInUser();

    $component = Volt::test('trainer.create-course')
        ->set('title', '')
        ->set('description', '')
        ->set('startDate', '')
        ->set('endDate', '')
        ->set('course_fee', '')
        ->set('course_type', '')
        ->set('courseImage', '')
        ->call('saveCourse');

    $component->assertHasErrors([
        'title' => 'required',
        'description' => 'required',
        'startDate' => 'required',
        'endDate' => 'required',
        'course_fee' => 'required',
        'course_type' => 'required',
        'courseImage' => 'required',
    ]);
});

it('creates a course successfully', function () {
    $user = createLoggedInUser();

    // Prepare image upload
    Storage::fake('public');
    $courseImage = UploadedFile::fake()->image('course.jpg');

    Volt::test('trainer.create-course')
        ->set('title', 'Test Advanced Course')
        ->set('description', 'A comprehensive test course description')
        ->set('startDate', now()->addDays(7)->toDateString())
        ->set('endDate', now()->addDays(30)->toDateString())
        ->set('course_fee', 199.99)
        ->set('course_type', 'online')
        ->set('courseImage', $courseImage)
        ->call('saveCourse')
        ->assertHasNoErrors();

    // Verify course was created in database
    assertDatabaseHas('courses', [
        'course_name' => 'Test Advanced Course',
        'course_description' => 'A comprehensive test course description',
        'course_fee' => 199.99,
        'course_type' => 'online',
        'user_id' => $user->id,
        'course_image' => 'course-images/'.$courseImage->hashName(),
    ]);
});

it('prevents adding materials before course creation', function () {
    $user = createLoggedInUser();

    Volt::test('trainer.create-course')
        ->set('materialTitle', 'Test Material')
        ->set('materialDescription', 'Material description')
        ->set('materialContent', 'Material content')
        ->call('saveMaterial')
        ->assertSet('courseCreated', false);
});

it('adds course materials after course creation', function () {
    $user = createLoggedInUser();

    // Create a course first
    Volt::test('trainer.create-course')
        ->set('title', 'Test Course for Materials')
        ->set('description', 'Course for testing materials')
        ->set('startDate', now()->addDays(7)->toDateString())
        ->set('endDate', now()->addDays(30)->toDateString())
        ->set('course_fee', 199.99)
        ->set('course_type', 'online')
        ->set('courseImage', UploadedFile::fake()->image('course.jpg'))
        ->call('saveCourse');

    // Get the created course
    $course = Course::latest()->first();

    // Now add materials
    $materialsComponent = Volt::test('trainer.create-course', ['course' => $course])
        ->set('materialTitle', 'Test Learning Material')
        ->set('materialDescription', 'Detailed material description')
        ->set('materialContent', 'Comprehensive material content')
        ->call('saveMaterial');

    $materialsComponent->assertHasNoErrors()
        ->assertSet('materialTitle', '')
        ->assertSet('materialDescription', '')
        ->assertSet('materialContent', '');

    // Verify material was added
    assertDatabaseHas('course_materials', [
        'course_id' => $course->id,
        'material_name' => 'Test Learning Material',
    ]);
});

it('adds a quiz to a course', function () {
    $user = createLoggedInUser();

    // Create course first
    Volt::test('trainer.create-course')
        ->set('title', 'Quiz Test Course')
        ->set('description', 'Course for testing quizzes')
        ->set('startDate', now()->addDays(7)->toDateString())
        ->set('endDate', now()->addDays(30)->toDateString())
        ->set('course_fee', 199.99)
        ->set('course_type', 'online')
        ->set('courseImage', UploadedFile::fake()->image('course.jpg'))
        ->call('saveCourse');

    // Get the created course
    $course = Course::latest()->first();

    // Add quiz
    $quizComponent = Volt::test('trainer.create-course', ['course' => $course])
        ->set('quizTitle', 'Comprehensive Quiz')
        ->set('quizAttempts', 3)
        ->set('passingScore', 70)
        ->set('questions', [
            [
                'text' => 'What is the capital of France?',
                'question_type' => 'multiple_choice',
                'options' => ['London', 'Berlin', 'Paris', 'Madrid'],
                'correct_answer' => 2,
            ],
        ])
        ->call('saveQuiz');

    $quizComponent->assertHasNoErrors();
    // Verify quiz was added
    assertDatabaseHas('quizzes', [
        'course_id' => $course->id,
        'title' => 'Comprehensive Quiz',
    ]);
});

it('handles tab switching correctly', function () {
    $user = createLoggedInUser();

    $component = Volt::test('trainer.create-course')
        ->set('activeTab', 'course')
        ->call('setTab', 'materials');

    $component->assertSet('activeTab', 'course');

    // Create a course first
    $component->set('title', 'Test Course')
        ->set('description', 'Test description')
        ->set('startDate', now()->addDays(7)->toDateString())
        ->set('endDate', now()->addDays(30)->toDateString())
        ->set('course_fee', 199.99)
        ->set('course_type', 'online')
        ->set('courseImage', UploadedFile::fake()->image('course.jpg'))
        ->call('saveCourse');

    // Now should be able to switch tabs
    $component->call('setTab', 'materials')
        ->assertSet('activeTab', 'materials');

    $component->call('setTab', 'quiz')
        ->assertSet('activeTab', 'quiz');

    $component->call('setTab', 'enrollments')
        ->assertSet('activeTab', 'enrollments');

});
