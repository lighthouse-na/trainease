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
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;


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
    Route::get('/course/{course_id}', [Course::class,'show'])->name('start.course');
    Route::post('/progress/update', [CourseProgressController::class, 'updateProgress']);
    Route::get('/training/{course_id}', [TrainingCoursesPage::class, 'show'])->name('training.show');
    Route::post('/enroll/{course_id}', [EnrollButton::class, 'enroll'])->name('enroll');
    Route::get('quiz/{quiz}', [QuizComponent::class, 'show'])->name('quiz.show');

    Route::get('/certificate/{enrollment}', function(Enrollment $enrollment) {
        // Generate the certificate HTML with data
        $template = View::make('downloads.certificate', ['enrollment' => $enrollment])->render();

        // Define a temporary file path for the PDF
        $pdfPath = storage_path('app/certificates/certificate-' . $enrollment->id . '.pdf');

        // Generate PDF using Browsershot
        Browsershot::html($template)
            ->showBackground()
            ->savePdf($pdfPath);

        // Return the PDF for download
        return Response::download($pdfPath, 'certificate-' . $enrollment->id . '.pdf')->deleteFileAfterSend(true);
    })->name('certificate');
});
