<?php

namespace App\Models\Quiz;

use App\Models\Training\Training;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    /** @use HasFactory<\Database\Factories\Quiz\QuizFactory> */
    use HasFactory;

    protected $fillable = ['title', 'description', 'trainer_id', 'is_active'];

    public function training(){
        return $this->belongsTo(Training::class, 'training_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }
}
