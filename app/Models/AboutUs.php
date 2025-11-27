<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    protected $fillable = [
        'title', 'title_it',
        'content', 'content_it',
        'section', 'sort', 'is_active',
    ];

    public function getLocalizedTitleAttribute()
    {
        return app()->getLocale() === 'it' && $this->title_it
            ? $this->title_it
            : $this->title;
    }

    public function getLocalizedContentAttribute()
    {
        return app()->getLocale() === 'it' && $this->content_it
            ? $this->content_it
            : $this->content;
    }

    protected static function booted(): void
    {
        static::creating(function (AboutUs $about) {
            if ($about->sort === null) {
                $about->sort = (static::max('sort') ?? 0) + 1;
            }
        });
    }
}
