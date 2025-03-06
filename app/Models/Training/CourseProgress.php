<?php

namespace App\Models\Training;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseProgress extends Model
{
    /** @use HasFactory<\Database\Factories\Training\CourseProgressFactory> */
    use HasFactory;

    protected $fillable = ['user_id', 'course_id', 'course_material_id', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsToMany(Course::class);
    }

    public function material()
    {
        return $this->belongsTo(CourseMaterial::class);
    }




}
