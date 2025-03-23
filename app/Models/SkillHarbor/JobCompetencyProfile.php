<?php

namespace App\Models\SkillHarbor;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class JobCompetencyProfile extends Model
{
    //
    protected $table = 'jcps';
    public function employee()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function skills()
    {
        return $this->belongsToMany(skill::class)->withPivot('user_rating', 'supervisor_rating', 'required_level');
    }

    public function qualifications()
    {
        return $this->belongsToMany(qualification::class, 'jcp_qualification');
    }

    public function scopeSearch($query, $val)
    {
        return $query->where('position_title', 'like', '%'.$val.'%')
            ->orWhere('job_grade', 'like', '%'.$val.'%');
    }


    public function skill_category()
    {
        return $this->skills()->with('category')->get()->pluck('category')->flatten()->pluck('category_title')->unique()->values()->toArray();
    }

    public function sumRequiredLevelsByCategory()
    {
        $categoryTitles = $this->skill_category();
        $sums = [];

        foreach ($categoryTitles as $categoryTitle) {
            $category = SkillCategory::where('category_title', $categoryTitle)->first();
            if ($category) {
                $sum = 0;
                foreach ($category->skills as $skill) {
                    // Check if the skill belongs to the jcp
                    if ($this->skills->contains($skill)) {
                        $pivot = $this->skills()->where('skill_id', $skill->id)->first()->pivot;
                        $sum += $pivot->required_level;
                    }
                }
                $sums[] = ['category' => $categoryTitle, 'value' => $sum];
            }
        }

        return $sums ?? [];
    }

    public function sumMyLevels()
    {
        $categoryTitles = $this->skill_category();

        $sums = [];
        foreach ($categoryTitles as $categoryTitle) {
            $category = SkillCategory::where('category_title', $categoryTitle)->first();
            if ($category) {
                $sum = 0;
                foreach ($category->skills as $skill) {
                    // Check if the skill belongs to the jcp
                    if ($this->skills->contains($skill)) {
                        $pivot = $this->skills()->where('skill_id', $skill->id)->first()->pivot;
                        $sum += $pivot->user_rating;
                    }
                }
                $sums[] = ['category' => $categoryTitle, 'value' => $sum];
            }
        }

        return $sums ?? [];
    }

    public function sumSupervisorLevels()
    {
        $categoryTitles = $this->skill_category();

        $sums = [];
        foreach ($categoryTitles as $categoryTitle) {
            $category = SkillCategory::where('category_title', $categoryTitle)->first();
            if ($category) {
                $sum = 0;
                foreach ($category->skills as $skill) {
                    // Check if the skill belongs to the jcp
                    if ($this->skills->contains($skill)) {
                        $pivot = $this->skills()->where('skill_id', $skill->id)->first()->pivot;
                        $sum += $pivot->supervisor_rating;
                    }
                }
                $sums[] = ['category' => $categoryTitle, 'value' => $sum];
            }
        }

        return $sums ?? [];
    }
}
