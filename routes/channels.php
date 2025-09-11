<?php

use App\Models\Provider;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Chat channels for providers and guests
Broadcast::channel('provider.{id}', function ($user, $id) {
    return $user instanceof Provider && (int) $user->id === (int) $id;
});

Broadcast::channel('guest.{id}', function ($user, $id) {
    return $user instanceof \App\Models\Guest && (int) $user->id === (int) $id;
});

Broadcast::channel('chat', function ($user) {
    // Allow authenticated providers and guests to join the general chat
    return $user instanceof Provider || $user instanceof \App\Models\Guest;
});

Broadcast::channel('chat.{roomId}', function ($user, $roomId) {
    // Allow authenticated providers and guests to join specific chat rooms
    return $user instanceof Provider || $user instanceof \App\Models\Guest;
});
