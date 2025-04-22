<?php

use Livewire\Volt\Component;
use App\Models\Training\Course;

new class extends Component {
    public $kpis;
    public $upcomingTrainings;
    public $pendingQuizzes;
    /**
     * @var array<int, string, string> $traineeProgress
     */
    public array $traineeProgress;

    public $myCourses;

    public function mount()
    {

        $this->myCourses = Course::where('user_id', Auth::id())->get();
        // Use the trainer KPI functions for the actual calculations
        $totalStudents = 0;
        $avgCompletionRate = 0;
        $passingRate = 0;

        // women intech stuff
        $womenInTechPercentage = 0.00;
        $totalEnrolled = 0;
        $totalWomen = 0;

        foreach ($this->myCourses as $course) {
            $totalStudents += $course->totalStudents();
            $passingRate += $course->passingRate();
        }


        $totalCost = 0.00;
        foreach ($this->myCourses as $course) {
            if ($course->summary !== null) {
            $totalCost += $course->summary->total_cost ?? 0.00;
            }
        }

        foreach ($this->myCourses as $course) {
            if ($course->enrolledUsers()->exists()) {
                $totalEnrolled += $course->enrolledUsers()->count();
                $totalWomen += $course->enrolledUsers()->whereHas('user_detail', function ($query) {
                    $query->where('gender', 'female');
                })->count();
            }
        }

        if ($totalEnrolled > 0) {
            $womenInTechPercentage = ($totalWomen / $totalEnrolled) * 100;
        }

        $this->kpis = [
            ['title' => 'My courses', 'value' => $this->myCourses->count(), 'route' =>'#'],
            ['title' => 'Staff Enrolled', 'value' => $totalStudents, 'route' => '#'],
            ['title' => 'Passing Rate', 'value' => number_format($passingRate, 1) . '%', 'route' => '#'],
            ['title' => 'Total Cost', 'value' => 'N$' . number_format($totalCost, 2), 'route' => 'summary'],
            ['title' => 'Women in STEM', 'value' => number_format($womenInTechPercentage, 2) . '%', 'route' => 'women-in-tech-summary'],//           // add the women in stem shandie here aswell
        ];


        $this->traineeProgress = [];

        foreach ($this->myCourses as $course) {
            // Calculate average progress for each course
            $averageProgress = $course->avgCourseProgress();

            $this->traineeProgress[] = [
                'id' => $course->id,
                'course_name' => $course->course_name,
                'progress' => $averageProgress
            ];
        }


        // Fallback if no courses have enrollments
        if (empty($this->traineeProgress)) {
            $this->traineeProgress = [
            ];
        }
    }

    public function createCourse()
    {
        // Redirect to the create course page
        return redirect()->route('create.course', ['course' => null]);
    }

    public function viewCourseDetails($course_id)
    {
        // Redirect to the course details page
        return redirect()->route('course.details', ['course_id' => Hashids::encode($course_id)]);
    }
};
?>
<div class="space-y-6 p-6">
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center gap-2">


            <div class="max-lg:hidden flex justify-start items-center gap-2">
                <flux:subheading class="whitespace-nowrap">Quick Actions:</flux:subheading>

                <flux:badge wire:click="createCourse" as="button" variant="pill" color="zinc" icon="plus" size="lg">
                    Create Course
                </flux:badge>

            </div>
        </div>


    </div>
    <!-- KPI Overview -->
    <div class="flex gap-6 mb-6">
        @foreach ($kpis as $kpi)
            <div class="relative flex-1 rounded-lg px-6 py-4 bg-zinc-50 dark:bg-zinc-700">
                <flux:subheading>{{ $kpi['title'] }}</flux:subheading>
                <flux:heading size="xl" class="mb-2">{{ $kpi['value'] }}</flux:heading>

                <div
                    class="flex items-center gap-1 font-medium text-sm">

                </div>

                <div class="absolute top-0 right-0 pr-2 pt-2">
                    <flux:button icon="ellipsis-horizontal" href="{{ $kpi['route'] }}" variant="subtle" size="sm"/>
                </div>

            </div>
        @endforeach
    </div>


    <!-- Upcoming Trainings -->


    <!-- Trainee Progress -->
    <div class="relative h-auto flex-1 overflow-hidden rounded-lg ">
        <flux:heading>Course I Manage</flux:heading>
        <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg border dark:border-gray-700 mt-4">
            <table class="w-full whitespace-nowrap text-sm">
                <thead>
                    <tr class="bg-gradient-to-r from-accent to-accent-content text-white">
                        <th class="px-4 py-3 text-left font-medium rounded-tl-lg">Course Name</th>
                        <th class="px-4 py-3 text-left font-medium rounded-tr-lg">Staff Progress</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($traineeProgress as $course)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 border-b border-gray-100 dark:border-gray-700"
                            wire:click="viewCourseDetails({{ $course['id'] }})">
                            <td class="px-4 py-3 font-medium dark:text-gray-300">{{ $course['course_name'] }}</td>
                            <td class="px-4 py-3 dark:text-gray-300">
                                <div>
                                    <div class="flex items-center justify-between text-xs font-semibold text-gray-500 dark:text-gray-400">
                                        <span>Course Progress:</span>
                                        <span>{{ $course['progress'] }}%</span>
                                    </div>
                                    <div class="h-2 bg-gray-200 dark:bg-gray-600 rounded-full">
                                        <div class="h-full bg-accent-content rounded-full transition-all duration-500 ease-in-out"
                                            style="width: {{ $course['progress'] }}%">
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-4 py-8 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No courses available</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Start by creating a new course!</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Actions -->


</div>
