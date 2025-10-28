<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvertisementType extends Model
{
    protected $fillable = ['title', 'title_en', 'title_it'];

    /**
     * Get the localized title based on current locale
     *
     * @return string
     */
    public function getLocalizedTitleAttribute()
    {
        $locale = app()->getLocale();
        $column = "title_{$locale}";
        
        // Fallback to English if locale-specific value is not available
        return $this->$column ?? $this->title_en ?? $this->title;
    }
}
