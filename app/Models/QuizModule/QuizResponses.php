<?php

namespace App\Models\QuizModule;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizResponses extends Model
{
    /** @use HasFactory<\Database\Factories\QuizModule\QuizResponsesFactory> */
    use HasFactory;

    protected $fillable = ['user_id', 'quiz_id', 'score'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
    public function responses()
    {
        return $this->hasMany(UserAnswer::class);
    }


}
