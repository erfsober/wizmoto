<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Brand extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name', 'name_en', 'name_it',
    ];

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

    /**
     * A brand can belong to multiple advertisement types (many-to-many)
     */
    public function advertisementTypes()
    {
        return $this->belongsToMany(AdvertisementType::class, 'advertisement_type_brand');
    }

    /**
     * Legacy method for backward compatibility
     * Returns the first advertisement type
     */
    public function advertisementType()
    {
        return $this->advertisementTypes()->first();
    }

    public function advertisements()
    {
        return $this->hasMany(Advertisement::class);
    }

    public function vehicleModels()
    {
        return $this->hasMany(VehicleModel::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(150)
            ->height(150)
            ->sharpen(10);
    }
}
