<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    /** @use HasFactory<\Database\Factories\UserDetailFactory> */
    use HasFactory;


    public $fillable = [
        'user_id',
        'division_id',
        'department_id',
        'supervisor_id',
        'salary_ref_number',
        'gender',
        'dob',
        'phone_number',
        'address',

    ];
    protected $casts = [
        'dob' => 'date:dd-mm-YYYY',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }


}
