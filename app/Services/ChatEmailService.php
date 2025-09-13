<?php

namespace App\Services;

use App\Models\Message;
use App\Models\Guest;
use App\Models\Provider;
use App\Models\Advertisement;
use Illuminate\Support\Facades\Mail;

class ChatEmailService
{
    public static function sendGuestMessageToProvider(Message $message)
    {
        $guest = Guest::find($message->guest_id);
        $provider = Provider::find($message->provider_id);
        $advertisement = Advertisement::where('provider_id', $provider->id)->first();

        Mail::send('emails.guest-message-to-provider', [
            'guest' => $guest,
            'provider' => $provider,
            'guestMessage' => $message,
            'advertisement' => $advertisement
        ], function($mail) use ($provider, $guest) {
            $mail->to($provider->email)
                 ->subject("New message from {$guest->name}")
                 ->replyTo($guest->email);
        });
    }

    public static function sendProviderReplyToGuest(Message $message)
    {
        $guest = Guest::find($message->guest_id);
        $provider = Provider::find($message->provider_id);
        $advertisement = Advertisement::where('provider_id', $provider->id)->first();
        
        $conversationLink = route('chat.guest.continue', [
            'providerId' => $provider->id,
            'guestId' => $guest->id,
            'email' => $guest->email,
            'token' => md5($guest->email . $provider->id . env('APP_KEY'))
        ]);

        Mail::send('emails.provider-reply-to-guest', [
            'guest' => $guest,
            'provider' => $provider,
            'providerMessage' => $message,
            'advertisement' => $advertisement,
            'conversationLink' => $conversationLink
        ], function($mail) use ($guest, $provider) {
            $mail->to($guest->email)
                 ->subject("Reply from {$provider->full_name}")
                 ->replyTo($provider->email);
        });
    }
}