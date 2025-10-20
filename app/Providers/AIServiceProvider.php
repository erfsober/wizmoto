<?php

namespace App\Providers;

use App\Services\AI\AIServiceInterface;
use App\Services\AI\SimpleAIService;
use App\Services\AI\AdvancedAIService;
use Illuminate\Support\ServiceProvider;

class AIServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Bind the interface to the appropriate implementation
        $defaultService = config('ai.default_service', 'simple');
        
        if ($defaultService === 'advanced') {
            $this->app->bind(AIServiceInterface::class, AdvancedAIService::class);
        } else {
            $this->app->bind(AIServiceInterface::class, SimpleAIService::class);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
