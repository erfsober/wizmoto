<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BlogPost;

class BlogCategory extends Model
{
    use HasFactory;
    
    protected $fillable = ['title', 'title_it', 'slug', 'published', 'sort'];

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
    
    public function blogPosts()
    {
        return $this->hasMany(BlogPost::class);
    }
}
