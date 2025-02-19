<div class="overflow-y-auto">
    @php
        $progress = round((($this->currentQuestionIndex + 1) / max(1, $this->totalQuestions)) * 100);
    @endphp
    <header class="bg-white dark:bg-gray-800 border-b">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            {{ $quiz->title }}

            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            </h2>
            <h2 class="font-light text-xs text-gray-400 dark:text-gray-200 leading-tight">
                {{ $quiz->description }}

            </h2>
        </div>
        <div class="w-full bg-gray-200  h-2 dark:bg-gray-700 mt-4">
            <div class="bg-indigo-600 h-2  rounded-r-full transition-all duration-300"
                style="width: {{ $progress }}%;">
            </div>
        </div>
    </header>

    <div class="mx-auto flex items-center justify-center overflow-y-auto">
        @if ($showResults)
            <div
                class="text-center bg-white p-6 rounded-xl shadow-md border border-gray-200
                dark:bg-gray-800 dark:border-gray-700">

                <h2
                    class="text-4xl font-bold
                   {{ $quizCompleted ? 'text-green-600' : 'text-red-500' }}">
                    Your Score: {{ $score }}%
                </h2>

                <p
                    class="text-lg mt-2 font-medium
                  {{ $quizCompleted ? 'text-green-700' : 'text-red-600' }}">
                    {{ $quizCompleted ? '🎉 Congratulations! You passed!' : '❌ You did not pass. Try again!' }}
                </p>

                <a href="{{route('start.course', ['course_id' => Crypt::encrypt($quiz->training->id)])}}"
                    class="mt-4 px-6 py-3 text-lg font-semibold rounded-xl shadow-sm transition-all
                   {{ $quizCompleted ? 'bg-green-500 hover:bg-green-600' : 'bg-red-500 hover:bg-red-600' }}
                   text-white">
                    {{ $quizCompleted ? 'Finish' : 'Retry Quiz' }}
                </a>
            </div>
        @else
            <div class="w-1/2 h-1/2">
                @if ($currentQuestion)
                    <h2 class="font-black text-md text-indigo-500 my-3">
                        Question {{ $currentQuestionIndex + 1 }} of {{ $totalQuestions }}
                    </h2>
                    <p class="font-black text-2xl text-slate-800 mb-6">{{ $currentQuestion->question_text }}</p>
                @endif

                <!-- Display options -->
                @if ($currentQuestion->question_type == 'multiple_response')
                    <p class="text-sm text-gray-500">Select Multiple Options:</p>

                    @foreach ($currentQuestion->options as $option)
                        <div class="my-2  hover:bg-gray-50 p-3 rounded-xl">
                            <label class="mx-3 text-lg p-4 rounded-xl w-full hover:bg-gray-100 active:bg-indigo-300">
                                <input type="checkbox" wire:model="selectedOptions" value="{{ $option->id }}"
                                    class="rounded-xl p-3 mr-6 w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
                                {{ $option->option_text }}
                            </label>
                        </div>
                    @endforeach
                @elseif ($currentQuestion->question_type == 'multiple_choice')
                    <p class="text-sm text-gray-600 mb-2">Select one option:</p>

                    @foreach ($currentQuestion->options as $option)
                        <div class="my-2">
                            <label
                                class="flex items-center gap-3 p-4 w-full border rounded-xl cursor-pointer transition-all
                                bg-white border-gray-300 shadow-sm hover:bg-indigo-50 active:bg-indigo-100
                                dark:bg-gray-800 dark:border-gray-600 dark:hover:bg-indigo-900">

                                <input type="radio" wire:model="selectedOption" value="{{ $option->id }}"
                                    class="w-5 h-5 text-indigo-600 bg-gray-100 border-gray-300 rounded-full focus:ring-indigo-500
                                    dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />

                                <span
                                    class="text-lg text-gray-700 dark:text-gray-200">{{ $option->option_text }}</span>
                            </label>
                        </div>
                    @endforeach
                @elseif ($currentQuestion->question_type == 'short_answer')
                    <p class="text-sm text-gray-500">Answer in short:</p>

                    <input type="text" wire:model="shortAnswer" class="w-full p-3 rounded-xl border-gray-300"
                        placeholder="Type your answer here" />
                @elseif ($currentQuestion->question_type == 'sequence')
                    <div class="flex flex-col">
                        <p class="text-sm text-gray-500">Arrange the following in the correct order:</p>
                        @foreach ($currentQuestion->options as $option)
                            <div class="my-2  hover:bg-gray-50 p-3 rounded-xl">
                                <label
                                    class="mx-3 text-lg p-4 rounded-xl w-full hover:bg-gray-100 active:bg-indigo-300">
                                    <input type="text" wire:model="sequence.{{ $option->id }}"
                                        class="rounded-xl p-3 mr-6 w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
                                    {{ $option->option_text }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                @elseif ($currentQuestion->question_type == 'matching')
                    <div class="flex flex-col">
                        <p class="text-sm text-gray-500">Match the following:</p>
                        @foreach ($currentQuestion->options as $option)
                            <div class="my-2  hover:bg-gray-50 p-3 rounded-xl">
                                <label
                                    class="mx-3 text-lg p-4 rounded-xl w-full hover:bg-gray-100 active:bg-indigo-300">
                                    <input type="text" wire:model="matching.{{ $option->id }}"
                                        class="rounded-xl p-3 mr-6 w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
                                    {{ $option->option_text }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                @endif


                <div class="my-6 w-full flex justify-center items-center">
                    <button wire:click="nextQuestion"
                        class="flex justify-center items-center bg-indigo-500 text-white px-4 py-2 rounded">Submit</button>
                </div>

            </div>
        @endif
    </div>
</div>
