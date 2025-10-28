<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    protected $fillable = [
        'title', 'title_en', 'title_it',
        'content', 'content_en', 'content_it',
        'section', 'sort', 'is_active'
    ];

    public function getLocalizedTitleAttribute()
    {
        $locale = app()->getLocale();
        $column = "title_{$locale}";
        return $this->$column ?? $this->title_en ?? $this->title;
    }

    public function getLocalizedContentAttribute()
    {
        $locale = app()->getLocale();
        $column = "content_{$locale}";
        return $this->$column ?? $this->content_en ?? $this->content;
    }
}
