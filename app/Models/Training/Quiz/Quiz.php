<?php

namespace App\Models\Training\Quiz;

use App\Models\Training\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    //
    protected $fillable = ['course_id', 'title', 'description','passing_score'];

    /**
     * @return BelongsTo<Course, $this>
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * return int
     */
    public function passingScore(): int
    {
        return $this->passing_score;
    }
    // Relationship: A quiz has many questions
    /**
     * @return HasMany<Question, $this>
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    // Relationship: A quiz has many responses (user attempts)
    /**
     * @return HasMany<QuizResponse, $this>
     */
    public function quizResponses(): HasMany
    {
        return $this->hasMany(QuizResponse::class);
    }

    // Check if a user has completed this quiz
    /**
     * @param int $userId
     * @return bool
     */
    public function userHasCompleted(int $userId): bool
    {
        return $this->quizResponses()->where('user_id', $userId)->exists();
    }

    // Get a user's score on this quiz
    /**
     * @param int $userId
     * @return int
     */
    public function userScore(int $userId): int
    {
        $quizResponse = $this->quizResponses()->where('user_id', $userId)->first();

        return $quizResponse ? $quizResponse->score : 0;
    }

    /**
     * Check if a user has passed this quiz
     * @param int $userId
     * @return bool
     */
    public function userHasPassed(int $userId): bool
    {
        $quizResponse = $this->quizResponses()->where('user_id', $userId)->orderBy('score', 'desc')->first();

        return $quizResponse ? $quizResponse->score >= $this->passing_score : false;
    }

    /**
     * Calculate the pass rate for this quiz
     * @return int
     */
    public function passRate(): int
    {
        $total = $this->quizResponses()->count();
        $passed = $this->quizResponses()->where('score', '>=', $this->passing_score)->count();

        return $total > 0 ? (int)(($passed / $total) * 100) : 0;
    }
}
