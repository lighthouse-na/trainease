<?php

namespace App\Models\Training\Quiz;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    //
    protected $fillable = ['question_id', 'option_text', 'is_correct', 'sequence_order'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    // Relationship: An option can be selected in many user answers
    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class, 'selected_option_id');
    }
}
