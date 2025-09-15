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
use Illuminate\Support\Facades\Log;
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
        
        // Provider gets private channel (authenticated via Laravel auth)
        $providerChannel = 'provider.' . $this->message->provider_id;
        $channels[] = new PrivateChannel($providerChannel);
        
        // Guest gets private channel with token-based auth
        $guest = $this->message->guest;
        $guestToken = md5($guest->email . $this->message->provider_id . env('APP_KEY'));
        $guestChannel = 'guest.' . $this->message->guest_id . '.' . $guestToken;
        $channels[] = new PrivateChannel($guestChannel);
        
        // Log the channels for debugging
        \Log::info('Broadcasting to private channels:', [
            'provider_channel' => $providerChannel,
            'guest_channel' => $guestChannel,
            'guest_token' => $guestToken,
            'guest_email' => $guest->email,
            'provider_id' => $this->message->provider_id,
            'guest_id' => $this->message->guest_id
        ]);
        
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