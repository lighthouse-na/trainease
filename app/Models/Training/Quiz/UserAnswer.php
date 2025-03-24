<?php

namespace App\Models\Training\Quiz;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAnswer extends Model
{
    //
    protected $fillable = ['question_id', 'answer_text', 'quiz_response_id', 'option_id', 'is_correct'];

    public function quizResponse()
    {
        return $this->belongsTo(QuizResponse::class);
    }

    // Relationship: A user answer belongs to a question
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    // Relationship: A user answer belongs to a selected option
    /**
     * @return BelongsTo<Option, $this>
     */
    public function selectedOption(): BelongsTo
    {
        return $this->belongsTo(Option::class, 'option_id');
    }

    // Check if this answer is correct
    public function isCorrect()
    {
        return $this->selectedOption && $this->selectedOption->is_correct;
    }
}
