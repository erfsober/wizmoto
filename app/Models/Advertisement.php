<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Advertisement extends Model implements HasMedia {
    use InteractsWithMedia;

    protected $with = [ 'media' ];

    public function registerMediaCollections (): void {
        $this->addMediaCollection('covers');
    }

    public function registerMediaConversions ( \Spatie\MediaLibrary\MediaCollections\Models\Media $media = null ): void {
        // Thumbnail for listings
        $this->addMediaConversion('thumb')
             ->fit(Fit::Crop , 300 , 200)
             ->quality(70) // compress quality
             ->format('webp');
        $this->addMediaConversion('preview')
             ->fit(Fit::Crop , 800 , 600)
             ->quality(75)
             ->format('webp');
        // Medium image for detail page
        $this->addMediaConversion('medium')
             ->fit(Fit::Crop , 1024 , 768)
             ->quality(75)
             ->format('webp');
        // Full-size but optimized
        $this->addMediaConversion('large')
             ->fit(Fit::Crop , 1920 , 1080)
             ->quality(80)
             ->format('webp');
    }

    public function provider (): BelongsTo {
        return $this->belongsTo(Provider::class);
    }

    public function advertisementType (): BelongsTo {
        return $this->belongsTo(AdvertisementType::class);
    }

    public function brand (): BelongsTo {
        return $this->belongsTo(Brand::class);
    }

    public function vehicleModel (): BelongsTo {
        return $this->belongsTo(VehicleModel::class);
    }

    public function vehicleBody (): BelongsTo {
        return $this->belongsTo(VehicleBody::class);
    }

    public function vehicleColor (): BelongsTo {
        return $this->belongsTo(VehicleColor::class , 'color_id');
    }

    public function fuelType (): BelongsTo {
        return $this->belongsTo(FuelType::class);
    }

    public function equipments () {
        return $this->belongsToMany(Equipment::class , 'advertisement_equipment');
    }
}
