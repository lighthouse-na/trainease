<?php

namespace App\Models\Training;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    /** @use HasFactory<\Database\Factories\Training\EnrollmentFactory> */
    use HasFactory;

    protected $fillable = ['user_id', 'course_id', 'status', 'enrolled_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function courses()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function feedback()
    {
        return $this->hasMany(CourseFeedback::class);
    }
}
