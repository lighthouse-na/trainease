<?php

use Livewire\Volt\Component;
use App\Models\Training\Course;
use App\Models\Training\Enrollment;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    //
    public $course;
    public $userEnrollments = [];
    public function mount($course)
    {
        $this->course = Course::find(Hashids::decode($course)[0]);
        $this->userEnrollments = Enrollment::where('user_id', Auth::id())->pluck('course_id')->toArray();
    }
    public function enroll($courseId)
    {
        $userId = Auth::id();

        // Check if the user is already enrolled
        if (in_array($courseId, $this->userEnrollments)) {
            session()->flash('error', 'You are already enrolled in this course.');
            return;
        }

        // Create the enrollment
        Enrollment::create([
            'user_id' => $userId,
            'course_id' => $courseId, // Ensure this matches your DB column name
            'status' => 'approved', // Default status
            'enrolled_at' => now(),
        ]);

        // Update enrollments in real-time
        $this->userEnrollments[] = $courseId;

        session()->flash('success', 'Successfully enrolled in the course.');
    }
}; ?>

<div>
    <div class="relative rounded-xl w-full h-80 bg-gray-800 dark:bg-gray-700">
        <img src="{{ asset($course->course_image) }}"
            class="rounded-xl w-full h-full object-cover opacity-60 dark:opacity-20" alt="{{ $course->title }}">
        <div class="absolute inset-0 flex flex-col justify-center px-10">
            <a href="{{ route('training.coursespage') }}" class="text-gray-200 text-sm mb-3 hover:underline">← Back to
                Courses</a>
            <h1 class="text-gray-100 text-4xl font-bold">{{ $course->course_name }}</h1>
            <p class="text-gray-300 text-lg mt-2">{{ $course->course_description }}</p>
        </div>
        <div class="absolute top-6 right-10 p-4 rounded-xl  text-center">
            <div class="absolute top-6 right-10 p-4 rounded-xl text-center">
                <div class="flex justify-end">
                    @if (in_array($course->id, $userEnrollments))
                        <flux:button variant="filled" disabled>
                            Enrolled
                        </flux:button>
                    @else
                        <flux:button variant="primary" wire:click.prevent="enroll({{ $course->id }})" class="cursor-pointer">
                            Enroll
                        </flux:button>
                    @endif
                </div>
            </div>

        </div>

    </div>

    <!-- Course Content & Instructor Section -->
    <div class="grid grid-cols-4 gap-6 p-10">
        <!-- Course Content -->
        <div class="col-span-3 dark:bg-gray-800 p-6 rounded-xl  dark:border-gray-700">
            <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-200">Course Content</h2>
            <div x-data="{ activeAccordion: '' }"
                class="relative w-full mx-auto overflow-hidden border border-gray-200 dark:border-gray-700 divide-y divide-gray-200 dark:divide-gray-700 rounded-xl bg-white dark:bg-gray-800">
                @foreach ($course->materials as $index => $chapter)
                    <div x-data="{ id: 'accordion-{{ $index }}' }" class="cursor-pointer group">
                        <button @click="activeAccordion = (activeAccordion == id) ? '' : id"
                            class="flex items-center justify-between w-full p-4 text-left select-none">
                            <span class="font-semibold text-gray-900 dark:text-white">
                                {{ $chapter->material_name }}
                            </span>
                            <svg class="w-4 h-4 text-gray-600 dark:text-gray-300 duration-200"
                                :class="{ 'rotate-180': activeAccordion == id }" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                        <div x-show="activeAccordion == id" x-collapse x-cloak>
                            <div class="p-4 pt-0 text-gray-700 dark:text-gray-300 opacity-80">
                                <p>{{ $chapter->description }}</p>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>

        <!-- Instructor Card -->
        <div class="col-span-1 bg-white dark:bg-gray-800 p-6 rounded-xl border dark:border-gray-700">
            <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-200">Instructor</h2>
            <div class="flex items-center">
                <div
                    class="w-14 h-14 flex items-center justify-center rounded-full bg-gray-700 text-white font-bold text-lg">
                    {{ $course->trainer->initials() }}
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                        {{ $course->trainer->name }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">{{ $course->trainer->email }}</p>
                </div>
            </div>
            <p class="text-gray-600 dark:text-gray-400 mt-4">{{ $course->trainer->bio }}</p>
            <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-200 mt-4">Enrolled Staff <span
                    class="text-orange-500 text-xs">({{ $course->enrolledUsers->count() }})
                </span></h2>
            <div class="flex items-center divide-y divide-gray-200 dark:divide-gray-700">


            </div>
        </div>

    </div>
