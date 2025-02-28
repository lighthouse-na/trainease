<?php

namespace App\Models\Training;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseMaterial extends Model
{
    /** @use HasFactory<\Database\Factories\Training\CourseMaterialFactory> */
    use HasFactory;
    protected $fillable = [
        'course_id',
        'material_name',
        'material_content',
    ];

    protected $casts = [
        'quiz_data' => 'array', // Automatically decode JSON quizzes
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function isCompletedByUser($userId)
    {
        return $this->progress()->where('user_id', $userId)->where('status', 'completed')->exists();
    }


    public function progress()
    {
        return $this->hasMany(CourseProgress::class);
    }
}
