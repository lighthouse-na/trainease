<?php

namespace App\Models;

use App\Models\Organisation\Department;
use App\Models\Organisation\Division;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDetail extends Model
{
    /** @use HasFactory<\Database\Factories\UserDetailFactory> */
    use HasFactory;

    protected $fillable = ['user_id', 'division_id', 'department_id', 'supervisor_id', 'salary_ref_number', 'gender', 'dob', 'phone_number', 'address', 'consultant_domain', 'job_grade', 'aa_title'];

    protected $table = 'user_details';

    protected $casts = [
        'dob' => 'date:dd-mm-YYYY',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsTo<Division, $this>
     */
    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }

    /**
     * @return BelongsTo<Department, $this>
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }
}
