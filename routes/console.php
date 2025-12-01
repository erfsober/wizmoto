<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('ads:recalculate-price-evaluations')->dailyAt('3:00')->withoutOverlapping();

// Autoscout24 scraper - run at 3 AM daily to extract 50 ads
Schedule::command('import:autoscout24-images --limit=20 --scheduled')->everyFifteenMinutes()->withoutOverlapping();

// Geocode advertisements every 5 minutes
Schedule::command('advertisements:geocode --scheduled --limit=20')->everyFiveMinutes()->withoutOverlapping();

// Cleanup old conversations and messages - run at 4 AM daily
Schedule::command('cleanup:provider-conversations')->dailyAt('4:00')->withoutOverlapping();
Schedule::command('cleanup:support-messages')->dailyAt('4:00')->withoutOverlapping();

// Translate missing Italian columns - run at 5 AM daily
Schedule::command('translations:fill-italian')->dailyAt('5:00')->withoutOverlapping();
Schedule::command('colors:update-hex-codes')->dailyAt('5:00')->withoutOverlapping();