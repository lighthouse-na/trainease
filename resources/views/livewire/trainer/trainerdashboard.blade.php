<?php

use Livewire\Volt\Component;
use App\Models\Training\Course;
new class extends Component {
    public $kpis;
    public $upcomingTrainings;
    public $pendingQuizzes;
    public $traineeProgress;

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
            $passingRate += $course->passRate();
        }

        $totalCost = 0;
        foreach ($this->myCourses as $course) {
            $totalCost += $course->totalCost();
        }

        $this->kpis = [
            ['title' => 'My courses', 'value' => $this->myCourses->count()],
            ['title' => 'Staff Enrolled', 'value' => $totalStudents ],
            ['title' => 'Passing Rate', 'value' => number_format($passingRate, 1) . '%', ],
            ['title' => 'Total Cost', 'value' => 'N$' . number_format($totalCost, 2)]
        ];

        $this->upcomingTrainings = [
            ['title' => 'Cybersecurity Basics', 'date' => 'March 10, 2025', 'time' => '10:00 AM'],
            ['title' => 'Data Privacy Workshop', 'date' => 'March 15, 2025', 'time' => '2:00 PM']
        ];

        $this->traineeProgress = [];

        foreach ($this->myCourses as $course) {
            // Calculate average progress for each course
            $averageProgress = $course->avgCourseProgress();

            $this->traineeProgress[] = [
                'course_name' => $course->course_name,
                'progress' => $averageProgress
            ];
            }


        // Fallback if no courses have enrollments
        if (empty($this->traineeProgress)) {
            $this->traineeProgress = [
            ['course_name' => 'No active courses', 'progress' => 0]
            ];
        }
    }
};
?>
<div class="space-y-6 p-6">
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center gap-2">
            <div class="flex items-center gap-2">
                <flux:select size="sm" class="">
                    <option>Last 7 days</option>
                    <option>Last 14 days</option>
                    <option selected>Last 30 days</option>
                    <option>Last 60 days</option>
                    <option>Last 90 days</option>
                </flux:select>

                <flux:subheading class="max-md:hidden whitespace-nowrap">compared to</flux:subheading>

                <flux:select size="sm" class="max-md:hidden">
                    <option selected>Previous period</option>
                    <option>Same period last year</option>
                    <option>Last month</option>
                    <option>Last quarter</option>
                    <option>Last 6 months</option>
                    <option>Last 12 months</option>
                </flux:select>
            </div>

            <flux:separator vertical class="max-lg:hidden mx-2 my-2" />

            <div class="max-lg:hidden flex justify-start items-center gap-2">
                <flux:subheading class="whitespace-nowrap">Filter by:</flux:subheading>

                <flux:badge as="button" variant="pill" color="zinc" icon="plus" size="lg">Amount
                </flux:badge>
                <flux:badge as="button" variant="pill" color="zinc" icon="plus" size="lg"
                    class="max-md:hidden">Status</flux:badge>
                <flux:badge as="button" variant="pill" color="zinc" icon="plus" size="lg">More filters...
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
                    <flux:button icon="ellipsis-horizontal" variant="subtle" size="sm" />
                </div>
            </div>
        @endforeach
    </div>


    <!-- Upcoming Trainings -->
    <div class="relative h-auto flex-1 overflow-hidden rounded-xl p-4 bg-zinc-50 dark:bg-zinc-700">
        <flux:heading>📅 Upcoming Training Sessions</flux:heading>
        <ul class="mt-4">
            @foreach ($upcomingTrainings as $training)
                <li class="border-b py-2 flex justify-between">
                    <span class="font-medium">{{ $training['title'] }}</span>
                    <span class="text-gray-500">{{ $training['date'] }} at {{ $training['time'] }}</span>
                </li>
            @endforeach
        </ul>
    </div>



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
                        <flux:subheading>Pass Rate</flux:subheading>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-200">
                @foreach ($traineeProgress as $trainee)
                    <tr class="hover:bg-slate-100 dark:hover:bg-neutral-600">
                        <td class="px-5 py-4 text-sm font-medium dark:text-accent text-accent-content">
                            {{ $trainee['course_name'] }}
                        </td>
                        <td class="px-5 py-4 text-sm whitespace-nowrap text-center">
                            <div>
                                <div
                                    class="flex items-center justify-between text-xs font-semibold text-gray-500 dark:text-gray-400">
                                    <span>Pass Rate:</span>
                                    <span>{{ $trainee['progress'] }}%</span>
                                </div>
                                <div class="h-2 bg-gray-200 dark:bg-gray-600 rounded-full">
                                    <div class="h-full bg-accent-content rounded-full transition-all duration-500 ease-in-out"
                                        style="width: {{ $trainee['progress'] }}%">
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Quick Actions -->

</div>
