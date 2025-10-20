<?php

return [
    /*
    |--------------------------------------------------------------------------
    | AI Service Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for AI services used in the
    | application. You can switch between different AI providers and
    | configure their settings.
    |
    */

    'default_service' => env('AI_DEFAULT_SERVICE', 'simple'), // simple, advanced

    'provider' => env('AI_PROVIDER', 'openai'), // openai, huggingface, anthropic

    'api_key' => env('AI_API_KEY'),

    'model' => env('AI_MODEL', 'gpt-3.5-turbo'),

    /*
    |--------------------------------------------------------------------------
    | Provider Specific Settings
    |--------------------------------------------------------------------------
    */

    'openai' => [
        'api_url' => 'https://api.openai.com/v1/chat/completions',
        'default_model' => 'gpt-3.5-turbo',
        'max_tokens' => 300,
        'temperature' => 0.7,
    ],

    'huggingface' => [
        'api_url' => 'https://api-inference.huggingface.co/models',
        'default_model' => 'facebook/blenderbot-400M-distill',
        'max_length' => 100,
        'temperature' => 0.7,
    ],

    'anthropic' => [
        'api_url' => 'https://api.anthropic.com/v1/messages',
        'default_model' => 'claude-3-sonnet-20240229',
        'max_tokens' => 300,
        'version' => '2023-06-01',
    ],

    /*
    |--------------------------------------------------------------------------
    | AI Assistant Settings
    |--------------------------------------------------------------------------
    */

    'assistant' => [
        'system_prompt' => 'You are Super AI, a helpful virtual assistant for Wizmoto, a vehicle marketplace platform. You help users find vehicles, answer questions about the platform, and provide assistance. Be friendly, helpful, and concise. Keep responses under 200 words.',
        'max_response_length' => 200,
        'timeout' => 30,
        'fallback_enabled' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Vehicle-Specific AI Features
    |--------------------------------------------------------------------------
    */

    'vehicle_features' => [
        'recommendations' => true,
        'price_analysis' => true,
        'market_insights' => true,
        'comparison' => true,
        'financing_info' => true,
    ],
];
