<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Advertisement extends Model implements HasMedia {
    use InteractsWithMedia;

    public function registerMediaCollections (): void {
        $this->addMediaCollection('cover')
             ->singleFile();
    }
}
