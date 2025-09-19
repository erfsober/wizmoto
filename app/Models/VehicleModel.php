<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleModel extends Model
{
    public function Brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
