<?php

namespace App\Models\Training\Quiz;

use App\Models\Training\Course;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    //
    protected $fillable = ['course_id', 'title', 'description'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Relationship: A quiz has many questions
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    // Relationship: A quiz has many responses (user attempts)
    public function quizResponses()
    {
        return $this->hasMany(QuizResponse::class);
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

    public function userHasPassed($userId)
    {
        $quizResponse = $this->quizResponses()->where('user_id', $userId)->orderBy('score', 'desc')->first();

        return $quizResponse ? $quizResponse->score >= $this->passing_score : false;
    }

    public function passRate()
    {
        $total = $this->quizResponses()->count();
        $passed = $this->quizResponses()->where('score', '>=', $this->passing_score)->count();

        return $total > 0 ? ($passed / $total) * 100 : 0;
    }
}
