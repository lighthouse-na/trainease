<?php

namespace App\Models\Organisation;

use App\Models\UserDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    /** @use HasFactory<\Database\Factories\Organisation\DivisionFactory> */
    use HasFactory;

    protected $fillable = ['division_name', 'organisation_id'];

    public function department()
    {
        return $this->hasMany(Department::class);
    }

    public function users()
    {
        return $this->hasMany(UserDetail::class);
    }

    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }
}
