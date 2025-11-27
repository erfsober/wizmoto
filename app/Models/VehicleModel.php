<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleModel extends Model
{
    protected $fillable = ['name', 'name_it', 'brand_id'];

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
    
    public function Brand()
    {
        return $this->belongsTo(Brand::class);
    }
    
    public function advertisements()
    {
        return $this->hasMany(Advertisement::class, 'vehicle_model_id');
    }
}
