<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Admin extends Authenticatable implements FilamentUser, HasMedia
{
    use  InteractsWithMedia;
    protected $guard_name = 'admin';

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('image')
            ->width(150)
            ->height(150);
    }
}
