<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('ads:recalculate-price-evaluations')->dailyAt('3:00');

// Autoscout24 scraper - run at 3 AM daily to extract 50 ads
Schedule::command('import:autoscout24-images --limit=50')->dailyAt('3:00');

// Geocode advertisements every 5 minutes
Schedule::command('advertisements:geocode --scheduled --limit=20')->everyFiveMinutes();

// Cleanup old conversations and messages - run at 4 AM daily
Schedule::command('cleanup:provider-conversations')->dailyAt('4:00');
Schedule::command('cleanup:support-messages')->dailyAt('4:00');
