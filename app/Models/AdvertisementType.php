<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvertisementType extends Model
{
    protected $fillable = ['title', 'title_it'];

    /**
     * Get the localized title based on current locale
     *
     * @return string
     */
    public function getLocalizedTitleAttribute()
    {
        return app()->getLocale() === 'it' && $this->title_it
            ? $this->title_it
            : $this->title;
    }
}
