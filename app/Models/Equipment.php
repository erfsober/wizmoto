<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
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
        return $this->belongsToMany(Advertisement::class, 'advertisement_equipment');
    }
    public function advertisementType()
    {
        return $this->belongsTo(AdvertisementType::class);
    }
}
