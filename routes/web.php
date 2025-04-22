<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'check.user.details'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
    Volt::route('settings/user-details', 'settings.user-detail-form')->name('settings.user-details');

    Volt::route('courses', 'training.coursespage')->name('training.coursespage')->middleware(['check.user.details']);
    Volt::route('courses/{course}', 'training.showcourse')->name('training.coursepage')->middleware(['check.user.details']);
    Volt::route('quiz/{quiz}', 'training.quiz.quiz')->name('training.quiz')->middleware(['check.user.details']);
    Route::view('course/{course_id}/{enrollment_id}', 'courses.show-course')
        ->middleware(['check.user.details'])
        ->name('course.show');

    Volt::route('/c/course/{course?}', 'trainer.create-course')->name('create.course')->middleware(['role:trainer']);
    Volt::route('c/course_detail/{course_id}/', 'trainer.coursedetails')->name('course.details');
    Volt::route('sme','trainer.sme.index')->name('sme.index');

    /**
     * SkillHarbor Routes
     * These are the routes for the skill audit compnent
     */
    Route::middleware(['skillharbor.active'])->group(function () {
        Route::redirect('skillharbor', 'skillharbor/dashboard')->name('skill-harbor');
        Volt::route('skillharbor/dashboard', 'skillharbor.dashboard')->name('skill-harbor.dashboard');
        Volt::route('skillharbor/assessments', 'skillharbor.assessments')->name('skill-harbor.assessments');
        Volt::route('skillharbor/directories}', 'skillharbor.directories')->name('skill-harbor.directories');
        Volt::route('skillharbor/reports', 'skillharbor.reports')->name('skill-harbor.reports');
        Volt::route('skillharbor/supervise', 'skillharbor.supervise')->name('skill-harbor.supervise');

        /**
         * Directories Routes
         */
        Volt::route('skillharbor/directories/skills', 'skillharbor.directories.skills.skillstable')->name('skill-harbor.skills');
        Volt::route('skillharbor/directories/qualifications', 'skillharbor.directories.qualifications.qualificationstable')->name('skill-harbor.qualifications');
        Volt::route('skillharbor/directories/assessments', 'skillharbor.directories.assessments.assessmentstable')->name('skill-harbor.directories.assessments');
        Volt::route('skillharbor/directories/jcps', 'skillharbor.directories.jcps.jcptable')->name('skill-harbor.directories.jcps');

        /**
         *
         * Summary Routes
         */

         Volt::route('/summary', 'trainer.reports.trainersummary')->name('summary');
         Volt::route('/women-in-tech-summary', 'trainer.reports.women-in-tech-summary')->name('women-in-tech-summary');
    });

});

require __DIR__.'/auth.php';
