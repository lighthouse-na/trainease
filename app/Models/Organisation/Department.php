<?php

namespace App\Models\Organisation;

use App\Models\UserDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    /** @use HasFactory<\Database\Factories\Organisation\DepartmentFactory> */
    use HasFactory;

    protected $fillable = ['department_name', 'division_id'];

    /**
     * @return HasMany<UserDetail, $this>
     */
    public function users(): HasMany
    {
        return $this->hasMany(UserDetail::class);
    }

    /**
     * @return BelongsTo<Division, $this>
     */
    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }
}
