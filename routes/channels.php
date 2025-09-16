<?php

use App\Models\Conversation;
use App\Models\Provider;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

// Conversation private channel - handles both provider and guest authorization
Broadcast::channel('conversation.{conversationId}', function ($user, $conversationId) {
  
    $conversation = Conversation::find($conversationId);      

    if (!$conversation) {
        return response()->json(['authorized' => false], 403);

    };

    // Provider (authenticated user)
    if ($user instanceof Provider) {
        $authorized = ((int)$user->id === (int)$conversation->provider_id);
        return ['authorized' => $authorized];    }

    // Guest: token-based auth via headers sent in the auth request
    $guestToken = request()->header('X-Guest-Token') ?? request('guest_token');
    $guestId = request()->header('X-Guest-Id') ?? request('guest_id');
    if (!$guestToken || !$guestId) return ['authorized' => false];
    if ((int)$conversation->guest_id !== (int)$guestId) return ['authorized' => false];
    if (!$conversation->token_expires_at || Carbon::parse($conversation->token_expires_at)->isPast()) return ['authorized' => false];
   

    $expectedHash = $conversation->guestToken();
    $providedHash = hash_hmac('sha256', $guestToken, config('app.key'));

    return ['authorized' => hash_equals($expectedHash, $providedHash)];
});