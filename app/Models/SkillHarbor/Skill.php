<?php

namespace App\Models\SkillHarbor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Skill extends Model
{
    //
    protected $fillable = ['skill_title', 'skill_description', 'skill_category_id'];
    /**
     * @return BelongsTo<SkillCategory, Skill>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(SkillCategory::class, 'skill_category_id');
    }

    /**
     * @return BelongsToMany<JobCompetencyProfile, Skill>
     */
    public function jcps(): BelongsToMany
    {
        return $this->belongsToMany(JobCompetencyProfile::class)->withPivot('user_rating', 'supervisor_rating', 'required_level');
    }

    public function scopeSearch($query, $val, $category = null)
    {
        $query->where(function ($query) use ($val) {
            $query->where('skill_title', 'like', '%'.$val.'%')
                ->orWhere('skill_description', 'like', '%'.$val.'%');
        });

        if ($category) {
            $query->where('skill_category', '=', $category);
        }
    }
}
