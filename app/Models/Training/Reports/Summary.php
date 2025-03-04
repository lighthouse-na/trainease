<?php

namespace App\Models\Training\Reports;

use App\Models\Training\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
