<?php

namespace App\Providers;

use App\Services\AI\AIServiceInterface;
use App\Services\AI\SimpleAIService;
use Illuminate\Support\ServiceProvider;

class AIServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AIServiceInterface::class, SimpleAIService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
