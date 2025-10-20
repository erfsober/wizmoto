<?php

namespace App\Services\AI;

interface AIServiceInterface
{
    /**
     * Generate a response to a given prompt
     *
     * @param string $prompt
     * @return string|null
     */
    public function generateResponse(string $prompt): ?string;

    /**
     * Check if the AI service is available
     *
     * @return bool
     */
    public function isAvailable(): bool;
}
