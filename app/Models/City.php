<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends Model
{
    protected $fillable = ['country_id', 'name'];

    /**
     * Get the country that owns the city.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
