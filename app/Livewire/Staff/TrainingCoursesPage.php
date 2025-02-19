<?php

namespace App\Livewire\Staff;

use App\Models\Training\Enrollment;
use App\Models\Training\Training;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Livewire\Component;

class TrainingCoursesPage extends Component
{


    public function index(){
        return view('staff.training.courses');
    }

    public function enroll($trainingId)
    {
        $userId = Auth::id();

        // Check if the user is already enrolled
        if (Enrollment::where('user_id', $userId)->where('training_id', $trainingId)->exists()) {
            session()->flash('error', 'You are already enrolled in this course.');
            return;
        }

        // Create the enrollment
        Enrollment::create([
            'user_id' => $userId,
            'training_id' => $trainingId,
            'status' => 'approved', // Default status
            'enrolled_at' => now(),
        ]);

        session()->flash('success', 'Successfully enrolled in the course.');
    }


    public function show($course_id){
        $training = Training::findOrFail(Crypt::decrypt($course_id));
        return view('staff.training.show-course', compact('training'));
    }


    public function render()
    {
        $trainings = Training::query()->paginate(6);
        $userEnrollments = Enrollment::where('user_id', Auth::id())->pluck('training_id')->toArray();

        return view('livewire.staff.training-courses-page', compact('trainings', 'userEnrollments'));

    }
}
