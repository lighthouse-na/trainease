<?php

namespace App\Models\Organisation;

use App\Models\UserDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Division extends Model
{
    /** @use HasFactory<\Database\Factories\Organisation\DivisionFactory> */
    use HasFactory;

    protected $fillable = ['division_name', 'organisation_id'];

    /**
     * @return HasMany<Department, $this>
     */
    public function department(): HasMany
    {
        return $this->hasMany(Department::class);
    }

    /**
     * @return HasMany<UserDetail, $this>
     */
    public function users(): HasMany
    {
        return $this->hasMany(UserDetail::class);
    }

    /**
     * @return BelongsTo<Organisation, $this>
     */
    public function organisation(): BelongsTo
    {
        return $this->belongsTo(Organisation::class);
    }
}
