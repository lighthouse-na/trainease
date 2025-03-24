<?php

namespace App\Models\SkillHarbor;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class JobCompetencyProfile extends Model
{
    //
    protected $table = 'jcps';
    public function employee()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsToMany<Skill, $this>
     */
    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class)->withPivot('user_rating', 'supervisor_rating', 'required_level');
    }

    public function qualifications()
    {
        return $this->belongsToMany(Qualification::class, 'jcp_qualification');
    }

    public function scopeSearch($query, $val)
    {
        return $query->where('position_title', 'like', '%'.$val.'%')
            ->orWhere('job_grade', 'like', '%'.$val.'%');
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function skill_category(): \Illuminate\Support\Collection
    {
        return SkillCategory::whereIn('id', $this->skills()->pluck('category_id')->unique())->pluck('category_title');
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
                        $pivot = $this->skills()->where('skill_id', $skill->id)->first();
                        $sum += $pivot->$this->jcp()->required_level;
                    }
                }
                $sums[] = ['category' => $categoryTitle, 'value' => $sum];
            }
        }

        return $sums ;
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
                        $pivot = $this->skills()->where('skill_id', $skill->id)->first();
                        $sum += $pivot->$this->jcp()->user_rating;
                    }
                }
                $sums[] = ['category' => $categoryTitle, 'value' => $sum];
            }
        }

        return $sums ;
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
                        $pivot = $this->skills()->where('skill_id', $skill->id)->first();
                        $sum += $pivot->$this->jcp()->supervisor_rating;
                    }
                }
                $sums[] = ['category' => $categoryTitle, 'value' => $sum];
            }
        }

        return $sums ;
    }
}
