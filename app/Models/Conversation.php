<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Conversation extends Model
{
 
    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
            $model->access_token = Str::random(25);
        });
    }

    public function getConversationLink()
    {
        return route('chat.guest.show', [
            'accessToken' => $this->access_token
        ]);
    }

    public function isTokenValid()
    {
        return true; // Tokens never expire
    }
}
