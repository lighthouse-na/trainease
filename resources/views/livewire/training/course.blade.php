<div class="flex h-screen w-full bg-gray-100 dark:bg-gray-900">
    <!-- Sidebar -->
    <aside class="bg-white dark:bg-gray-800 w-96 p-6 border-r dark:border-gray-700 overflow-y-auto shadow-lg">
        <div class="mb-6">
            <!-- Training Title & Progress -->
            <div class="border rounded-lg p-4 bg-gray-50 dark:bg-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $training->title }}</h3>

                @php
                    $progress = min(100, round(Auth::user()->calculateProgress($training->id)));
                @endphp

                <div class="mt-4">
                    <div class="relative pt-1">
                        <div class="flex justify-between text-xs text-gray-700 dark:text-gray-300">
                            <span>Course Progress:</span>
                            <span>{{ $progress }}%</span>
                        </div>
                        <div class="h-2 bg-gray-200 dark:bg-gray-600 rounded-full">
                            <div class="h-full bg-teal-600 rounded-full transition-all duration-500 ease-in-out"
                                style="width: {{ $progress }}%">
                            </div>
                        </div>
                    </div>
                </div>
                @if ($progress = 100 && collect($quizzes)->every(fn($quiz) => $quiz->userHasCompleted(Auth::id())) && $enrollment->status !== 'completed')
                <div class="flex justify-between items-center mt-4">
                    <button wire:click="completeCourse"
                    class="bg-white border px-3 py-2 text-xs rounded-lg cursor-pointer hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200">
                    Complete Course
                </button>
                </div>

                @elseif ($enrollment->status === 'completed')
                    <div class="flex justify-between items-center mt-4">
                        <a href="{{ route('certificate', ['enrollment' => $enrollment]) }}"
                            class="bg-white border px-3 py-2 text-xs rounded-lg cursor-pointer hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200">
                            Download Certificate
                        </a>
                    </div>
                @endif
            </div>

            <!-- Course Materials -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Course Material</h3>
                @foreach ($courseMaterials as $material)
                    <div class="flex items-center text-sm border rounded-lg p-3 mt-2 cursor-pointer transition
                        {{ $content->id === $material->id ? 'bg-blue-100 border-blue-500 text-blue-800 font-bold dark:bg-blue-900 dark:border-blue-400 dark:text-blue-100' : 'bg-white border-gray-200 text-gray-700 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200' }}
                        {{ in_array($material->id, $completedMaterials) ? 'bg-green-50 border-green-200 text-green-700 dark:bg-green-900 dark:border-green-700 dark:text-green-200' : '' }}"
                        wire:click="setActiveContent({{ $material->id }})">

                        <span class="flex justify-center items-center h-6 w-6 mr-3">
                            @if (in_array($material->id, $completedMaterials))
                                <x-fas-circle-check class="h-3 w-3 text-green-500" />
                            @elseif ($content->id === $material->id)
                                <x-fas-circle-notch class="h-3 w-3" />
                            @else
                                <x-fas-chart-bar class="h-3 w-3" />
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
                @forelse ($quizzes as $quiz)
                    @php
                        $attemptsUsed = $quizResponses[$quiz->id] ?? 0;
                        $remainingAttempts = $quiz->max_attempts - $attemptsUsed;
                        $isDisabled = $remainingAttempts <= 0;
                    @endphp
                    <div x-data="{
                        tooltipVisible: false,
                        tooltipText: 'Attempts left: {{ $remainingAttempts }}', // Dynamically set attempts left
                        tooltipArrow: true,
                        tooltipPosition: 'top',
                    }" x-init="$refs.content.addEventListener('mouseenter', () => { tooltipVisible = true; });
                    $refs.content.addEventListener('mouseleave', () => { tooltipVisible = false; });" class="relative">

                        <div x-ref="tooltip" x-show="tooltipVisible"
                            :class="{
                                'top-0 left-1/2 -translate-x-1/2 -mt-0.5 -translate-y-full': tooltipPosition ==
                                    'top',
                                'top-1/2 -translate-y-1/2 -ml-0.5 left-0 -translate-x-full': tooltipPosition ==
                                    'left',
                                'bottom-0 left-1/2 -translate-x-1/2 -mb-0.5 translate-y-full': tooltipPosition ==
                                    'bottom',
                                'top-1/2 -translate-y-1/2 -mr-0.5 right-0 translate-x-full': tooltipPosition ==
                                    'right'
                            }"
                            class="absolute w-auto text-sm" x-cloak>
                            <div x-show="tooltipVisible" x-transition
                                class="relative px-2 py-1 text-white bg-black rounded bg-opacity-90">
                                <p x-text="tooltipText" class="flex-shrink-0 block text-xs whitespace-nowrap"></p>
                                <div x-ref="tooltipArrow" x-show="tooltipArrow"
                                    :class="{
                                        'bottom-0 -translate-x-1/2 left-1/2 w-2.5 translate-y-full': tooltipPosition ==
                                            'top',
                                        'right-0 -translate-y-1/2 top-1/2 h-2.5 -mt-px translate-x-full': tooltipPosition ==
                                            'left',
                                        'top-0 -translate-x-1/2 left-1/2 w-2.5 -translate-y-full': tooltipPosition ==
                                            'bottom',
                                        'left-0 -translate-y-1/2 top-1/2 h-2.5 -mt-px -translate-x-full': tooltipPosition ==
                                            'right'
                                    }"
                                    class="absolute inline-flex items-center justify-center overflow-hidden">
                                    <div :class="{
                                        'origin-top-left -rotate-45': tooltipPosition ==
                                            'top',
                                        'origin-top-left rotate-45': tooltipPosition ==
                                            'left',
                                        'origin-bottom-left rotate-45': tooltipPosition ==
                                            'bottom',
                                        'origin-top-right -rotate-45': tooltipPosition == 'right'
                                    }"
                                        class="w-1.5 h-1.5 transform bg-black bg-opacity-90"></div>
                                </div>
                            </div>
                        </div>

                        <div x-ref="content" class="">


                            <a href="{{ $isDisabled ? '#' : route('quiz.show', ['quiz' => $quiz]) }}"
                                class="{{ $baseClasses }} {{ $themeClasses }} {{ !$isDisabled ? $hoverClasses : 'opacity-50 cursor-not-allowed' }}"
                                aria-label="View {{ $quiz->title }} Quiz Results">

                                <span class="flex justify-center items-center h-6 w-6 mr-3">
                                    <x-fas-square-poll-horizontal />
                                </span>
                                {{ $quiz->title }}

                                <div class="flex items-center ml-auto">
                                    <p class="flex justify-end bg-white text-xs p-1 rounded-lg">
                                        @if ($quiz->userHasCompleted(Auth::id()))
                                            <!-- Assuming you have a method to check if the user has completed the quiz -->
                                            {{ $quiz->userScore(Auth::id()) }}%
                                            <!-- Assuming you have a method to fetch the user's score -->
                                        @endif
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                @empty
                    <p
                        class="bg-red-100 border border-red-500 text-red-700 rounded-lg p-3 mt-2 dark:bg-red-900 dark:border-red-700 dark:text-red-200">
                        No quizzes available for this course.
                    </p>
                @endforelse
            </div>
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

            <div class="mt-6">
                <article class="prose lg:prose-lg dark:prose-invert ">
                    <x-markdown>
                        {!! $content->material_content !!}
                    </x-markdown>
                </article>
            </div>

            <div class="flex justify-end my-12">
                <button wire:click="loadPreviousMaterial"
                    class="m-4 bg-gray-500 text-white px-4 py-2 rounded-lg disabled:opacity-50 transition hover:bg-gray-600"
                    {{ $content->id === $courseMaterials->first()->id ? 'disabled' : '' }}>
                    <x-fas-angle-left class="h-3 w-3" />
                </button>

                <button wire:click="loadNextMaterial"
                    class="m-4 bg-gray-500 text-white px-4 py-2 rounded-lg disabled:opacity-50 transition hover:bg-gray-600"
                    {{ $content->id === $courseMaterials->last()->id ? 'disabled' : '' }}>
                    <x-fas-angle-right class="h-3 w-3" />
                </button>


            </div>
        @else
            <p class="text-gray-700 dark:text-gray-300">No content selected.</p>
        @endif
    </div>

</div>
