<?php

use Livewire\Volt\Component;
use App\Models\User;
use App\Models\Training\Enrollment;
use App\Models\Training\Course;
new class extends Component {
    //
    use Livewire\WithPagination;

    public $perPage = 10;
    public $totalAmount = 0;

    public function with(): array
    {
        $enrollments = auth()->user()->enrollments()->get();

        $gradesData = collect();

        foreach ($enrollments as $enrollment) {
            $grade = $enrollment;

            $gradesData->push([
                'course_name' => $enrollment->courses->course_name,
                'grade' => $grade ? $grade->score : 'Not graded',
                'status' => $grade ? ($grade->score > 0 ? ($grade->score >= 70 ? 'Pass' : 'Fail') : 'Pending') : 'Pending',

                'graded_at' => $grade ? $grade->created_at->format('F j, Y') : '-'
            ]);
        }

        $courses = $enrollments->pluck('course')->unique('id');

        return [
            'gradesData' => $gradesData,
            'courses' => $courses
        ];
    }
}; ?>

<div>
    <div class="dark:bg-gray-900">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-4 md:p-6">
            <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-2 sm:mb-0">Your Course Grades</h2>
            </div>

            @if(count($gradesData) > 0)
                <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg border dark:border-gray-700">
                    <table class="w-full whitespace-nowrap text-sm">
                        <thead>
                            <tr class="bg-gradient-to-r from-accent to-accent-content text-white">
                                <th class="px-3 py-2 md:px-4 md:py-3 text-left font-medium rounded-tl-lg">Course</th>
                                <th class="px-3 py-2 md:px-4 md:py-3 text-left font-medium">Grade</th>
                                <th class="px-3 py-2 md:px-4 md:py-3 text-left font-medium">Status</th>
                                <th class="px-3 py-2 md:px-4 md:py-3 text-left font-medium rounded-tr-lg">Graded At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($gradesData as $grade)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 border-b border-gray-100 dark:border-gray-700">
                                    <td class="px-3 py-2 md:px-4 md:py-3 font-medium dark:text-gray-300 break-words">{{ $grade['course_name'] }}</td>
                                    <td class="px-3 py-2 md:px-4 md:py-3 dark:text-gray-300">{{ $grade['grade'] }} %</td>
                                    <td class="px-3 py-2 md:px-4 md:py-3 dark:text-gray-300">
                                        @if($grade['status'] === 'Pass')
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                {{ $grade['status'] }}
                                            </span>
                                        @elseif($grade['status'] === 'Fail')
                                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                {{ $grade['status'] }}
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                                {{ $grade['status'] }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 md:px-4 md:py-3 dark:text-gray-300">{{ $grade['graded_at'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 overflow-x-auto lg:hidden">
                    <p class="text-xs text-gray-600 dark:text-gray-400">Swipe horizontally to view more data</p>
                </div>
            @else
                <div class="text-center py-6 md:py-8">
                    <svg class="mx-auto h-10 w-10 md:h-12 md:w-12 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No records found</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">No grades found for your courses.</p>
                </div>
            @endif
        </div>
    </div>
</div>
