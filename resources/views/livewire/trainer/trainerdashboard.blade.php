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
        $totalCost = 0;

        foreach ($this->myCourses as $course) {
            $totalStudents += $course->totalStudents();
            $passingRate += $course->passingRate();
        }

        $totalCost = 0;
        foreach ($this->myCourses as $course) {
            $totalCost += $course->totalCost();
        }

        $this->kpis = [
            ['title' => 'My courses', 'value' => $this->myCourses->count()],
            ['title' => 'Staff Enrolled', 'value' => $totalStudents],
            ['title' => 'Passing Rate', 'value' => number_format($passingRate, 1) . '%',],
            ['title' => 'Total Cost', 'value' => 'N$' . number_format($totalCost, 2)]
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
                    <flux:button icon="ellipsis-horizontal" variant="subtle" size="sm"/>
                </div>
            </div>
        @endforeach
    </div>


    <!-- Upcoming Trainings -->


    <!-- Trainee Progress -->
    <div class="relative h-auto flex-1 overflow-hidden rounded-xl p-4 bg-zinc-50 dark:bg-zinc-700">
        <flux:heading>Course Progress</flux:heading>
        <table class="min-w-full mt-4 divide-y divide-neutral-200">
            <thead>
            <tr class="text-neutral-500">
                <th class="text-left">
                    <flux:subheading>Name</flux:subheading>
                </th>
                <th class="text-center">
                    <flux:subheading>Trainee Progress</flux:subheading>
                </th>
            </tr>
            </thead>
            <tbody class="divide-y divide-neutral-200">
            @forelse ($traineeProgress as $course)
                <tr class="hover:bg-slate-100 dark:hover:bg-neutral-600"
                    wire:click="viewCourseDetails({{ $course['id'] }})">
                    <td class="px-5 py-4 text-sm font-medium dark:text-accent text-accent-content">
                        {{ $course['course_name'] }}
                    </td>
                    <td class="px-5 py-4 text-sm whitespace-nowrap text-center">
                        <div>
                            <div
                                class="flex items-center justify-between text-xs font-semibold text-gray-500 dark:text-gray-400">
                                <span>Course Progress:</span>
                                <span>{{ $course['progress'] }}%</span>
                            </div>
                            <div class="h-2 bg-gray-200 dark:bg-gray-600 rounded-full">
                                <div
                                    class="h-full bg-accent-content rounded-full transition-all duration-500 ease-in-out"
                                    style="width: {{ $course['progress'] }}%">
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="px-5 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                        <div class="flex flex-col items-center justify-center space-y-2">
                            <flux:icon name="information-circle" class="w-8 h-8 text-gray-400 dark:text-gray-500"/>
                            <span>No courses available. Start by creating a new course!</span>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <!-- Quick Actions -->


</div>
