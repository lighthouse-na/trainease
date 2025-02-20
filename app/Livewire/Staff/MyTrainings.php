<?php

namespace App\Livewire\Staff;

use App\Models\Training\Enrollment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MyTrainings extends Component
{
    public function index()
    {
        return view('staff.training.my-training');
    }
    public function render()
    {

        $enrollments = Enrollment::where('user_id', Auth::user()->id)->with('training')->paginate(3);

        return view('livewire.staff.my-trainings',compact('enrollments'));
    }
}
