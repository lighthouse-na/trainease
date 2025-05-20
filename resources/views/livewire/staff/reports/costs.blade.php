<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public $perPage = 10;
    public $totalAmount = 0;

    public function with(): array
    {
        $enrolledCourses = auth()->user()->enrollments()
            ->with('courses')
            ->paginate($this->perPage);

        $costs = collect();

        foreach ($enrolledCourses as $enrollment) {
            $course = $enrollment->courses;

            if ($course) {
                $costs->push([
                    'course_name' => $course->course_name,
                    'description' => $course->course_description,
                    'amount' => $course->course_fee,
                    'created_at' => $course->created_at->format('F j, Y')
                ]);
            }
        }

        $this->totalAmount = $costs->sum('amount');

        return [
            'costs' => $costs,
            'totalAmount' => $this->totalAmount,
            'paginatedEnrollments' => $enrolledCourses
        ];
    }


}; ?>
<div class="dark:bg-gray-900">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 sm:p-6">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-4 sm:mb-6">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-2 sm:mb-0">Your Course Costs</h2>
        </div>

        @if(count($costs) > 0)
            <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg border dark:border-gray-700">
                <div class="min-w-full">
                    <table class="w-full whitespace-nowrap text-sm">
                        <thead class="hidden sm:table-header-group">
                            <tr class="bg-gradient-to-r from-accent to-accent-content text-white">
                                <th class="px-3 sm:px-4 py-2 sm:py-3 text-left font-medium rounded-tl-lg">Course</th>
                                <th class="px-3 sm:px-4 py-2 sm:py-3 text-left font-medium hidden md:table-cell">Description</th>
                                <th class="px-3 sm:px-4 py-2 sm:py-3 text-right font-medium">Amount</th>
                                <th class="px-3 sm:px-4 py-2 sm:py-3 text-left font-medium rounded-tr-lg hidden sm:table-cell">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($costs as $cost)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 border-b border-gray-100 dark:border-gray-700 flex flex-col sm:table-row">
                                    <td class="px-3 sm:px-4 py-2 sm:py-3 font-medium dark:text-gray-300">
                                        <span class="sm:hidden font-bold inline-block w-24">Course:</span>
                                        {{ $cost['course_name'] ?? 'N/A' }}
                                    </td>
                                    <td class="px-3 sm:px-4 py-2 sm:py-3 dark:text-gray-300 hidden md:table-cell">
                                        {{ Str::limit($cost['description'] ?? 'N/A', 50) }}
                                    </td>
                                    <td class="px-3 sm:px-4 py-2 sm:py-3 text-right dark:text-gray-300">
                                        <span class="sm:hidden font-bold inline-block w-24 text-left">Amount:</span>
                                        N${{ number_format($cost['amount'], 2) }}
                                    </td>
                                    <td class="px-3 sm:px-4 py-2 sm:py-3 dark:text-gray-300 hidden sm:table-cell">
                                        {{ $cost['created_at'] ?? 'N/A' }}
                                    </td>
                                </tr>
                            @endforeach
                            <!-- Total Row -->
                            <tr class="bg-gray-100 dark:bg-gray-700 font-bold flex flex-col sm:table-row">
                                <td class="px-3 sm:px-4 py-2 sm:py-3 dark:text-gray-300 sm:hidden">Grand Total: N${{ number_format(collect($costs)->sum('amount'), 2) }}</td>
                                <td class="hidden sm:table-cell px-3 sm:px-4 py-2 sm:py-3 dark:text-gray-300" colspan="2">Grand Total</td>
                                <td class="hidden sm:table-cell px-3 sm:px-4 py-2 sm:py-3 text-right dark:text-gray-300">N${{ number_format(collect($costs)->sum('amount'), 2) }}</td>
                                <td class="hidden sm:table-cell px-3 sm:px-4 py-2 sm:py-3 dark:text-gray-300"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="text-center py-6 sm:py-8">
                <svg class="mx-auto h-10 w-10 sm:h-12 sm:w-12 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No records found</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">No costs found for your courses.</p>
            </div>
        @endif
        <div class="my-4">
            {{ $paginatedEnrollments->links() }}
        </div>
    </div>
</div>
