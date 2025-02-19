<?php

namespace App\Models\Training;

use App\Models\QuizModule\Quiz;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    /** @use HasFactory<\Database\Factories\Training\TrainingFactory> */
    use HasFactory;

    protected $guarded = [];


    public function trainer(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function enrollment(){
        return $this->belongsToMany(Enrollment::class);
    }

    public function materials() {
        return $this->hasMany(CourseMaterial::class, 'training_id');
    }
    public function quizzes() {
        return $this->hasMany(Quiz::class, 'training_id');
    }
    public function progress()
    {
        return $this->hasMany(CourseProgress::class);
    }
    public function enrolledUsers()
    {
        return $this->belongsToMany(User::class, 'enrollments', 'training_id', 'user_id');
    }
}
