<?php

namespace App\Models\SkillHarbor;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    //
    protected $fillable = ['assessment_title', 'closing_date'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'closing_date' => 'datetime',
    ];

    public function enrolled()
    {
        return $this->belongsToMany(User::class, 'skillharbor_enrollments', 'assessment_id', 'user_id')
            ->withPivot('user_status', 'supervisor_status');
    }

    public function enrolledCount(){
        return $this->enrolled()->count();
    }
    public function getEnrolledDepartmentIds():array
    {
        // Get the IDs of the departments for users enrolled in this assessment
        return $this->enrolled()
            ->with('user_detail') // Load the user_detail relationship from User model
            ->get()
            ->pluck('user_detail.department_id') // Get department_id from user_detail
            ->filter() // Remove any null values
            ->unique() // Ensure uniqueness
            ->values() // Reset array keys
            ->toArray(); // Convert to array
    }
    public function scopeSearch($query, $search)
    {
        return $query->where('assessment_title', 'like', '%'.$search.'%');
    }
    public function countSubmittedForReview($userStatus = 1)
    {
        // Count the number of users who have submitted assessments for review
        return $this->enrolled()
            ->wherePivot('user_status', $userStatus)
            ->count();
    }
}
