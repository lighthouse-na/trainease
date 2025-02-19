<?php

namespace App\Models\QuizModule;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    //
    use HasFactory;
    protected $fillable = ['question_id', 'option_text', 'is_correct', 'sequence_order'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
