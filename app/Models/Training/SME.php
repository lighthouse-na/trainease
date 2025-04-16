<?php

namespace App\Models\Training;

use Illuminate\Database\Eloquent\Model;

class SME extends Model
{
    //
    protected $fillable = [
        'sme_name',
        'sme_email',
        'sme_phone',
        'sme_type',
        'sme_institution',
        'sme_description',
        'consultant_id'
    ];

    public function courses()
    {
        return $this->hasMany(Course::class, 'sme_id');
    }
}
