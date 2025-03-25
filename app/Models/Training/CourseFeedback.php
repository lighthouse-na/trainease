<?php

namespace App\Models\Training;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseFeedback extends Model
{
    /** @use HasFactory<\Database\Factories\Training\CourseFeedbackFactory> */
    use HasFactory;

    protected $fillable = ['enrollment_id', 'feedback', 'rating', 'is_anonymous'];

    /**
     * @return BelongsTo<Enrollment, $this>
     */
    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }
}
