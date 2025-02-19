<?php

namespace App\Models\QuizModule;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSelectedOption extends Model
{
    //
    use HasFactory;
    protected $fillable = ['user_answer_id', 'option_id'];

    public function userAnswer()
    {
        return $this->belongsTo(UserAnswer::class);
    }
}
