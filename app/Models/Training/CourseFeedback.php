<?php

namespace App\Models\Training;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseFeedback extends Model
{
    /** @use HasFactory<\Database\Factories\Training\CourseFeedbackFactory> */
    use HasFactory;

    protected $fillable = ['enrollment_id', 'feedback', 'rating', 'is_anonymous'];

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }
}
