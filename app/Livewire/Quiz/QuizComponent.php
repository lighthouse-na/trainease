<?php

namespace App\Livewire\Quiz;

use App\Models\QuizModule\Quiz;
use App\Models\QuizModule\UserAnswer;
use App\Models\QuizModule\UserSelectedOption;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
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

    public function mount(Quiz $quiz)
    {
        $this->quiz = $quiz;
        // Load only multiple-choice questions
        $this->questions = $quiz->questions()->where('question_type', 'multiple_choice')->with('options')->get();
        $this->totalQuestions = $this->questions->count();
    }

    public function nextQuestion()
    {
        if (!isset($this->questions[$this->currentQuestionIndex])) {
            return;
        }

        $currentQuestion = $this->questions[$this->currentQuestionIndex];

        // Save user's answer
        $userAnswer = UserAnswer::create([
            'user_id' => Auth::id(),
            'question_id' => $currentQuestion->id,
        ]);

        // Save selected option
        if ($this->selectedOption) {
            UserSelectedOption::create([
                'user_answer_id' => $userAnswer->id,
                'option_id' => $this->selectedOption,
            ]);
        }

        // Reset selected option for the next question
        $this->selectedOption = null;

        // Move to the next question or finish quiz
        if ($this->currentQuestionIndex < $this->totalQuestions - 1) {
            $this->currentQuestionIndex++;
        } else {
            $this->calculateScore();
            $this->showResults = true;
            $this->quizCompleted = $this->score >= 50; // Adjust passing threshold
        }
    }

    public function calculateScore()
    {
        $correctAnswers = 0;

        foreach ($this->questions as $question) {
            $userAnswer = UserAnswer::where('user_id', Auth::id())
                ->where('question_id', $question->id)
                ->first();

            if ($userAnswer) {
                $correctOption = $question->options()->where('is_correct', true)->first();
                $userSelectedOption = $userAnswer->selectedOptions()->first();

                if ($userSelectedOption && $userSelectedOption->option_id == $correctOption->id) {
                    $correctAnswers++;
                }
            }
        }

        $this->score = round(($correctAnswers / $this->totalQuestions) * 100, 2);
    }
    public function backToCourse(){

        return redirect()->route('training.show', ['course_id' => Crypt::encrypt($this->quiz->training->id)]);
        }
    public function show(Quiz $quiz){
        return view('training.quiz', compact('quiz'));
    }
    public function render()
    {
        return view('livewire.quiz.quiz-component', [
            'currentQuestion' => $this->questions[$this->currentQuestionIndex] ?? null
        ]);
    }

}
