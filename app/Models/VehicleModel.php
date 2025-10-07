<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleModel extends Model
{
    protected $fillable = ['name', 'brand_id'];
    
    public function Brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
