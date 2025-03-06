<?php

use Livewire\Volt\Component;
use App\Models\Training\Course;
use App\Models\Training\CourseMaterial;
use App\Models\Training\CourseProgress;
use App\Models\Training\Enrollment;
use App\Models\Training\Quiz\Quiz;

new class extends Component {
    //

    public $course;
    public $courseMaterials;
    public $courseProgress;
    public $content;
    public $completedMaterials = [];
    public $enrollment;
    public $quizes;

    public function mount($course_id, $enrollment_id)
    {
        $this->course = Course::findOrFail(Hashids::decode($course_id)[0]);
        $this->courseMaterials = CourseMaterial::where('course_id', Hashids::decode($course_id)[0])->get();
        $this->courseProgress = 50;
        $this->content = $this->courseMaterials->first() ?? null; // Set to null if no materials exist
        $this->completedMaterials = $this->getCompletedMaterials(Auth::id());
        $this->enrollment = Enrollment::find(Hashids::decode($enrollment_id)[0]);
        $this->quizes = $this->course->quizes;
    }
    public function getCompletedMaterials($userId)
    {
        return $this->courseMaterials->filter(fn($material) => $material->isCompletedByUser($userId))->pluck('id')->toArray();
    }
    public function setActiveContent($materialId)
    {
        $this->content = CourseMaterial::find($materialId);

        // Mark the material as completed if not already
        if (!in_array($materialId, $this->completedMaterials)) {
            $this->markMaterialAsCompleted($materialId);
        }
        $this->dispatch('content-updated');
    }

    public function markMaterialAsCompleted($materialId)
    {
        $userId = Auth::id();

        // Check if already completed
        $exists = CourseProgress::where('user_id', $userId)->where('course_material_id', $materialId)->where('status', 'completed')->exists();

        if (!$exists) {
            CourseProgress::create([
                'user_id' => $userId,
                'course_id' => $this->course->id,
                'course_material_id' => $materialId,
                'status' => 'completed',
            ]);

            // Refresh the completed materials list in real time
            $this->completedMaterials[] = $materialId;
        }
    }

    public function loadNextMaterial()
    {
        $currentMaterialIndex = $this->courseMaterials->search(fn($material) => $material->id === $this->content->id);

        $nextMaterial = $this->courseMaterials->get($currentMaterialIndex + 1);

        if ($nextMaterial) {
            $this->setActiveContent($nextMaterial->id);
        }
    }

    public function loadPreviousMaterial()
    {
        $currentMaterialIndex = $this->courseMaterials->search(fn($material) => $material->id === $this->content->id);

        $previousMaterial = $this->courseMaterials->get($currentMaterialIndex - 1);

        if ($previousMaterial) {
            $this->setActiveContent($previousMaterial->id);
        }
    }

    public function completeCourse()
    {
        $enrollment = Enrollment::where('user_id', Auth::id())->where('course_id', $this->course->id)->first();

        if (!$enrollment) {
            abort(403, 'You are not enrolled in this course.');
        }

        // Mark course as completed
        $enrollment->update(['status' => 'completed']);

    }

    public function startQuiz($quizId)
    {
        return redirect()->route('training.quiz', ['quiz' => Hashids::encode($quizId)]);
    }
}; ?>

