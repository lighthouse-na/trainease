<?php

namespace App\Models\SkillHarbor;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Qualification extends Model
{
    //
    protected $fillable = ['user_id', 'qualification_title', 'institution', 'qualification_level'];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    /**
     * @return BelongsToMany<JobCompetencyProfile, $this>
     */
    public function jcp(): BelongsToMany
    {
        return $this->belongsToMany(JobCompetencyProfile::class, 'jcp_qualification');
    }

    /**
     * @return BelongsToMany<User, $this>
     */
    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_qualification')->withPivot('from_date','end_date','status');
    }

    /**
     * @param Qualification $query
     * @param string $val
     * @return void
     */
    public function scopeSearch(Qualification $query, string $val): void
    {
        $query->where('qualification_title', 'like', '%'.$val.'%');
    }
}
