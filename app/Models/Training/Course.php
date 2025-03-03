<?php

namespace App\Models\Training;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Training\Quiz\Quiz;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\Training\CourseFactory> */
    use HasFactory;

    protected $fillable = ['course_name', 'course_description', 'course_fee', 'course_image', 'user_id'];

    public function trainer(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function enrollment(){
        return $this->belongsToMany(Enrollment::class, 'enrollments', 'course_id', 'user_id');
    }

    public function materials() {
        return $this->hasMany(CourseMaterial::class, 'course_id');
    }
    public function quizes() {
        return $this->hasMany(Quiz::class, 'course_id');
    }
    public function progress()
    {
        return $this->hasMany(CourseProgress::class);
    }
    public function enrolledUsers()
    {
        return $this->belongsToMany(User::class, 'enrollments', 'course_id', 'user_id');
    }

    public function feedback()
    {
        return $this->hasMany(CourseFeedback::class);
    }


}
