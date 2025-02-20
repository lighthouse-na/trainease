<?php

namespace App\Livewire\Quiz;

use App\Models\QuizModule\Quiz;
use App\Models\QuizModule\UserAnswer;
use App\Models\QuizModule\QuizResponses;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class QuizComponent extends Component
{
    public $quiz;
    public $questions;
    public $currentQuestionIndex = 0;
    public $selectedOption = null;
    public $showResults = false;
    public $score = 0;
    public $quizCompleted = false;
    public $totalQuestions;
    public $quizResponse;

    public function mount(Quiz $quiz)
    {
        $this->quiz = $quiz;
        $this->questions = $quiz->questions()->with('options')->get();
        $this->totalQuestions = $this->questions->count();

        // Create or retrieve the quiz response
        $this->quizResponse = QuizResponses::firstOrCreate(
            ['user_id' => Auth::id(), 'quiz_id' => $quiz->id],
            ['score' => 0, 'status' => 'in_progress']
        );
    }

    public function submitAnswer()
    {
        if (!isset($this->questions[$this->currentQuestionIndex])) {
            return;
        }

        $currentQuestion = $this->questions[$this->currentQuestionIndex];
        $correctOptions = $currentQuestion->options()->where('is_correct', true)->pluck('id')->toArray();

        // Check if the selected option is correct
        $isCorrect = in_array($this->selectedOption, $correctOptions);

        // Store the user's answer
        UserAnswer::updateOrCreate(
            ['quiz_response_id' => $this->quizResponse->id, 'question_id' => $currentQuestion->id],
            ['option_id' => $this->selectedOption, 'is_correct' => $isCorrect]
        );

        // Update score if the answer is correct
        if ($isCorrect) {
            $this->score++;
        }


        // Move to the next question
        $this->nextQuestion();
    }
    public function nextQuestion()
    {
        // Reset selected option for the next question
        $this->selectedOption = null;

        if ($this->currentQuestionIndex < $this->totalQuestions - 1) {
            $this->currentQuestionIndex++;
        } else {
            $this->calculateScore();
            $this->showResults = true;
            $this->quizCompleted = $this->score >= 50;
            $this->quizResponse->update(['status' => $this->quizCompleted ? 'passed' : 'failed', 'score' => $this->score]);
        }
    }

    public function calculateScore()
    {
        // Count the number of correct answers
        $correctAnswers = UserAnswer::where('quiz_response_id', $this->quizResponse->id)
            ->where('is_correct', true)
            ->count();

        // Calculate percentage score
        $this->score = round(($correctAnswers / max(1, $this->totalQuestions)) * 100, 2);
    }

    public function backToCourse()
    {
        return redirect()->route('start.course', ['course_id' => encrypt($this->quiz->training->id)]);
    }
    public function show(Quiz $quiz)
    {
        return view('training.quiz', compact('quiz'));
    }

    public function render()
    {
        return view('livewire.quiz.quiz-component', [
            'currentQuestion' => $this->questions[$this->currentQuestionIndex] ?? null,
            'quizResponse' => $this->quizResponse,
        ]);
    }
}
