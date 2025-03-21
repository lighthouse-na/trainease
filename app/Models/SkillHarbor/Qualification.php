<?php

namespace App\Models\SkillHarbor;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    //
    protected $fillable = ['user_id', 'qualification_title', 'institution', 'qualification_level'];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    public function jcp()
    {
        return $this->belongsToMany(JobCompetencyProfile::class, 'jcp_qualification');
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'qualification_user');
    }

    public function scopeSearch($query, $val)
    {
        $query->where('qualification_title', 'like', '%'.$val.'%');
    }
}
