<?php

use Livewire\Volt\Component;
use App\Models\Training\Course;
use App\Models\UserDetail;

new class extends Component {
    public $usersInStemCourses = [];
    public $femaleUsersInStemCourses = [];
    public $femalePercentage = 0;
    public $malePercentage = 0;
    public $percentageDifference = 0;

    public function mount(): void
    {
        $this->fetchUsersInStemCourses();
        $this->calculateGenderMetrics();
    }

    private function fetchUsersInStemCourses(): void
    {
        // Fetch all users in STEM courses grouped by gender
        $this->usersInStemCourses = [
            'female' => UserDetail::where('gender', 'female')
                ->whereHas('user.enrolledCourses', function ($query) {
                    $query->where('is_stem', true);
                })
                ->with('user.enrolledCourses')
                ->get(),
            'male' => UserDetail::where('gender', 'male')
                ->whereHas('user.enrolledCourses', function ($query) {
                    $query->where('is_stem', true);
                })
                ->with('user.enrolledCourses')
                ->get(),
        ];

        // Fetch only female users in STEM courses
        $this->femaleUsersInStemCourses = $this->usersInStemCourses['female'];
    }

    private function calculateGenderMetrics(): void
    {
        $femaleCount = $this->usersInStemCourses['female']->count();
        $maleCount = $this->usersInStemCourses['male']->count();
        $totalUsers = $femaleCount + $maleCount;

        if ($totalUsers > 0) {
            $this->femalePercentage = ($femaleCount / $totalUsers) * 100;
            $this->malePercentage = ($maleCount / $totalUsers) * 100;
            $this->percentageDifference = abs($this->femalePercentage - $this->malePercentage);
        }
    }

    //goal
    //female in stem course only
    //need to get user details of all females who are in a course whos is_stem field is true

    //All male and female in course metrics on the gap percentages
    //need to get user details of all females and males who are in a course whos is_stem field is true


    //query example

    // Get filtered data based on period selection
    // $query = Summary::where('user_id', Auth::user()->id)->with('course', 'user');

}; ?>

<div>
    <h2 class="text-lg font-bold mb-4">STEM Course Metrics  change to {actual course thingy later} </h2>

    <div class="mb-6">
        <p><strong>Female Percentage:</strong> {{ number_format($femalePercentage, 2) }}%</p>
        <p><strong>Male Percentage:</strong> {{ number_format($malePercentage, 2) }}%</p>
        <p><strong>Percentage Difference:</strong> {{ number_format($percentageDifference, 2) }}%</p>
    </div>

    <h3 class="text-md font-bold mt-4">Female Users in STEM Courses</h3>
    @if($femaleUsersInStemCourses->isEmpty())
        <p>No female users are enrolled in STEM courses.</p>
    @else
        <ul>
            @foreach($femaleUsersInStemCourses as $user)
                <li class="mb-2">
                    <strong>Name:</strong> {{ $user->user->name }}<br>
                    <strong>Course(s):</strong>
                    <ul>
                        @foreach($user->user->enrolledCourses as $course)
                            <li>{{ $course->course_name }}</li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    @endif

    <h3 class="text-md font-bold mt-4">Male Users in STEM Courses</h3>
    @if($usersInStemCourses['male']->isEmpty())
        <p>No male users are enrolled in STEM courses.</p>
    @else
        <ul>
            @foreach($usersInStemCourses['male'] as $user)
                <li class="mb-2">
                    <strong>Name:</strong> {{ $user->user->name }}<br>
                    <strong>Course(s):</strong>
                    <ul>
                        @foreach($user->user->enrolledCourses as $course)
                            <li>{{ $course->course_name }}</li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    @endif
</div>
