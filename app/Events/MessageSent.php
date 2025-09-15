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
        
        // Add a simple test channel first
        $channels[] = new Channel('test-channel');
        
        // Provider channel
        $provider = $this->message->provider;
        $providerToken = md5('provider.' . $provider->id . env('APP_KEY'));
        $providerChannel = 'provider.' . $this->message->provider_id . '.' . $providerToken;
        $channels[] = new Channel($providerChannel);
        
        // Guest channel
        $guest = $this->message->guest;
        $guestToken = md5($guest->email . $this->message->provider_id . env('APP_KEY'));
        $guestChannel = 'guest.' . $this->message->guest_id . '.' . $guestToken;
        $channels[] = new Channel($guestChannel);
        
        // Log the channels for debugging
        \Log::info('Broadcasting to channels:', [
            'provider_channel' => $providerChannel,
            'guest_channel' => $guestChannel,
            'provider_token' => $providerToken,
            'guest_token' => $guestToken,
            'guest_email' => $guest->email,
            'provider_id' => $this->message->provider_id,
            'guest_id' => $this->message->guest_id,
            'app_key' => env('APP_KEY')
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