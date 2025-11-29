<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class BlogPost extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;

    protected $with = ['media'];
    
    protected $fillable = [
        'title', 'title_it',
        'summary', 'summary_it',
        'body', 'body_it',
        'slug', 'author_name', 'published', 'views',
        'admin_id', 'blog_category_id'
    ];

    /**
     * Get the localized title based on current locale
     *
     * @return string
     */
    public function getLocalizedTitleAttribute()
    {
        return app()->getLocale() === 'it' && $this->title_it
            ? $this->title_it
            : $this->title;
    }

    /**
     * Get the localized summary based on current locale
     *
     * @return string
     */
    public function getLocalizedSummaryAttribute()
    {
        return app()->getLocale() === 'it' && $this->summary_it
            ? $this->summary_it
            : $this->summary;
    }

    /**
     * Get the localized body based on current locale
     *
     * @return string
     */
    public function getLocalizedBodyAttribute()
    {
        return app()->getLocale() === 'it' && $this->body_it
            ? $this->body_it
            : $this->body;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')
            ->singleFile()
            ->useDisk('public');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->fit(Fit::Crop, 150, 150)
            ->quality(75)
            ->format('webp');
        $this->addMediaConversion('medium')
            ->fit(Fit::Crop, 500, 329)
            ->quality(75)
            ->format('webp');
        $this->addMediaConversion('large')
            ->fit(Fit::Crop, 1700, 600)
            ->quality(75)
            ->format('webp');
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function blogCategory()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }
}
