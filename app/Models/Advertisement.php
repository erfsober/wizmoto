<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Advertisement extends Model implements HasMedia {
    use InteractsWithMedia;

    protected $with = [ 'media' ];

    public function registerMediaCollections (): void {
        $this->addMediaCollection('covers');
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
        return $this->belongsTo(VehicleColor::class,'color_id');
    }

    public function fuelType (): BelongsTo {
        return $this->belongsTo(FuelType::class);
    }
}
