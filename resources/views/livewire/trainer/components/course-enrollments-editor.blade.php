<?php

use Livewire\Volt\Component;
use App\Models\Training\Course;
use Illuminate\Support\Facades\Auth;
use App\Models\Training\Enrollment;
new class extends Component {
    //
    public $selectedStudents = [];
    public $activeTab = 'course';
    public $course;
    public function mount($course)
    {
        $course = Course::find($course);
        if ($course) {
            $this->course = $course;
        }
        $this->selectedStudents = [];
    }

    public function enrollStudents()
    {
        if (!$this->courseCreated) {
            return;
        }
        // Student enrollment logic here
    }

}; ?>

<div>
    <h3 class="text-lg font-semibold mb-4 dark:text-white">Student Enrollments</h3>

    <h4 class="font-medium mb-2 dark:text-white">Available Students</h4>
    <div class="border rounded-md divide-y max-h-60 overflow-y-auto dark:border-gray-700 dark:divide-gray-700">
        <!-- This would be replaced with search results -->
        <div class="p-4 flex items-center justify-between">
            <div>
                <p class="font-medium dark:text-gray-300">Search for students to enroll</p>
            </div>
        </div>
    </div>
    <h4 class="font-medium mb-2 dark:text-white">Selected Students</h4>

    @if (count($selectedStudents) > 0)
        <div class="border rounded-md divide-y dark:border-gray-700 dark:divide-gray-700">
            @foreach ($selectedStudents as $index => $student)
                <div class="p-3 flex items-center justify-between">
                    <div>
                        <p class="font-medium dark:text-white">{{ $student['name'] }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $student['email'] }}</p>
                    </div>
                    <button type="button" wire:click="removeStudent({{ $index }})"
                        class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-gray-500 italic dark:text-gray-400">No students selected</div>
    @endif

    <x-button type="button" wire:click="enrollStudents" class="bg-accent-content hover:bg-accent-content"
        :disabled="count($selectedStudents) === 0">
        Enroll Selected Students
    </x-button>
</div>
