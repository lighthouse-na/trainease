<?php

namespace App\Models\Organisation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organisation extends Model
{
    /** @use HasFactory<\Database\Factories\Organisation\OrganisationFactory> */
    use HasFactory;

    protected $fillable = ['organisation_name', 'organisation_logo'];

    public function divisions()
    {
        return $this->hasMany(Division::class);
    }
}
