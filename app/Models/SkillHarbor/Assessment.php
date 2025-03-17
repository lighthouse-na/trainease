<?php

namespace App\Models\SkillHarbor;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    //
    protected $dates = ['created_at', 'updated_at', 'closing_date'];


    public function enrolled()
    {
        return $this->belongsToMany(User::class, 'skillharbor_enrollments', 'assessment_id', 'user_id')
            ->withPivot('user_status', 'supervisor_status');
    }
    public function getEnrolledDepartmentIds()
    {
        // Get the IDs of the departments for users enrolled in this assessment
        return $this->enrolled()
            ->with('department') // Ensure you load the department relationship
            ->get()
            ->pluck('department.id') // Get the department IDs
            ->unique() // Ensure uniqueness
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
