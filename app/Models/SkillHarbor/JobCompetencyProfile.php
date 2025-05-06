<?php

namespace App\Models\SkillHarbor;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class JobCompetencyProfile extends Model
{
    //
    protected $table = 'jcps';

    protected $fillable = ['position_title', 'job_grade', 'user_id', 'duty_station', 'job_purpose', 'is_active'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsToMany<Skill, $this>
     */
    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'jcp_skill', 'jcp_id', 'skill_id')->withPivot('user_rating', 'supervisor_rating', 'required_level');
    }

    /**
     * @return BelongsToMany<Qualification, $this>
     */
    public function qualifications(): BelongsToMany
    {
        return $this->belongsToMany(Qualification::class, 'jcp_qualification', 'jcp_id', 'qualification_id');
    }

    public function scopeSearch(JobCompetencyProfile $query, string $val): void
    {
        $query->where('position_title', 'like', '%'.$val.'%')
            ->orWhere('job_grade', 'like', '%'.$val.'%');
    }

    /**
     * @return \Illuminate\Support\Collection<int, mixed>
     */
    public function skill_category(): \Illuminate\Support\Collection
    {
        return SkillCategory::whereIn('id', $this->skills()->pluck('category_id')->unique())->pluck('category_title');
    }

    /**
     * @return array<int, mixed>
     */
    public function sumRequiredLevelsByCategory(): array
    {
        $categoryTitles = $this->skill_category();
        /**
         * @var array<int, mixed> $sums
         */
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

        return $sums;
    }

    /**
     * @return array<int, mixed>
     */
    public function sumMyLevels(): array
    {
        $categoryTitles = $this->skill_category();
        /**
         * @var array<int, mixed> $sums
         */
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

        return $sums;
    }

    /**
     * @return array<int, mixed>
     */
    public function sumSupervisorLevels(): array
    {
        $categoryTitles = $this->skill_category();
        /**
         * @var array<int, mixed> $sums
         */
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

        return $sums;
    }
}
