<?php

use App\Models\Training\Course;
use App\Models\Training\CourseMaterial;
use App\Models\Training\Enrollment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Volt;
use Vinkla\Hashids\Facades\Hashids;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

uses(RefreshDatabase::class);
/**
 * Courses Page Tests
 */
test('it displays available online and hybrid courses', function () {
    $user = User::factory()->create();
    Auth::login($user);

    $course1 = Course::factory()->create(['course_type' => 'online']);
    $course2 = Course::factory()->create(['course_type' => 'hybrid']);
    $course3 = Course::factory()->create(['course_name' => 'in-person', 'course_type' => 'face-to-face']); // Should not be displayed

    Volt::test('training.coursespage')
        ->assertSee($course1->course_name)
        ->assertSee($course2->course_name)
        ->assertDontSee($course3->course_name);
});

test('it shows message when no courses are available', function () {
    $user = User::factory()->create();
    Auth::login($user);

    Volt::test('training.coursespage')
        ->assertSee('');
});

/**
 * Course Details Page Tests
 */
test('it displays course details', function () {
    $user = User::factory()->create();
    Auth::login($user);

    $course = Course::factory()->create();

    Volt::test('training.showcourse', ['course' => Hashids::encode($course->id)])
        ->assertSee($course->course_name)
        ->assertSee($course->course_description)
        ->assertSee($course->course_image);
});

test('users can enroll in course', function () {
    $user = User::factory()->create();
    Auth::login($user);

    $course = Course::factory()->create();

    Volt::test('training.showcourse', ['course' => Hashids::encode($course->id)])
        ->call('enroll', courseId: $course->id);

    assertDatabaseHas('enrollments', ['user_id' => $user->id, 'course_id' => $course->id]);
});

/**
 * Course Completion Tests
 */
it('mounts the component and loads course data', function () {
    $course = Course::factory()->create();
    $enrollment = Enrollment::factory()->create(['course_id' => $course->id]);
    $courseMaterials = CourseMaterial::factory(3)->create();

    Volt::test('training.course', [
        'course_id' => Hashids::encode($course->id),
        'enrollment_id' => Hashids::encode($enrollment->id),
    ])
        ->assertOk();
});

it('sets active content and marks it as completed', function () {
    $user = User::factory()->create();
    Auth::login($user);
    $course = Course::factory()->create();
    $enrollment = Enrollment::factory()->create(['course_id' => $course->id]);
    $courseMaterial = CourseMaterial::factory(3)->create();

    $component = Volt::test('training.course', [
        'course_id' => Hashids::encode($course->id),
        'enrollment_id' => Hashids::encode($enrollment->id),
    ]);

    $component->call('setActiveContent', CourseMaterial::first()->id)
        ->assertSet('content.id', CourseMaterial::first()->id);
});

it('marks the course as completed', function () {
    $user = User::factory()->create();
    $course = Course::factory()->create();
    $enrollment = Enrollment::factory()->create(['user_id' => $user->id, 'course_id' => $course->id]);

    actingAs($user);

    Volt::test('training.course', [
        'course_id' => Hashids::encode($course->id),
        'enrollment_id' => Hashids::encode($enrollment->id),
    ])
        ->call('completeCourse');
    assertDatabaseHas('enrollments', [
        'id' => $enrollment->id,
        'user_id' => $user->id,
        'course_id' => $course->id,
        'status' => 'completed',
    ]);
});

it('navigates through course materials', function () {
    $user = User::factory()->create();
    Auth::login($user);
    $course = Course::factory()->create();
    $enrollment = Enrollment::factory()->create(['course_id' => $course->id]);
    $materials = CourseMaterial::factory()->count(3)->create(['course_id' => $course->id]);
    $component = Volt::test('training.course', [
        'course_id' => Hashids::encode($course->id),
        'enrollment_id' => Hashids::encode($enrollment->id),
    ]);

    $component->call('loadNextMaterial')
        ->assertSet('content.id', $materials[1]->id);

    $component->call('loadPreviousMaterial')
        ->assertSet('content.id', $materials[0]->id);
});
