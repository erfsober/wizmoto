<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuelType extends Model
{
    protected $fillable = ['name', 'name_it'];

    /**
     * Get the localized name based on current locale
     *
     * @return string
     */
    public function getLocalizedNameAttribute()
    {
        return app()->getLocale() === 'it' && $this->name_it
            ? $this->name_it
            : $this->name;
    }

    public function advertisements()
    {
        return $this->hasMany(Advertisement::class);
    }
}
