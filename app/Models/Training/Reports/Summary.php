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
        'course_material_cost',
        'assessment_cost',
        'certification_cost',
        'travel_cost',
        'accommodation_cost',
        'other_cost',
        'subsistence_cost',
        'total_cost',
        'facilitator_invoice',
        'course_material_invoice',
        'assessment_invoice',
        'certification_invoice',
        'travel_invoice',
        'accommodation_invoice',
        'other_invoice',
        'subsistence_invoice',

    ];

    protected $casts = [
        'facilitator_cost' => 'decimal:2',
        'course_material_cost' => 'decimal:2',
        'assessment_cost' => 'decimal:2',
        'certification_cost' => 'decimal:2',
        'travel_cost' => 'decimal:2',
        'accommodation_cost' => 'decimal:2',
        'other_cost' => 'decimal:2',
        'subsistence_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'facilitator_invoice' => 'string',
        'course_material_invoice' => 'string',
        'assessment_invoice' => 'string',
        'certification_invoice' => 'string',
        'travel_invoice' => 'string',
        'accommodation_invoice' => 'string',
        'other_invoice' => 'string',
        'subsistence_invoice' => 'string',

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
