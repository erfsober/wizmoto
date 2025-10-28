<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BlogPost;

class BlogCategory extends Model
{
    use HasFactory;
    
    protected $fillable = ['title', 'title_en', 'title_it', 'slug', 'published', 'sort'];

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
    
    public function blogPosts()
    {
        return $this->hasMany(BlogPost::class);
    }
}
