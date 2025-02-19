<?php

namespace App\Http\Controllers;

use App\Models\QuizModule\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    //
    public function store(Request $request)
    {
        $question = Question::create($request->all());

        if ($request->has('options')) {
            foreach ($request->options as $option) {
                $question->options()->create($option);
            }
        }
        return response()->json($question, 201);
    }
}
