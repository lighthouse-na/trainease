<?php

namespace App\Http\Controllers;

use App\Models\QuizModule\UserAnswer;
use Illuminate\Http\Request;

class UserAnswerController extends Controller
{
    //
    public function store(Request $request)
    {
        $userAnswer = UserAnswer::create([
            'user_id' => auth()->id(),
            'question_id' => $request->question_id,
            'answer_text' => $request->answer_text
        ]);

        if ($request->has('selected_options')) {
            foreach ($request->selected_options as $optionId) {
                $userAnswer->selectedOptions()->create(['option_id' => $optionId]);
            }
        }

        return response()->json($userAnswer, 201);
    }
}
