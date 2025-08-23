<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model {
    public function advertisements () {
        return $this->belongsToMany(Advertisement::class , 'advertisement_equipment');
    }
}
