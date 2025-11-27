<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;

class OpenAiService
{
    protected string $apiKey;
    protected string $model;
    protected float $temperature = 1.0;
    protected ?string $system_message = null;

    /**
     * Base HTTP client for OpenAI requests.
     */
    protected $base_request;

    public function __construct()
    {
        // Reuse your existing ai.php config if present, otherwise fall back to env.
        $this->apiKey = (string) (config('ai.api_key') ?? env('OPENAI_API_KEY', ''));
        $this->model = (string) (config('ai.model') ?? 'gpt-3.5-turbo');
    }

    public function setTemperature(float $temperature): self
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function setSystemMessage(?string $message): self
    {
        $this->system_message = $message;

        return $this;
    }

    /**
     * Prepare the base HTTP client with auth headers.
     */
    protected function baseOpenAiRequest(): void
    {
        $this->base_request = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type'  => 'application/json',
        ])->timeout(30);
    }


    public function generateResponseWithoutProcess(string $message): string
    {
        if ($this->apiKey === '') {
            throw new Exception('OpenAI API key is not configured.');
        }

        $this->baseOpenAiRequest();

        $messages = [];
        if ($this->system_message !== null) {
            $messages[] = [
                'role'    => 'system',
                'content' => $this->system_message,
            ];
        }

        $messages[] = [
            'role'    => 'user',
            'content' => $message,
        ];

        $payload = [
            'model'       => $this->model,
            'messages'    => $messages,
            'temperature' => $this->temperature,
        ];

        $response = $this->base_request->post('https://api.openai.com/v1/chat/completions', $payload);

        if (! $response->successful()) {
            throw new Exception('OpenAI API error: ' . $response->status() . ' ' . $response->body());
        }

        $data = $response->json();
        $responseText = $data['choices'][0]['message']['content'] ?? null;

        if (is_string($responseText) && trim($responseText) !== '') {
            return $responseText;
        }

        throw new Exception('Invalid response from GPT');
    }
}


