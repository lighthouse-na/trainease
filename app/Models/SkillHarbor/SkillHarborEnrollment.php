<?php

namespace App\Models\SkillHarbor;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class SkillHarborEnrollment extends Model
{
    //
    protected $table = 'skillharbor_enrollments';
    protected $fillable = ['user_id', 'assessment_id', 'user_status', 'supervisor_status'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }
}
