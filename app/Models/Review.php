<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model {
    public function reviewable () {
        return $this->morphTo();
    }
    public function provider() {
        return $this->belongsTo(Provider::class);
    }
}
