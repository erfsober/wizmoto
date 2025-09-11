<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function getSenderAttribute()
    {
        if ($this->sender_type === 'guest') {
            return $this->guest;
        }
        return $this->provider;
    }
}
