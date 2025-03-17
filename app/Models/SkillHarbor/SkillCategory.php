<?php

namespace App\Models\SkillHarbor;

use Illuminate\Database\Eloquent\Model;

class SkillCategory extends Model
{
    //
    public function skills()
    {
        return $this->hasMany(Skill::class, 'skill_category_id');
    }
}
