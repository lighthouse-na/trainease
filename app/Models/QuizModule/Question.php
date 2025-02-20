<?php

namespace App\Models\QuizModule;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    use HasFactory;
    protected $fillable = ['quiz_id', 'question_text', 'question_type'];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    // Relationship: A question has many options
    public function options()
    {
        return $this->hasMany(Option::class);
    }

    // Relationship: A question has many user answers
    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class);
    }
}
