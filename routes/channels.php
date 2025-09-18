<?php

use App\Models\Conversation;
use App\Models\Provider;
use Illuminate\Support\Facades\Broadcast;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

Broadcast::routes([
    'middleware' => ['web'], 
]);

// Conversation private channel - handles both provider and guest authorization
Broadcast::channel('conversation.{conversationId}', function ($user, $conversationId) {
    Log::info('Channel auth attempt', [
        'user' => $user ? $user->id : null,
        'conversationId' => $conversationId,
        'headers' => request()->headers->all(),
    ]);
    $conversation = Conversation::find($conversationId);       

    if (!$conversation) return false;

    // Provider (authenticated user)
    $provider = Auth::guard('provider')->user();
    if ($provider && $user instanceof Provider) {
        return (int)$user->id === (int)$conversation->provider_id;
    }

    // Guest: token-based auth via headers sent in the auth request
    $guestToken = request()->header('X-Guest-Token') ?? request('guest_token');
    $guestId = request()->header('X-Guest-Id') ?? request('guest_id');
    if (!$guestToken || !$guestId) return false;
    if ((int)$conversation->guest_id !== (int)$guestId) return false;
    if (!$conversation->token_expires_at || Carbon::parse($conversation->token_expires_at)->isPast()) return false;
   

    $expectedHash = $conversation->guestToken();
    $providedHash = hash_hmac('sha256', $guestToken, config('app.key'));

    return hash_equals($expectedHash, $providedHash);
});