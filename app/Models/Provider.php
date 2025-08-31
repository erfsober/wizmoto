<?php

namespace App\Models;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Provider extends Authenticatable implements MustVerifyEmail , HasMedia {
    use Notifiable;
    use InteractsWithMedia;

    public function registerMediaCollections (): void {
        $this->addMediaCollection('image')
             ->singleFile();
    }

    public function registerMediaConversions ( Media $media = null ): void {
        $this->addMediaConversion('thumb')
             ->width(150)
             ->height(150);
        $this->addMediaConversion('medium')
             ->width(600)
             ->height(400);
    }

    public static function boot () {
        parent::boot();
        ResetPassword::createUrlUsing(function ( $user , string $token ) {
            return route('provider.password.reset' , [
                'token' => $token ,
                'email' => $user->email ,
            ]);
        });
    }

    public function advertisements (): HasMany {
        return $this->hasMany(Advertisement::class);
    }

    protected function fullName (): Attribute {
        return Attribute::make(get: fn () => trim("{$this->first_name} {$this->last_name}") ,);
    }

    public function reviews () {
        return $this->morphMany(Review::class , 'reviewable');
    }
}
