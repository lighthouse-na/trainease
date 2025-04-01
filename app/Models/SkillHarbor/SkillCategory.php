<?php

namespace App\Models\SkillHarbor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SkillCategory extends Model
{
    //
    protected $fillable = ['category_title'];

    protected $table = 'skill_categories';

    /**
     * @return HasMany<Skill, $this>
     */
    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class, 'skill_category_id');
    }
}
