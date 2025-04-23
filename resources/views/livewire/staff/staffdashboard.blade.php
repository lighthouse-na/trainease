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
                'link' => '#'
            ],

            [
                'title' => 'Average Score',
                'value' => $averageScore . '%',
                'trend' => '+4.3%',
                'trendUp' => true,
                'link' => route('my.grades'),
            ],
            [
                'title' => 'My Total Training Cost',
                'value' => 'N$ ' . $totalCost,
                'trend' => '+17.2%',
                'trendUp' => true,
                'link' => route('my.costs'),
            ],
        ];
    }
}; ?>
<div class="grid grid-cols-4 gap-6">
    <!-- First row: Stats cards -->
    <div class="col-span-3 grid grid-cols-3 gap-6">
        @foreach ($stats as $stat)
            <div class="relative rounded-lg px-6 py-4 bg-zinc-50 dark:bg-zinc-700 {{ $loop->iteration > 1 ? 'max-md:hidden' : '' }} {{ $loop->iteration > 3 ? 'max-lg:hidden' : '' }}">
                <flux:subheading>{{ $stat['title'] }}</flux:subheading>
                <flux:heading size="xl" class="mb-2">{{ $stat['value'] }}</flux:heading>
                <div class="absolute top-0 right-0 pr-2 pt-2">
                    <flux:button icon="ellipsis-horizontal" variant="subtle" size="sm" href="{{ $stat['link'] }}"/>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Activity graph spanning two rows -->
    <div class="col-span-1 row-span-2 rounded-xl">
        @livewire('custom-components.activity-graph')
    </div>

    <!-- Second row: Trainings table -->
    <div class="col-span-3 relative h-auto flex-1 overflow-hidden rounded-lg">
        <flux:heading>My Trainings</flux:heading>
        <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg border dark:border-gray-700 mt-4">
            <table class="w-full whitespace-nowrap text-sm">
                <thead>
                    <tr class="bg-gradient-to-r from-accent to-accent-content text-white">
                        <th class="px-4 py-3 text-left font-medium rounded-tl-lg">Course</th>
                        <th class="px-4 py-3 text-left font-medium">Progress</th>
                        <th class="px-4 py-3 text-left font-medium rounded-tr-lg">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($enrollments as $enrollment)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 border-b border-gray-100 dark:border-gray-700"
                            onclick="window.location='{{ route('course.show', ['course_id' => Hashids::encode($enrollment->courses->id), 'enrollment_id' => Hashids::encode($enrollment->id)]) }}'">
                            <td class="px-4 py-3 font-medium dark:text-gray-300">
                                {{ $enrollment->courses->course_name }}
                            </td>
                            @php
                                $progress = min(
                                    100,
                                    round(Auth::user()->calculateProgress($enrollment->courses->id)),
                                );
                            @endphp
                            <td class="px-4 py-3 dark:text-gray-300">
                                <div>
                                    <div class="flex items-center justify-between text-xs font-semibold text-gray-500 dark:text-gray-400">
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
                            <td class="px-4 py-3 font-medium dark:text-gray-300">
                                <span class="text-xs font-medium text-green-600 dark:text-green-400 py-1">
                                    {{ $enrollment->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-8 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">You have not enrolled in any course</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Start your learning journey by enrolling in a course.</p>
                                <a href="{{ route('training.coursespage') }}" class="mt-4 inline-block px-4 py-2 bg-accent-content hover:bg-accent text-accent-foreground rounded-md transition-colors">
                                    Browse Courses
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
