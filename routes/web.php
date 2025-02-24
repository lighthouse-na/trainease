<?php

use App\Http\Controllers\Training\CourseProgressController;
use App\Livewire\Quiz\QuizComponent;
use App\Livewire\Staff\MyTrainings;
use App\Livewire\Staff\TrainingCoursesPage;
use App\Livewire\Staff\TrainingRequestForm;
use App\Livewire\Training\Components\EnrollButton;
use App\Livewire\Training\Course;
use App\Models\Training\Enrollment;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Spatie\Browsershot\Browsershot;
use Vinkla\Hashids\Facades\Hashids;




Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/trainings', [TrainingCoursesPage::class, 'index'])->name('training.courses');
    Route::get('/training-request-form', [TrainingRequestForm::class, 'index'])->name('training.request');
    Route::get('/mytrainings', [MyTrainings::class, 'index'])->name('my.trainings');
    Route::get('/course/{course_id}', [Course::class, 'show'])->name('start.course');
    Route::post('/progress/update', [CourseProgressController::class, 'updateProgress']);
    Route::get('/training/{course_id}', [TrainingCoursesPage::class, 'show'])->name('training.show');
    Route::post('/enroll/{course_id}', [EnrollButton::class, 'enroll'])->name('enroll');
    Route::get('/quiz/{quiz}', [QuizComponent::class, 'show'])->name('quiz.show');
    Route::get('/certificate/{enrollment}', function ($enrollment) {
        // Generate the certificate HTML with data

        $data = Enrollment::find(Hashids::decode($enrollment)[0]);
        $pdf = view('downloads.certificate', ['enrollment' => $data])->render();
        Browsershot::html($pdf)
        ->showBackground()
        ->landscape()
        ->format('A4')
        ->save(storage_path('app/public/cert.pdf'));
        return Response::download(storage_path('app/public/cert.pdf'));

        // Return the PDF for download
    })->name('certificate');
    Route::get('/test/certificate', function () {
        // Generate the certificate HTML with data
        $data = Enrollment::find(1);
        return view('downloads.certificate', ['enrollment' => $data]);

    })->name('test.certificate');


});
