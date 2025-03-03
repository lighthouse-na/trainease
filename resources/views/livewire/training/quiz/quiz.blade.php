<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Training\Quiz\Quiz;
use App\Models\Training\Quiz\UserAnswer;
use App\Models\Training\Quiz\QuizResponse;
use Illuminate\Support\Facades\Auth;
new #[Layout('components.layouts.course')] class extends Component {
    //
    public $quiz;
    public $questions;
    public $currentQuestionIndex = 0;
    public $selectedOption = null;
    public $showResults = false;
    public $score = 0;
    public $quizCompleted = false;
    public $totalQuestions;
    public $quizResponse;
    public $currentQuestion;

    public function mount($quiz)
    {
        $this->quiz = Quiz::findOrFail($quiz);
        $this->questions = $this->quiz->questions()->with('options')->get();
        $this->totalQuestions = $this->questions->count();
        $this->currentQuestion = $this->questions->first();

        // Create or retrieve quiz response in one query
        $this->quizResponse = QuizResponse::firstOrCreate(
            ['user_id' => Auth::id(), 'quiz_id' => $quiz],
            ['score' => 0, 'status' => 'in_progress']
        );
    }

    public function submitAnswer()
    {
        if ($this->selectedOption === null) {
            $this->addError('selectedOption', 'Please select an answer before proceeding.');
            return;
        }

        $currentQuestion = $this->questions[$this->currentQuestionIndex];
        $isCorrect = $currentQuestion->options->where('id', $this->selectedOption)->first()->is_correct ?? false;

        // Store answer efficiently
        UserAnswer::updateOrCreate(
            ['quiz_response_id' => $this->quizResponse->id, 'question_id' => $currentQuestion->id],
            ['option_id' => $this->selectedOption, 'is_correct' => $isCorrect]
        );

        $this->nextQuestion();
    }

    public function nextQuestion()
    {
        $this->selectedOption = null;

        if ($this->currentQuestionIndex < $this->totalQuestions - 1) {
            $this->currentQuestionIndex++;
            $this->currentQuestion = $this->questions[$this->currentQuestionIndex];
        } else {
            $this->finishQuiz();
        }
    }

    protected function finishQuiz()
    {
        $this->calculateScore();
        $this->showResults = true;
        $this->quizCompleted = $this->score >= $this->quiz->passing_score;

        // Update quiz response status and attempts in one query
        $this->quizResponse->update([
            'status' => $this->quizCompleted ? 'passed' : 'failed',
            'score' => $this->score,
            'attempts' => $this->quizResponse->attempts + 1
        ]);
    }

    public function calculateScore()
    {
        $correctAnswers = UserAnswer::where('quiz_response_id', $this->quizResponse->id)
            ->where('is_correct', true)
            ->count();

        $this->score = round(($correctAnswers / $this->totalQuestions) * 100);
    }

    public function backToCourse()
    {
        return redirect()->back();
    }
}; ?>

<div>
    <div class="overflow-y-auto">
        @php
            $progress = round((($this->currentQuestionIndex + 1) / max(1, $this->totalQuestions)) * 100);
        @endphp
        <header class="bg-white dark:bg-gray-800 ">

            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $quiz->title }}
                </h1>
                <h2 class="font-light text-xs text-gray-400 dark:text-gray-300 leading-tight">
                    {{ $quiz->description }}
                </h2>
            </div>
            <div class="w-full bg-gray-200 dark:bg-gray-700 h-2 mt-4 rounded-full">
                <div class="bg-accent-content h-2 rounded-full transition-all duration-300"
                    style="width: {{ $progress }}%;">
                </div>
            </div>
        </header>

        <div class="flex items-center justify-center my-6">
            @if ($showResults)
                <div class="text-center">
                    <h2 class="text-4xl text-gray-800 dark:text-gray-200">Your Score: {{ $score }}%</h2>
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ $quizCompleted ? 'You passed!' : 'You did not pass.' }}</p>
                    <button wire:click="backToCourse"
                        class="mt-4 px-6 py-3 text-lg font-semibold rounded-xl shadow-sm transition-all {{ $quizCompleted ? 'bg-green-500 hover:bg-green-600' : 'bg-red-500 hover:bg-red-600' }} text-white">
                        {{ $quizCompleted ? 'Finish' : 'Retry Quiz' }}
                    </button>
                </div>
            @else
                <div class="w-1/2 h-1/2 overflow-y-auto" x-data="{ questionKey: 0 }"
                    x-effect="questionKey = {{ $currentQuestionIndex }}; $el.classList.remove('animate-fadeIn'); void $el.offsetWidth; $el.classList.add('animate-fadeIn');">
                    @if ($this->currentQuestion)
                        <h2 class="font-black text-md text-accent my-3">
                            Question {{ $currentQuestionIndex + 1 }} of {{ $totalQuestions }}
                        </h2>
                        <p class="font-black text-2xl text-slate-800 dark:text-gray-200 mb-6">
                            {{ $this->currentQuestion->question_text }}</p>
                    @endif

                    <!-- Display options -->
                    @if ($currentQuestion->question_type == 'multiple_choice')
                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">Select one option:</p>
                        @foreach ($currentQuestion->options as $option)
                            <div class="my-2">
                                <label
                                    class="flex items-center gap-3 p-4 w-full border bg-white dark:bg-gray-800 hover:bg-accent dark:hover:bg-accent hover:text-accent-foreground rounded-xl cursor-pointer transition-all active:text-accent">
                                    <input type="radio" wire:model="selectedOption" value="{{ $option->id }}"
                                        class="w-5 h-5 text-accent bg-gray-100 border-gray-300 rounded-full focus:ring-accent active:bg-accent" />
                                    <span
                                        class="text-lg ">{{ $option->option_text }}</span>
                                </label>
                            </div>
                        @endforeach
                    @endif

                    <div class="my-6 w-full flex justify-center items-center">

                        <button wire:click="submitAnswer"
                            class="flex justify-center items-center bg-accent  text-white px-4 py-2 rounded cursor-pointer hover:bg-accent-content transition-all">
                            Submit
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

</div>
