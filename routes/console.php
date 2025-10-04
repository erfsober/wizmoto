<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('ads:recalculate-price-evaluations')->dailyAt('3:00');

// Geocode advertisements every 5 minutes
Schedule::command('advertisements:geocode --scheduled --limit=20')->everyFiveMinutes();
