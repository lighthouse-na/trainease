<?php

use Livewire\Volt\Component;
use App\Models\Training\Enrollment;
use Illuminate\Support\Facades\Auth;
new class extends Component {
    //
    public $enrollments;
    public $stats;
    public function mount()
    {
        $userId = Auth::id();

        // Single query with eager loading for enrollments
        $this->enrollments = Enrollment::with('courses')->where('user_id', $userId)->get();

        // Calculate stats from the collection instead of separate queries
        $enrollmentCollection = $this->enrollments;
        $totalEnrollments = $enrollmentCollection->count();
        $averageScore = $enrollmentCollection->avg('score') ?? 0;
        $totalCost = $enrollmentCollection->sum(function ($enrollment) {
            return $enrollment->courses->course_fee ?? 0;
        });

        $this->stats = [
            [
                'title' => 'Enrolled Courses',
                'value' => $totalEnrollments,
                'trend' => '+23.1%',
                'trendUp' => true,
            ],

            [
                'title' => 'Average Score',
                'value' => $averageScore . '%',
                'trend' => '+4.3%',
                'trendUp' => true,
            ],
            [
                'title' => 'My Total Training Cost',
                'value' => 'N$ ' . $totalCost,
                'trend' => '+17.2%',
                'trendUp' => true,
            ],
        ];
    }
}; ?>

<div class="">
    <div class="flex gap-6 mb-6">
        @foreach ($stats as $stat)
            <div
                class="relative flex-1 rounded-lg px-6 py-4 bg-zinc-50 dark:bg-zinc-700 {{ $loop->iteration > 1 ? 'max-md:hidden' : '' }}  {{ $loop->iteration > 3 ? 'max-lg:hidden' : '' }}">
                <flux:subheading>{{ $stat['title'] }}</flux:subheading>

                <flux:heading size="xl" class="mb-2">{{ $stat['value'] }}</flux:heading>

                {{-- <div
                    class="flex items-center gap-1 font-medium text-sm @if ($stat['trendUp']) text-green-600 dark:text-green-400 @else text-red-500 dark:text-red-400 @endif">
                    <flux:icon :icon="$stat['trendUp'] ? 'arrow-trending-up' : 'arrow-trending-down'" variant="micro" />
                    {{ $stat['trend'] }}
                </div> --}}

                <div class="absolute top-0 right-0 pr-2 pt-2">
                    <flux:button icon="ellipsis-horizontal" variant="subtle" size="sm" />
                </div>
            </div>
        @endforeach
    </div>

    <div class="relative h-auto flex-1 overflow-hidden rounded-xl p-4 bg-zinc-50 dark:bg-zinc-700">
        <flux:heading>My Trainings</flux:heading>

        <div class="flex flex-col mt-6">

            <div class="overflow-x-auto">
                <div class="inline-block min-w-full">
                    <div class="overflow-hidden">
                        <table class="min-w-full divide-y divide-neutral-200">
                            <thead>
                                <tr class="text-neutral-500">
                                    <th class="text-left">
                                        <flux:subheading>Course</flux:subheading>
                                    </th>
                                    <th class="text-center">
                                        <flux:subheading>Progress</flux:subheading>
                                    </th>
                                    <th class="text-center">
                                        <flux:subheading>Status</flux:subheading>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-200">
                                @forelse ($enrollments as $enrollment)
                                    <tr class="text-neutral-800 hover:bg-slate-100 dark:hover:bg-neutral-600 cursor-pointer"
                                        onclick="window.location='{{ route('course.show', ['course_id' => Hashids::encode($enrollment->courses->id), 'enrollment_id' => Hashids::encode($enrollment->id)]) }}'">
                                        <td
                                            class="px-5 py-4 text-sm font-medium whitespace-nowrap dark:text-accent text-accent-content">
                                            {{ $enrollment->courses->course_name }}
                                        </td>
                                        @php
                                            $progress = min(
                                                100,
                                                round(Auth::user()->calculateProgress($enrollment->courses->id)),
                                            );
                                        @endphp

                                        <td class="px-5 py-4 text-sm whitespace-nowrap text-center">
                                            <div class=" ">
                                                <div
                                                    class="flex items-center justify-between text-xs font-semibold text-gray-500 dark:text-gray-400">
                                                    <span>Course Progress:</span>
                                                    <span>{{ $progress }}%</span>
                                                </div>
                                                <div class="h-2 bg-gray-200 dark:bg-gray-600 rounded-full">
                                                    <div class="h-full bg-accent-content rounded-full transition-all duration-500 ease-in-out"
                                                        style="width: {{ $progress }}%">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4 text-sm whitespace-nowrap text-center">
                                            <span class="text-xs font-medium text-green-600 dark:text-green-400 py-1 ">
                                                {{ $enrollment->status }}
                                            </span>
                                        </td>

                                    </tr>


                                @empty
                                    <tr>
                                        <td colspan="4" class="px-5 py-10 text-center ">
                                            <div class="flex flex-col items-center justify-center ">
                                                <flux:icon icon="academic-cap" class="w-12 h-12 mb-3 text-gray-300" />
                                                <flux:heading size="lg">You have not enrolled in any course
                                                </flux:heading>
                                                <p class="mt-2 text-gray-500">Start your learning journey by enrolling
                                                    in a course.</p>
                                                <a href="{{ route('training.coursespage') }}"
                                                    class="mt-4 px-4 py-2 bg-accent-content hover:bg-accent text-accent-foreground rounded-md transition-colors">
                                                    Browse Courses
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="my-6">

        @livewire('custom-components.activity-graph')
    </div>
</div>
