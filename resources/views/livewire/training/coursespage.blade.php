<?php

use Livewire\Volt\Component;
use App\Models\Training\Course;
use App\Models\Training\Enrollment;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public $courses;
    public array $userEnrollments = [];

    public function mount()
    {
        $this->courses = Course::all();
        $this->userEnrollments = Enrollment::where('user_id', Auth::id())->pluck('course_id')->toArray();
    }


}; ?>

    <div class=" p-6">
        <h1 class="font-bold text-2xl text-gray-900 dark:text-gray-100">Training Courses</h1>

        <div class="mb-9">
            @if (session()->has('success'))
                <div
                    class="text-green-700 dark:text-green-300 bg-green-100 dark:bg-green-900 p-3 rounded-lg mb-4 border border-green-500">
                    {{ session('success') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div
                    class="text-red-700 dark:text-red-300 bg-red-100 dark:bg-red-900 p-3 rounded-lg mb-4 border border-red-500">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 my-3">
                @foreach ($courses as $course)
                    <a href="{{route('training.coursepage', ['course' => $course->id])}}" class="block group">
                        <div
                            class="bg-white dark:bg-gray-800 border border-neutral-200 dark:border-neutral-700  rounded-xl overflow-hidden transition duration-300 ease-in-out cursor-pointer">

                            {{-- Image with Hover Effect --}}
                            <div class="overflow-hidden">
                                <img src="{{ asset($course->course_image) }}"
                                    class="w-full h-36 object-cover rounded-t-xl group-hover:scale-102 transition-transform duration-300 ease-in-out"
                                    alt="{{ $course->course_name }}">
                            </div>

                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $course->course_name }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 line-clamp-2">
                                    {{ $course->course_description }}
                                </p>
                                <div class="flex justify-between items-center mt-4 space-x-4">
                                    <div class="flex items-center">
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Trainer:</span>
                                        <span class="ml-1 text-sm font-medium text-gray-800 dark:text-gray-200">
                                            {{ $course->trainer->name }}
                                        </span>
                                    </div>
                                    <span
                                        class="px-3 py-1 text-xs font-medium bg-accent text-accent-foreground dark:bg-accent dark:text-accent-content rounded-full">
                                        {{ $course->course_fee }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
