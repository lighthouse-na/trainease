<?php

namespace App\Models\Organisation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organisation extends Model
{
    /** @use HasFactory<\Database\Factories\Organisation\OrganisationFactory> */
    use HasFactory;

    protected $fillable = ['organisation_name', 'organisation_logo'];

    /**
     * @return HasMany<Division, $this>
     */
    public function divisions(): HasMany
    {
        return $this->hasMany(Division::class);
    }
}
