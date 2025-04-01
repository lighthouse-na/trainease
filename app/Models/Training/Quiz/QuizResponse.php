<?php

namespace App\Models\Training\Quiz;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizResponse extends Model
{
    //
    protected $fillable = ['user_id', 'quiz_id', 'score', 'attempts', 'status'];

    protected $table = 'quiz_responses';

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: A quiz response belongs to a quiz
    /**
     * @return BelongsTo<Quiz, $this>
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    // Relationship: A quiz response has many user answers
    /**
     * @return HasMany<UserAnswer, $this>
     */
    public function userAnswers(): HasMany
    {
        return $this->hasMany(UserAnswer::class);
    }

    // Calculate and update the user's quiz score
    public function calculateScore(): int
    {
        $totalQuestions = $this->quiz?->questions()->count();
        $correctAnswers = $this->userAnswers()
            ->whereHas('selectedOption', function ($query) {
                $query->where('is_correct', true);
            })
            ->count();

        $this->score = $totalQuestions > 0 ? (int) (round(($correctAnswers / $totalQuestions) * 100, 0)) : 0;
        $this->save();

        return $this->score;
    }
}
