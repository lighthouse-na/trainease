<?php

namespace App\Models\SkillHarbor;

use Illuminate\Database\Eloquent\Model;

class UserQualification extends Model
{
    protected $table = 'user_qualification';

    protected $fillable = [
        'user_id',
        'qualification_id',

    ];
    //
}
