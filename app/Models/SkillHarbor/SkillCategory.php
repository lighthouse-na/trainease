<?php

namespace App\Models\SkillHarbor;

use Illuminate\Database\Eloquent\Model;

class SkillCategory extends Model
{
    //
    protected $fillable = ['category_title'];
    protected $table = 'skill_categories';
    public function skills()
    {
        return $this->hasMany(Skill::class, 'skill_category_id');
    }
}
