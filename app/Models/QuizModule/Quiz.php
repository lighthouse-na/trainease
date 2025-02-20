<?php

namespace App\Models\QuizModule;

use App\Models\Training\Training;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    //
    use HasFactory;

    protected $fillable = ['training_id', 'title', 'description'];

    public function training()
    {
        return $this->belongsTo(Training::class);
    }

    // Relationship: A quiz has many questions
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    // Relationship: A quiz has many responses (user attempts)
    public function quizResponses()
    {
        return $this->hasMany(QuizResponses::class);
    }

    // Check if a user has completed this quiz
    public function userHasCompleted($userId)
    {
        return $this->quizResponses()->where('user_id', $userId)->exists();
    }

    // Get a user's score on this quiz
    public function userScore($userId)
    {
        $quizResponse = $this->quizResponses()->where('user_id', $userId)->first();

        return $quizResponse ? $quizResponse->score : 0;
    }
}
