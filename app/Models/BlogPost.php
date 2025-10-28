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
        'title', 'title_en', 'title_it',
        'summary', 'summary_en', 'summary_it',
        'body', 'body_en', 'body_it',
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
        $locale = app()->getLocale();
        $column = "title_{$locale}";
        
        // Fallback to English if locale-specific value is not available
        return $this->$column ?? $this->title_en ?? $this->title;
    }

    /**
     * Get the localized summary based on current locale
     *
     * @return string
     */
    public function getLocalizedSummaryAttribute()
    {
        $locale = app()->getLocale();
        $column = "summary_{$locale}";
        
        // Fallback to English if locale-specific value is not available
        return $this->$column ?? $this->summary_en ?? $this->summary;
    }

    /**
     * Get the localized body based on current locale
     *
     * @return string
     */
    public function getLocalizedBodyAttribute()
    {
        $locale = app()->getLocale();
        $column = "body_{$locale}";
        
        // Fallback to English if locale-specific value is not available
        return $this->$column ?? $this->body_en ?? $this->body;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')
            ->singleFile();
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
