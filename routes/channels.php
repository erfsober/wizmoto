<?php

use App\Models\Provider;
use Illuminate\Support\Facades\Broadcast;

// Only the provider private channel is needed for authentication
// Guest channels are public with secure tokens
Broadcast::channel('provider.{id}', function ($user, $id) {
    return $user instanceof Provider && (int) $user->id === (int) $id;
});
