<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
    Volt::route('settings/user-details', 'settings.user-detail-form')->name('settings.user-details');

    Volt::route('courses', 'training.coursespage')->name('training.coursespage');
    Volt::route('courses/{course}', 'training.showcourse')->name('training.coursepage');
});

Route::view('course/{course_id}/{enrollment_id}', 'courses.show-course')
->middleware(['auth', 'verified'])
->name('course.show');


require __DIR__.'/auth.php';
