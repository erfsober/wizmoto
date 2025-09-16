<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

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

    public function isTokenValid(): bool
    {
        return $this->token_expires_at && Carbon::parse($this->token_expires_at)->isFuture();           
    }
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->token_expires_at = now()->addDays(10);
            $model->raw_guest_token = bin2hex(random_bytes(32));
        });
        static::updating(function ($model) {
            $model->token_expires_at = now()->addDays(10);
        });
    }

    public function guestToken()
    {
        return hash_hmac('sha256', $this->raw_guest_token, config('app.key'));
    }

    public function getConversationLink()
    {
        return route('chat.guest.show', [
            'providerId' => $this->provider_id,
            'conversation_id' => $this->id,
            'guest_token' => $this->raw_guest_token
        ]);
    }
}
