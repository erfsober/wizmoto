<?php

use App\Models\Provider;
use App\Models\Guest;
use Illuminate\Support\Facades\Broadcast;

// Provider private channels (Laravel auth)
Broadcast::channel('provider.{id}', function ($user, $id) {
    return $user instanceof Provider && (int) $user->id === (int) $id;
});

// Guest private channels (custom token-based auth)
Broadcast::channel('guest.{guestId}.{token}', function ($user, $guestId, $token) {
    // For guests, we validate the token instead of user auth
    $guest = Guest::find($guestId);
    if (!$guest) {
        return false;
    }
    
    // Get provider from current session/request (you'll need to pass this)
    $providerId = request()->get('provider_id');
    if (!$providerId) {
        return false;
    }
    
    // Verify the token matches our algorithm
    $expectedToken = md5($guest->email . $providerId . env('APP_KEY'));
    return $token === $expectedToken;
});
