<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class BlogPost extends Model implements HasMedia {
    use InteractsWithMedia;
    use HasFactory;

    protected $with = [ 'media' ];

    public function registerMediaCollections (): void {
        $this->addMediaCollection('images')
             ->singleFile();
    }

    public function registerMediaConversions ( Media $media = null ): void {
        $this->addMediaConversion('thumb')
             ->width(150)
             ->height(150)
             ->sharpen(10);
        $this->addMediaConversion('medium')
             ->width(500)
             ->height(400);
        $this->addMediaConversion('large')
             ->width(1700)
             ->height(600);
    }

    public function reviews () {
        return $this->morphMany(Review::class , 'reviewable');
    }
}
