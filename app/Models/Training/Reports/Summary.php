<?php

namespace App\Models\Training\Reports;

use App\Models\Training\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Summary extends Model
{
    //
    protected $fillable = [
        'course_id',
        'user_id',
        'facilitator_cost',
        'assessment_cost',
        'certification_cost',
        'travel_cost',
        'accommodation_cost',
        'other_cost',
        'total_cost',
    ];

    protected $casts = [
        'facilitator_cost' => 'decimal:2',
        'assessment_cost' => 'decimal:2',
        'certification_cost' => 'decimal:2',
        'travel_cost' => 'decimal:2',
        'accommodation_cost' => 'decimal:2',
        'other_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Course, $this>
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
