<div class="overflow-y-auto">
    @php
        $progress = round((($this->currentQuestionIndex + 1) / max(1, $this->totalQuestions)) * 100);
    @endphp
    <header class="bg-white dark:bg-gray-800 border-b">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $quiz->title }}
            </h1>
            <h2 class="font-light text-xs text-gray-400 dark:text-gray-200 leading-tight">
                {{ $quiz->description }}
            </h2>
        </div>
        <div class="w-full bg-gray-200 h-2 dark:bg-gray-700 mt-4">
            <div class="bg-indigo-600 h-2 rounded-r-full transition-all duration-300"
                style="width: {{ $progress }}%;">
            </div>
        </div>
    </header>

    <div class="flex items-center justify-center my-6">
        @if ($showResults)
            <div class="text-center">
                <h2 class="text-4xl">Your Score: {{ $score }}%</h2>
                <p>{{ $quizCompleted ? 'You passed!' : 'You did not pass.' }}</p>
                <button wire:click="backToCourse"
                    class="mt-4 px-6 py-3 text-lg font-semibold rounded-xl shadow-sm transition-all {{ $quizCompleted ? 'bg-green-500 hover:bg-green-600' : 'bg-red-500 hover:bg-red-600' }} text-white">
                    {{ $quizCompleted ? 'Finish' : 'Retry Quiz' }}
                </button>
            </div>
        @else
            <div class="w-1/2 h-1/2 overflow-y-auto">
                @if ($currentQuestion)
                    <h2 class="font-black text-md text-indigo-500 my-3">
                        Question {{ $currentQuestionIndex + 1 }} of {{ $totalQuestions }}
                    </h2>
                    <p class="font-black text-2xl text-slate-800 mb-6">{{ $currentQuestion->question_text }}</p>
                @endif

                <!-- Display options -->
                @if ($currentQuestion->question_type == 'multiple_choice')
                    <p class="text-sm text-gray-600 mb-2">Select one option:</p>
                    @foreach ($currentQuestion->options as $option)
                        <div class="my-2">
                            <label
                                class="flex items-center gap-3 p-4 w-full border bg-white hover:bg-indigo-100 rounded-xl cursor-pointer transition-all active:bg-indigo-200">
                                <input type="radio" wire:model="selectedOption" value="{{ $option->id }}"
                                    class="w-5 h-5 text-indigo-600 bg-gray-100 border-gray-300 rounded-full focus:ring-indigo-500" />
                                <span class="text-lg text-gray-700">{{ $option->option_text }}</span>
                            </label>
                        </div>
                    @endforeach
                @endif

                <div class="my-6 w-full flex justify-center items-center">
                    <button wire:click="submitAnswer"
                        class="flex justify-center items-center bg-indigo-500 text-white px-4 py-2 rounded">
                        Submit
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
