<?php

use App\Models\Conversation;
use App\Models\Provider;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

// Conversation private channel - handles both provider and guest authorization
Broadcast::channel('conversation.{conversationId}', function ($user, $conversationId) {
    Log::warning("Auth callback hit for conversation {$conversationId}", [
        'user_class' => get_class($user),
        'guest_token' => request()->header('X-Guest-Token'),
        'guest_id' => request()->header('X-Guest-Id'),
    ]);

    $conversation = Conversation::find($conversationId);        Log::warning("No conversation found for ID {$conversationId}");

    if (!$conversation) return false;

    // Provider (authenticated user)
    if ($user instanceof Provider) {
        return (int)$user->id === (int)$conversation->provider_id;
    }

    // Guest: token-based auth via headers sent in the auth request
    $guestToken = request()->header('X-Guest-Token') ?? request('guest_token');
    $guestId = request()->header('X-Guest-Id') ?? request('guest_id');
    Log::info("Auth attempt", ['guestId' => $guestId, 'guestToken' => $guestToken]);
    if (!$guestToken || !$guestId) return false;
    if ((int)$conversation->guest_id !== (int)$guestId) return false;
    if (!$conversation->token_expires_at || Carbon::parse($conversation->token_expires_at)->isPast()) return false;
   

    $expectedHash = $conversation->guestToken();
    $providedHash = hash_hmac('sha256', $guestToken, config('app.key'));

    return hash_equals($expectedHash, $providedHash);
});