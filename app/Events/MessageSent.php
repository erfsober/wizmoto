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
        $channels = [];
        
        // Provider gets private channel (authenticated)
        $channels[] = new PrivateChannel('provider.' . $this->message->provider_id);
        
        // Guest gets a secure public channel with token
        $guest = $this->message->guest;
        $secureToken = md5($guest->email . $this->message->provider_id . env('APP_KEY'));
        $channels[] = new Channel('guest.' . $this->message->guest_id . '.' . $secureToken);
        
        return $channels;
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
            'provider' => $this->message->provider,
            'guest' => $this->message->guest,
        ];
    }

    public function broadcastAs(): string
    {
        return 'MessageSent';
    }
}