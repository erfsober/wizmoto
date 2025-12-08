<?php

namespace App\Models;

use App\Enums\SellerTypeEnum;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Provider extends Authenticatable implements MustVerifyEmail, HasMedia
{
    use Notifiable;
    use InteractsWithMedia;

    protected $appends = ['full_name', 'formatted_whatsapp', 'whatsapp_link'];
    
    protected $casts = [
        'seller_type' => SellerTypeEnum::class,
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
            ->singleFile()
            ->useDisk('public');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(150)
            ->height(150);
        $this->addMediaConversion('medium')
            ->width(600)
            ->height(400);
    }

    public static function boot()
    {
        parent::boot();
        ResetPassword::createUrlUsing(function ($user, string $token) {
            return route('provider.password.reset', [
                'token' => $token,
                'email' => $user->email,
            ]);
        });
    }

    public function advertisements(): HasMany
    {
        return $this->hasMany(Advertisement::class);
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(get: fn() => trim("{$this->first_name} {$this->last_name}"),);
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function isOAuthUser()
    {
        return !is_null($this->oauth_provider);
    }

    public function needsPassword()
    {
        return is_null($this->password) && $this->isOAuthUser();
    }

    /**
     * Get formatted WhatsApp number for wa.me links
     * Removes all non-numeric characters and ensures country code
     * 
     * @return string|null
     */
    public function getFormattedWhatsappAttribute()
    {
        if (!$this->whatsapp) {
            return null;
        }

        // Remove all non-numeric characters (spaces, dashes, parentheses, +, etc.)
        $number = preg_replace('/[^0-9]/', '', $this->whatsapp);

        // If empty after cleaning, return null
        if (empty($number)) {
            return null;
        }
        if (substr($number, 0, 2) === '00' && strlen($number) > 2) {
            $number = substr($number, 2);
        }
        // If number is too short (less than 10 digits), add Italy country code (39)
        if (strlen($number) < 10) {
            $number = '39' . $number;
        } 
        // If exactly 10 digits and doesn't start with common EU country codes, add Italy (39)
        elseif (strlen($number) == 10 && !in_array(substr($number, 0, 2), ['39', '49', '33', '34', '44', '41', '43', '31', '32', '46', '47', '48', '45'])) {
            $number = '39' . $number;
        }

        return $number;
    }

    /**
     * Get WhatsApp link URL
     * 
     * @return string|null
     */
    public function getWhatsappLinkAttribute()
    {
        $formattedNumber = $this->formatted_whatsapp;
        
        return $formattedNumber ? "https://wa.me/{$formattedNumber}" : null;
    }
}
