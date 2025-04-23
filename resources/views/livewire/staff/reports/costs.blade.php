<?php

use Livewire\Volt\Component;
new class extends Component {
    public $costs = [];

    public function mount()
    {
        $this->loadCosts();
    }

    public function loadCosts()
    {
        // Get all costs related to courses where the user is enrolled
        $this->costs = collect();

        $enrolledCourses = auth()->user()->enrollments()->with('courses')->get();

        foreach ($enrolledCourses as $enrollment) {
            $course = $enrollment->courses;

            if ($course) {
                $this->costs->push([
                    'course_name' => $course->course_name,
                    'description' => $course->course_description,
                    'amount' => $course->course_fee,
                    'created_at' => $course->created_at->format('Y-m-d')
                ]);
            }
        }

        $this->costs = $this->costs->toArray();
    }
}; ?>

<div class="p-4">
    <h2 class="text-xl font-semibold mb-4">Your Course Costs</h2>

    @if(count($costs) > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border">Course</th>
                        <th class="px-4 py-2 border">Description</th>
                        <th class="px-4 py-2 border">Amount</th>
                        <th class="px-4 py-2 border">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($costs as $cost)
                        <tr>
                            <td class="px-4 py-2 border">{{ $cost['course_name'] ?? 'N/A' }}</td>
                            <td class="px-4 py-2 border">{{ $cost['description'] ?? 'N/A' }}</td>
                            <td class="px-4 py-2 border">{{ number_format($cost['amount'], 2) }}</td>
                            <td class="px-4 py-2 border">{{ $cost['created_at'] ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="px-4 py-2 font-bold text-right border">Total:</td>
                        <td class="px-4 py-2 font-bold border">{{ number_format(collect($costs)->sum('amount'), 2) }}</td>
                        <td class="px-4 py-2 border"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @else
        <p class="text-gray-500">No costs found for your courses.</p>
    @endif
</div>
