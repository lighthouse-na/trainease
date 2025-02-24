<?php

namespace App\Livewire\Training;

use App\Models\QuizModule\Quiz;
use App\Models\QuizModule\QuizResponses;
use App\Models\Training\CourseMaterial;
use App\Models\Training\CourseProgress;
use App\Models\Training\Enrollment;
use App\Models\Training\Training;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Livewire\Component;
use Vinkla\Hashids\Facades\Hashids;

class Course extends Component
{
    public $training;
    public $courseMaterials;
    public $courseProgress;
    public $quizzes;
    public $quizResponses;
    public $content;
    public $completedMaterials = [];
    public $enrollment;

    public function mount(Training $training, Enrollment $enrollment)
    {
        $this->training = Training::findOrFail($training->id);
        $this->courseMaterials = CourseMaterial::where('training_id', $training->id)->get();
        $this->quizzes = $training->quizzes;
        $this->courseProgress = 50;
        $this->content = $this->courseMaterials->first() ?? null; // Set to null if no materials exist
        $this->completedMaterials = $this->getCompletedMaterials(Auth::id());
        $this->enrollment = Enrollment::find($enrollment->id);
        $this->quizResponses = QuizResponses::where('user_id', Auth::id())
            ->whereIn('quiz_id', $this->quizzes->pluck('id'))
            ->get()
            ->groupBy('quiz_id')
            ->map(function ($responses) {
            return count($responses);
            });
    }
    public function getCompletedMaterials($userId)
    {
        return $this->courseMaterials->filter(fn($material) => $material->isCompletedByUser($userId))->pluck('id')->toArray();
    }
    public function setActiveContent($materialId)
    {
        $this->content = CourseMaterial::find($materialId);

        // Mark the material as completed if not already
        if (!in_array($materialId, $this->completedMaterials)) {
            $this->markMaterialAsCompleted($materialId);
        }
        $this->dispatch('content-updated');
    }

    public function markMaterialAsCompleted($materialId)
    {
        $userId = Auth::id();

        // Check if already completed
        $exists = CourseProgress::where('user_id', $userId)->where('course_material_id', $materialId)->where('status', 'completed')->exists();

        if (!$exists) {
            CourseProgress::create([
                'user_id' => $userId,
                'training_id' => $this->training->id,
                'course_material_id' => $materialId,
                'status' => 'completed',
            ]);

            // Refresh the completed materials list in real time
            $this->completedMaterials[] = $materialId;
        }
    }

    public function loadNextMaterial()
    {
        $currentMaterialIndex = $this->courseMaterials->search(fn($material) => $material->id === $this->content->id);

        $nextMaterial = $this->courseMaterials->get($currentMaterialIndex + 1);

        if ($nextMaterial) {
            $this->setActiveContent($nextMaterial->id);
        }
    }

    public function loadPreviousMaterial()
    {
        $currentMaterialIndex = $this->courseMaterials->search(fn($material) => $material->id === $this->content->id);

        $previousMaterial = $this->courseMaterials->get($currentMaterialIndex - 1);

        if ($previousMaterial) {
            $this->setActiveContent($previousMaterial->id);
        }
    }

    public function completeCourse(){
        $enrollment = Enrollment::where('user_id', Auth::id())->where('training_id', $this->training->id)->first();

        if (!$enrollment) {
            abort(403, 'You are not enrolled in this course.');
        }

        // Mark course as completed
        $enrollment->update(['status' => 'completed']);

        return redirect()->route('my.trainings', $this->training->id)->with('success', 'Course marked as completed!');
    }

    public function show($training_id)
    {
        // Ensure the user is enrolled and their status is "approved" or "completed"
        $training = Training::findOrFail(Hashids::decode($training_id)[0]);
        $enrollment = Auth::user()
            ->enrollments->where('training_id', $training->id)
            ->whereIn('status', ['approved', 'completed'])
            ->first();

        if (!$enrollment) {
            abort(403, 'You are not authorized to access this course.');
        }

        $courseMaterials = CourseMaterial::where('training_id', $training->id)->get();

        // Access the course materials

        return view('training.course', compact('training', 'enrollment'));
    }

    public function complete(Training $training)
    {
        $enrollment = Enrollment::where('user_id', Auth::id())->where('training_id', $training->id)->first();

        if (!$enrollment) {
            abort(403, 'You are not enrolled in this course.');
        }

        // Mark course as completed
        $enrollment->update(['status' => 'completed']);

        return redirect()->route('my.trainings', $training->id)->with('success', 'Course marked as completed!');
    }

    public function render()
    {
        return view('livewire.training.course');
    }
}
