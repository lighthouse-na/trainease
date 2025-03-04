<?php

namespace App\Models\Training\Quiz;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class QuizResponse extends Model
{
    //
    protected $fillable = ['user_id', 'quiz_id', 'score', 'attempts', 'status'];

    protected $table = 'quiz_responses';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: A quiz response belongs to a quiz
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    // Relationship: A quiz response has many user answers
    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class);
    }

    // Calculate and update the user's quiz score
    public function calculateScore()
    {
        $totalQuestions = $this->quiz->questions()->count();
        $correctAnswers = $this->userAnswers()
            ->whereHas('selectedOption', function ($query) {
                $query->where('is_correct', true);
            })
            ->count();

        $this->score = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100, 2) : 0;
        $this->save();

        return $this->score;
    }
}
