<?php

namespace App\Models\SkillHarbor;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    //
    protected $fillable = ['skill_title', 'skill_description', 'skill_category_id'];
    public function category()
    {
        return $this->belongsTo(SkillCategory::class, 'skill_category_id');
    }

    public function jcps()
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
