<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuelType extends Model
{
    public function advertisementType()
    {
        return $this->belongsTo(AdvertisementType::class);
    }
}
