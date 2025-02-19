<?php

namespace App\Models\QuizModule;

use App\Models\Training\Training;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    //
    use HasFactory;

    protected $fillable = ['training_id', 'title', 'description'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function training()
    {
        return $this->belongsTo(Training::class);
    }

    public function userHasCompleted($userId)
    {
        return QuizResponses::where('user_id', $userId)
            ->where('quiz_id', $this->id)
            ->exists();
    }


}
