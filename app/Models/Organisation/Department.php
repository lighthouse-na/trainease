<?php

namespace App\Models\Organisation;

use App\Models\UserDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    /** @use HasFactory<\Database\Factories\Organisation\DepartmentFactory> */
    use HasFactory;

    protected $fillable = ['department_name', 'division_id'];

    public function users(){
        return $this->hasMany(UserDetail::class);
    }
    public function division(){
        return $this->belongsTo(Division::class);
    }


}
