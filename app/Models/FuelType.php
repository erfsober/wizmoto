<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuelType extends Model
{
    public function advertisements()
    {
        return $this->hasMany(Advertisement::class);
    }
}