<div class="flex m-0 border h-screen w-full bg-slate-100 dark:bg-slate-900 rounded-l-xl">
    <!-- Sidebar -->
    <aside class=" bg-slate-100 rounded-l-xl dark:bg-slate-900  w-96 p-6 border-r dark:border-gray-700 overflow-y-auto">
        <div class="mb-6">
            <!-- Training Title & Progress -->
            <div class="border rounded-lg p-4 bg-gray-50 dark:bg-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $course->course_name }}</h3>

                @php
                    $progress = min(100, round(Auth::user()->calculateProgress($course->id)));
                @endphp

                <div class="mt-4">
                    <div class="relative pt-1">
                        <div class="flex justify-between text-xs text-gray-700 dark:text-gray-300">
                            <span>Course Progress:</span>
                            <span>{{ $progress }}%</span>
                        </div>
                        <div class="h-2 bg-gray-200 dark:bg-gray-600 rounded-full">
                            <div class="h-full bg-accent-content rounded-full transition-all duration-500 ease-in-out"
                                style="width: {{ $progress }}%">
                            </div>
                        </div>
                    </div>
                </div>
                @if ($progress == 100 && $quizes->count() > 0 && $quizes->every(function($quiz) { return Auth::user()->hasCompletedQuiz($quiz->id); }))
                    <div class="flex justify-between items-center mt-4">
                        <flux:button wire:click="completeCourse" icon-trailing="document-check" dark:variant="primary">
                            {{$enrollment->status === 'completed' ? 'Course Completed!' : 'Complete Course'}}
                        </flux:button>
                    </div>
                @elseif ($enrollment->status === 'completed')
                    <div class="flex justify-between items-center mt-4">
                        <flux:button wire:click="completeCourse" icon-trailing="document-chart-bar"
                            dark:variant="primary">
                            Download Certificate

                        </flux:button>
                    </div>
                @endif
            </div>

            <!-- Course Materials -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Course Material</h3>
                @foreach ($courseMaterials as $material)
                    <div class="flex items-center text-sm border rounded-lg p-3 mt-2 cursor-pointer transition
                                {{ $content->id === $material->id ? 'bg-cyan-100 border-cyan-500 text-cyan-800 font-bold dark:bg-cyan-900 dark:border-cyan-400 dark:text-cyan-100' : 'bg-white border-gray-200 text-gray-700 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200' }}
                                {{ in_array($material->id, $completedMaterials) ? 'bg-green-50 border-green-200 text-green-700 dark:bg-green-900 dark:border-green-700 dark:text-green-200' : '' }}"
                        wire:click="setActiveContent({{ $material->id }})">

                        <span class="flex justify-center items-center h-6 w-6 mr-3">
                            @if (in_array($material->id, $completedMaterials))
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    strokeWidth={1.5} stroke="currentColor" className="size-6">
                                    <path strokeLinecap="round" strokeLinejoin="round"
                                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            @elseif ($content->id === $material->id)
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.75 9h16.5m-16.5 6.75h16.5" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M7.5 3.75H6A2.25 2.25 0 0 0 3.75 6v1.5M16.5 3.75H18A2.25 2.25 0 0 1 20.25 6v1.5m0 9V18A2.25 2.25 0 0 1 18 20.25h-1.5m-9 0H6A2.25 2.25 0 0 1 3.75 18v-1.5M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            @endif
                        </span>

                        {{ $material->material_name }}
                    </div>
                @endforeach
            </div>
            @php
                $isCompleted = $progress === 100;
                $baseClasses = 'flex items-center text-sm border rounded-lg p-3 mt-2 transition';
                $themeClasses = $isCompleted
                    ? 'bg-white border-gray-200 text-gray-700 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200'
                    : 'bg-indigo-50 border-indigo-200 text-indigo-700 dark:bg-indigo-900 dark:border-indigo-700 dark:text-indigo-200';
                $hoverClasses =
                    'hover:shadow-md hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-indigo-400';

            @endphp

            <!-- Course Quizzes -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Course Quizzes</h3>
                @forelse ($quizes as $quiz)
                    @php
                        $attemptsUsed = Auth::user()->getQuizAttempts($quiz->id) ?? 0;
                        $remainingAttempts = $quiz->max_attempts - $attemptsUsed;
                        $progress = min(100, round(Auth::user()->calculateProgress($course->id)));
                        $isDisabled = $remainingAttempts <= 0 || $progress < 100;
                        $tooltipMessage =
                            $remainingAttempts <= 0
                                ? 'You have exhausted all attempts for this quiz.'
                                : ($progress < 100
                                    ? 'Complete the course to unlock this quiz.'
                                    : 'You have ' . $remainingAttempts . ' attempts remaining.');
                    @endphp
                    <flux:tooltip position="right" content="{{ $tooltipMessage }}">
                        <flux:button icon="document-text"
                            class="cursor-pointer mt-6 {{ $isDisabled ? 'cursor-not-allowed' : '' }}" variant="primary"
                            wire:click.prevent="startQuiz({{ $quiz->id }})" :disabled="$isDisabled">
                            {{ $quiz->title }}
                        </flux:button>
                    </flux:tooltip>

                @empty
                    <p class="text-gray-700 dark:text-gray-300">No quizzes available.</p>
                @endforelse

        </div>


    </aside>

    <!-- Main Content -->

    <div x-data="{ show: true }" x-init="show = true" x-show="show" x-transition.opacity.duration.700ms
        @content-updated.window="
                show = false;
                setTimeout(() => {
                    show = true;
                    document.getElementById('contentContainer').scrollTo({ top: 0, behavior: 'smooth' });
                }, 10);
             "
        class="p-12 overflow-y-auto w-full transition-opacity" id="contentContainer" wire:loading.class="opacity-0"
        wire:loading.class.remove="opacity-100" wire:target="loadNextMaterial,loadPreviousMaterial,setActiveContent">


        @if ($content)
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $content->material_name }}</h2>
            <p class="mt-4 text-gray-700 dark:text-gray-300">{{ $content->material_description }}</p>

            <div class="m-6 text-justify">
                <article class="prose lg:prose-lg dark:prose-invert ">
                    <x-markdown>
                        {!! $content->material_content !!}
                    </x-markdown>
                </article>
            </div>

            <div class="flex justify-end items-center my-12">
                <div class="flex items-center space-x-4">
                    <flux:button wire:click="loadPreviousMaterial" icon="arrow-left-circle">

                        Previous
                    </flux:button>
                    <flux:button wire:click="loadNextMaterial" icon-trailing="arrow-right-circle">
                        Next
                    </flux:button>
                </div>







            </div>
        @else
            <p class="text-gray-700 dark:text-gray-300">No content selected.</p>
        @endif
    </div>


</div>
