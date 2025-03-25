<?php

namespace App\Models\SkillHarbor;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SkillHarborEnrollment extends Model
{
    //
    protected $table = 'skillharbor_enrollments';
    protected $fillable = ['user_id', 'assessment_id', 'user_status', 'supervisor_status'];
    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Assessment, $this>
     */
    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }
}
