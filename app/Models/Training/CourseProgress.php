<?php

namespace App\Models\Training;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseProgress extends Model
{
    /** @use HasFactory<\Database\Factories\Training\CourseProgressFactory> */
    use HasFactory;

    protected $fillable = ['user_id', 'course_id', 'course_material_id', 'status'];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     *@return BelongsTo<Course, $this>
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * @return BelongsTo<CourseMaterial, $this>
     */
    public function material(): BelongsTo
    {
        return $this->belongsTo(CourseMaterial::class);
    }




}
