<?php

namespace App\Livewire\Training\Components;

use App\Models\Training\Enrollment;
use App\Models\Training\Training;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EnrollButton extends Component
{
    public $training;
    public $isEnrolled = false;

    public function mount(Training $training)
    {
        $this->training = $training;
        $this->checkEnrollment();
    }

    public function checkEnrollment()
    {
        $this->isEnrolled = Enrollment::where('user_id', Auth::user()->id)
                                      ->where('training_id', $this->training->id)
                                      ->exists();
    }

    public function enroll()
    {

        if ($this->isEnrolled) {
            return $this->dispatch('showAlert', 'error', 'You are already enrolled in this course.');
        }
        Enrollment::create([
            'user_id' => Auth::user()->id,
            'training_id' => $this->training->id,
            'status' => 'approved',
            'enrolled_at' => now(),
        ]);

        $this->isEnrolled = true;

        $this->dispatch('showAlert', 'success', 'You have successfully enrolled!');
    }
    public function render()
    {


        return view('livewire.training.components.enroll-button');
    }
}
