<?php

namespace App\Models\Quiz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizResponse extends Model
{
    /** @use HasFactory<\Database\Factories\Quiz\QuizResponseFactory> */
    use HasFactory;

    protected $fillable = ['attempt_id', 'question_id', 'option_id', 'answer_text'];

    public function attempt()
    {
        return $this->belongsTo(QuizAttempt::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function option()
    {
        return $this->belongsTo(Option::class);
    }
}
