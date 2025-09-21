<?php

use Illuminate\Support\Facades\Broadcast;

// Enable broadcasting routes for web middleware
// Broadcast::routes(['middleware' => ['web']]);

// No channel authorization needed for public channels
// All conversation channels are now public and use UUID-based identification