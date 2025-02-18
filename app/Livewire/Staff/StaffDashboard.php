<?php

namespace App\Livewire\Staff;

use App\Models\Training\Enrollment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StaffDashboard extends Component
{


    public function render()
    {
        $enrolledCourses = Enrollment::where('user_id', Auth::user()->id)
        ->whereIn('status', ['approved'])
        ->take(2) // or ->limit(3)
        ->get();

        $courseCount = Enrollment::where('user_id', Auth::user()->id)
        ->whereIn('status', ['approved', 'completed'])
        ->count();
        return view('livewire.staff.staff-dashboard',compact('enrolledCourses','courseCount'));
    }
}
