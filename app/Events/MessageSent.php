<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        // Broadcast to both guest and provider channels
        if ($this->message->sender_type === 'guest') {
            return new PrivateChannel('provider.' . $this->message->provider_id);
        } else {
            return new PrivateChannel('guest.' . $this->message->guest_id);
        }
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->message->id,
            'sender_type' => $this->message->sender_type,
            'message' => $this->message->message,
            'created_at' => $this->message->created_at?->toDateTimeString(),
            'guest_id' => $this->message->guest_id,
            'provider_id' => $this->message->provider_id,
        ];
    }

    public function broadcastAs(): string
    {
        return 'MessageSent';
    }
}