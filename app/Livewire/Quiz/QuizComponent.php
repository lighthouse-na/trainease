<?php

namespace App\Livewire\Quiz;

use App\Models\Quiz\Quiz;
use Livewire\Component;

class QuizComponent extends Component
{
    public $quiz;
    public $question;
    public $answers = [];

    public function mount(Quiz $quiz){
        $this->quiz = $quiz;
        $this->question = collect([
                [
                    'question' => 'What is the capital of France?',
                    'options' => [
                        'London',
                        'Paris',
                        'Berlin',
                        'Madrid'
                    ]
                ],
                [
                    'question' => 'Which programming language is Laravel built with?',
                    'options' => [
                        'Python',
                        'Java',
                        'PHP',
                        'Ruby'
                    ]
                ],
                [
                    'question' => 'What year was PHP created?',
                    'options' => [
                        '1994',
                        '1995',
                        '1991',
                        '1998'
                    ]
                ]
            ]);


    }
    public function show(Quiz $quiz){

        return view('training.quiz', compact('quiz'));
    }
    public function render()
    {
        return view('livewire.quiz.quiz-component');
    }
}
