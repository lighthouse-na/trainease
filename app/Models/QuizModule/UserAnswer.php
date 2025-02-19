<?php

namespace App\Models\QuizModule;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    //
    use HasFactory;
    protected $fillable = ['user_id', 'question_id', 'answer_text'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function selectedOptions()
    {
        return $this->hasMany(UserSelectedOption::class);
    }
}
