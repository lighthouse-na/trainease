<?php

use Livewire\Volt\Component;
use App\Models\Training\Course;
new class extends Component {
    // // Quiz properties
    public $quizzes = [];
    public string $quizTitle = '';
    public $questions = [];
    public int $quizAttempts;
    public int $passingScore;
    public bool $courseCreated = false;


    public function mount($course){
        $course = Course::find($course);
        if ($course) {
            $this->quizzes = $course
                ->quizes()
                ->with(['questions.options'])
                ->get() ?? collect([]);


                // If there are quizzes, set up the first one
                if ($this->quizzes->isNotEmpty()) {
                    $this->quiz = $this->quizzes->first();
                    $this->quizTitle = $this->quiz->title;
                    $this->quizAttempts = $this->quiz->max_attempts;
                    $this->passingScore = $this->quiz->passing_score;

                    // Setup questions array for the form
                    $this->questions = $this->quiz->questions
                        ->map(function ($question) {
                            $questionData = [
                                'id' => $question->id,
                                'text' => $question->question_text,
                                'question_type' => $question->question_type,
                                'options' => [],
                            ];

                            // Setup options for each question
                            foreach ($question->options as $index => $option) {
                                $questionData['options'][$index] = $option->option_text;
                                if ($option->is_correct) {
                                    $questionData['correct_answer'] = $index;
                                }
                            }

                            return $questionData;
                        })
                        ->toArray();
                }
        }
    }
    public function addQuestion()
    {
        if (!$this->courseCreated) {
            return;
        }

        $this->questions[] = [
            'text' => '',
            'question_type' => 'multiple_choice',
            'options' => ['', '', '', ''],
            'correct_answer' => null,
        ];
    }

    public function removeQuestion($index)
    {
        if (isset($this->questions[$index])) {
            // Check if this question exists in database (has an ID)
            if (isset($this->questions[$index]['id'])) {
                $questionId = $this->questions[$index]['id'];

                // Find and delete the question from database
                $question = Question::find($questionId);
                if ($question) {
                    // Delete all associated options first
                    $question->options()->delete();
                    // Delete the question itself
                    $question->delete();
                }
            }

            // Remove from local array
            array_splice($this->questions, $index, 1);
        }
    }

    public function saveQuiz()
    {
        if (!$this->courseCreated) {
            return;
        }

        $this->validate(
            [
                'quizTitle' => 'required | min:3',
                'quizAttempts' => 'required | numeric | min:1',
                'questions' => 'required | array|min:1',
                'questions .*.text' => 'required',
                'questions .*.correct_answer' => 'required',
            ],
            [
                'questions .*.text . required' => 'Question text is required',
                'questions .*.correct_answer . required' => 'You must select a correct answer',
            ],
        );

        $course = Course::find($this->courseId);

        // Check if we already have quizzes for this course
        if ($this->quizzes && $this->quizzes->isNotEmpty()) {
            // Update the existing quiz
            $quiz = $this->quizzes->first();
            $quiz->title = $this->quizTitle;
            $quiz->max_attempts = $this->quizAttempts;
            $quiz->passing_score = $this->passingScore;
            $quiz->save();
        } else {
            // Create a new quiz
            $quiz = $course->quizes()->create([
                'title' => $this->quizTitle,
                'quizAttempts' => $this->quizAttempts,
                'passingScore' => $this->passingScore,
            ]);
        }

        // Process each question
        foreach ($this->questions as $index => $questionData) {
            // Check if we're updating an existing question or creating a new one
            $questionId = $questionData['id'] ?? null;

            // Create or update the question
            $question = $quiz->questions()->updateOrCreate(
                ['id' => $questionId],
                [
                    'question_text' => $questionData['text'],
                    'question_type' => $questionData['question_type'] ?? 'multiple_choice',
                    'order' => $index + 1,
                ],
            );

            // Delete existing options for this question if it's being updated
            if ($questionId) {
                $question->options()->delete();
            }

            // Add options
            foreach ($questionData['options'] as $optionIndex => $optionText) {
                if (!empty($optionText)) {
                    $question->options()->create([
                        'option_text' => $optionText,
                        'is_correct' => $questionData['correct_answer'] == $optionIndex,
                        'order' => $optionIndex + 1,
                    ]);
                }
            }
        }

        // Refresh the data
        $this->quizzes = $course
            ->quizes()
            ->with(['questions.options'])
            ->get();

        // Update the quiz property to the current quiz
        if ($this->quizzes->isNotEmpty()) {
            $this->quiz = $this->quizzes->first();
        }

        session()->flash('message', 'Quiz saved successfully!');
    }
}; ?>

<div>
    <h3 class="text-lg font-semibold mb-4 dark:text-white">Course Quiz</h3>
    <form wire:submit.prevent="saveQuiz">
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                for="quizTitle">Quiz
                Title</label>
            <x-input id="quizTitle" wire:model="quizTitle"
                class="w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                    for="quizAttempts">Maximum
                    Attempts</label>
                <x-input id="quizAttempts" wire:model="quizAttempts" type="number" min="1"
                    class="w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                    for="passingScore">Passing Score
                    (%)</label>
                <x-input id="passingScore" wire:model="passingScore" type="number" min="0"
                    max="100" class="w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
            </div>
        </div>

        <div class="mb-4">
            <label
                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Questions</label>

            @foreach ($questions as $index => $question)
                <div class="p-4 border rounded-md mb-3 bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                    <div class="mb-3">
                        <label
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Question
                            {{ $index + 1 }}</label>
                        <x-input wire:model="questions.{{ $index }}.text"
                            class="w-full dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                            placeholder="Enter question" />
                    </div>

                    <div class="mb-2">
                        <label
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Options</label>
                        @foreach (['A', 'B', 'C', 'D'] as $optionIndex => $optionLabel)
                            <div class="flex items-center mb-2">
                                <div class="mr-2 dark:text-white">{{ $optionLabel }}.</div>
                                <input
                                    wire:model="questions.{{ $index }}.options.{{ $optionIndex }}"
                                    class="w-full dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                                    placeholder="Option {{ $optionLabel }}" />
                                <label class="inline-flex items-center ml-2">
                                    <input type="radio"
                                        wire:model="questions.{{ $index }}.correct_answer"
                                        value="{{ $optionIndex }}"
                                        class="form-radio h-4 w-4 text-accent-content dark:bg-gray-800 dark:border-gray-600">
                                    <span
                                        class="ml-1 text-sm text-gray-700 dark:text-gray-300">Correct</span>
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" wire:click="removeQuestion({{ $index }})"
                        class="text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                        Remove Question
                    </button>
                </div>
            @endforeach

            <button type="button" wire:click="addQuestion"
                class="inline-flex items-center text-sm text-accent-content hover:text-blue-800 dark:hover:text-blue-300 mt-2">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add Question
            </button>
        </div>

        <x-button type="submit" class="bg-accent-content hover:bg-accent-content">
            Save Quiz
        </x-button>
    </form>
</div>
