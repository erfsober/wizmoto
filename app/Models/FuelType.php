<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuelType extends Model
{
    protected $fillable = ['name', 'name_en', 'name_it'];

    /**
     * Get the localized name based on current locale
     *
     * @return string
     */
    public function getLocalizedNameAttribute()
    {
        $locale = app()->getLocale();
        $column = "name_{$locale}";
        
        // Fallback to English if locale-specific value is not available
        return $this->$column ?? $this->name_en ?? $this->name;
    }

    public function advertisements()
    {
        return $this->hasMany(Advertisement::class);
    }
}
