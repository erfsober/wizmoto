<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\MessageSenderTypeEnum;

class Message extends Model
{
    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function getSenderAttribute()
    {
        if ($this->sender_type === MessageSenderTypeEnum::GUEST->value) {
            return $this->guest;
        }
        return $this->provider;
    }
}
