<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Get the places for the country.
     */
    public function places(): HasMany
    {
        return $this->hasMany(Place::class);
    }
}
