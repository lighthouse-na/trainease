<?php

namespace App\Http\Controllers;

use App\Models\QuizModule\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    //
    public function index()
    {
        return Quiz::with('questions.options')->get();
    }

    public function store(Request $request)
    {
        $quiz = Quiz::create($request->all());
        return response()->json($quiz, 201);
    }
}
