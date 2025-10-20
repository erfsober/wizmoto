<?php

namespace App\Services\AI;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AdvancedAIService implements AIServiceInterface
{
    protected $apiKey;
    protected $provider;
    protected $model;

    public function __construct()
    {
        $this->provider = config('ai.provider', 'openai');
        $this->apiKey = config('ai.api_key');
        $this->model = config('ai.model', 'gpt-3.5-turbo');
    }

    public function generateResponse(string $prompt): ?string
    {
        if (!$this->isAvailable()) {
            return $this->getFallbackResponse($prompt);
        }

        try {
            $response = null;
            switch ($this->provider) {
                case 'openai':
                    $response = $this->callOpenAI($prompt);
                    break;
                case 'huggingface':
                    $response = $this->callHuggingFace($prompt);
                    break;
                case 'anthropic':
                    $response = $this->callAnthropic($prompt);
                    break;
                default:
                    return $this->getFallbackResponse($prompt);
            }
            
            // If external API returns null or empty, use fallback
            if (empty($response)) {
                Log::info('External AI API returned empty response, using fallback');
                return $this->getFallbackResponse($prompt);
            }
            
            return $response;
        } catch (\Exception $e) {
            Log::error('AI Service Error: ' . $e->getMessage());
            return $this->getFallbackResponse($prompt);
        }
    }

    public function isAvailable(): bool
    {
        return !empty($this->apiKey) && in_array($this->provider, ['openai', 'huggingface', 'anthropic']);
    }

    /**
     * Call OpenAI Responses API (new endpoint)
     */
    private function callOpenAI(string $prompt): ?string
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(30)->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are Super AI, an advanced virtual assistant for Wizmoto, a vehicle marketplace platform. Be helpful, friendly, and provide specific advice about vehicles, pricing, and marketplace features.'],
                    ['role' => 'user', 'content' => $prompt]
                ],
                'max_tokens' => 500,
                'temperature' => 0.7
            ]);

            Log::info('OpenAI Responses API Response', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['choices'][0]['message']['content'] ?? null;
            } else {
                Log::error('OpenAI Responses API Error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
            }

            return null;
        } catch (\Exception $e) {
            Log::error('OpenAI Responses API Exception', [
                'message' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Call Hugging Face API with a valid model
     */
    private function callHuggingFace(string $prompt): ?string
    {
        try {
            // Use a valid Hugging Face conversational model that's available for free
            $modelUrl = 'https://api-inference.huggingface.co/models/facebook/blenderbot-400M-distill';
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(30)->post($modelUrl, [
                'inputs' => $prompt,
                'parameters' => [
                    'max_length' => 100,
                    'temperature' => 0.7,
                    'do_sample' => true,
                    'return_full_text' => false,
                ]
            ]);

            Log::info('Hugging Face API Response', [
                'status' => $response->status(),
                'body' => $response->body(),
                'model_url' => $modelUrl
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Handle different response formats
                if (isset($data[0]['generated_text'])) {
                    return $data[0]['generated_text'];
                } elseif (isset($data['generated_text'])) {
                    return $data['generated_text'];
                } elseif (is_string($data)) {
                    return $data;
                }
            } else {
                Log::error('Hugging Face API Error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'model_url' => $modelUrl
                ]);
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Hugging Face API Exception', [
                'message' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Call Anthropic Claude API
     */
    private function callAnthropic(string $prompt): ?string
    {
        $response = Http::withHeaders([
            'x-api-key' => $this->apiKey,
            'Content-Type' => 'application/json',
            'anthropic-version' => config('ai.anthropic.version', '2023-06-01'),
        ])->timeout(30)->post('https://api.anthropic.com/v1/messages', [
            'model' => $this->model,
            'max_tokens' => config('ai.anthropic.max_tokens', 300),
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $prompt
                ]
            ]
        ]);

        if ($response->successful()) {
            $data = $response->json();
            return $data['content'][0]['text'] ?? null;
        }

        return null;
    }

    /**
     * Get dynamic fallback response when AI service fails
     */
    private function getFallbackResponse(string $prompt): string
    {
        $userQuestion = $this->extractUserQuestion($prompt);
        $question = strtolower(trim($userQuestion));
        
        // Generate more dynamic responses based on context
        $greetings = ['Hello!', 'Hi there!', 'Hey!', 'Greetings!'];
        $greeting = $greetings[array_rand($greetings)];
        
        // Dynamic responses that feel more natural
        if ($this->containsAny($question, ['hello', 'hi', 'hey', 'greetings'])) {
            $responses = [
                "{$greeting} I'm Super AI, your virtual assistant for Wizmoto! I'm here to help you find vehicles, analyze prices, and answer any questions about our platform. What can I help you with today?",
                "{$greeting} Welcome to Wizmoto! I'm your AI assistant and I can help you with vehicle searches, price analysis, seller contacts, and more. How can I assist you?",
                "{$greeting} I'm Super AI, ready to help you navigate Wizmoto! Whether you're looking for vehicles, need price insights, or want to contact sellers, I'm here to help. What do you need?"
            ];
            return $responses[array_rand($responses)];
        }

        if ($this->containsAny($question, ['vehicle', 'car', 'motorcycle', 'bike', 'auto', 'find', 'search', 'available'])) {
            $responses = [
                "Great! I can help you find the perfect vehicle on Wizmoto. We have a wide selection of cars, motorcycles, and other vehicles. Try using our search filters by brand, model, price range, year, or mileage. What type of vehicle interests you?",
                "I'd love to help you find a vehicle! Browse our inventory or use our advanced search filters. You can search by brand, model, price, year, fuel type, and more. What are you looking for specifically?",
                "Perfect! Let's find you the right vehicle. Use our search filters to narrow down by brand, model, price range, year, mileage, and other criteria. What kind of vehicle are you interested in?"
            ];
            return $responses[array_rand($responses)];
        }

        if ($this->containsAny($question, ['price', 'cost', 'expensive', 'cheap', 'budget', 'evaluation'])) {
            $responses = [
                "Price analysis is crucial when buying a vehicle! Our price evaluation system shows 'Top offer' for great deals, 'Good price' for competitive pricing, and 'Fair price' for market value. I can help analyze specific vehicle prices too!",
                "Understanding vehicle pricing is important! Our system evaluates prices as 'Top offer' (below market), 'Good price' (competitive), or 'Fair price' (market value). Would you like me to analyze a specific vehicle's price?",
                "Great question about pricing! Our price evaluation helps you understand if a vehicle is priced competitively. 'Top offer' means a great deal, 'Good price' is competitive, and 'Fair price' reflects market value. Need help analyzing a specific vehicle?"
            ];
            return $responses[array_rand($responses)];
        }

        if ($this->containsAny($question, ['contact', 'seller', 'call', 'phone', 'message'])) {
            $responses = [
                "You can contact sellers in multiple ways: call them directly using the phone number on the vehicle page, use our contact form, or send a message through our platform. I can help you find the contact information!",
                "Contacting sellers is easy on Wizmoto! You can call them directly, use our contact form, or send messages through our platform. The seller's contact details are displayed on each vehicle page. Need help finding contact info?",
                "Great! You can reach sellers by calling the phone number on the vehicle page, using our contact form, or messaging through our platform. All contact information is clearly displayed. How can I help you connect with a seller?"
            ];
            return $responses[array_rand($responses)];
        }

        if ($this->containsAny($question, ['sell', 'selling', 'advertise', 'list'])) {
            $responses = [
                "Selling your vehicle on Wizmoto is straightforward! Create an account, add your vehicle details, upload high-quality photos, and set your price. Our platform connects you with potential buyers. Would you like help with the selling process?",
                "To sell your vehicle, simply create an account, provide vehicle details, upload photos, and set your price. Wizmoto makes it easy to reach interested buyers. Need assistance with listing your vehicle?",
                "Selling on Wizmoto is simple! Just create an account, add your vehicle information, upload photos, and set your price. Our platform helps you connect with potential buyers. How can I help you get started?"
            ];
            return $responses[array_rand($responses)];
        }

        if ($this->containsAny($question, ['recommend', 'suggestion', 'best', 'good'])) {
            $responses = [
                "I can provide personalized vehicle recommendations! Tell me about your budget, preferred brand, fuel type, or body style, and I'll suggest the best options for you. What are your preferences?",
                "Great! I'd love to recommend vehicles for you. Share your budget, preferred brand, fuel type, or body style, and I'll find the perfect matches. What are you looking for?",
                "I'm here to help with recommendations! Let me know your budget, preferred brand, fuel type, or body style, and I'll suggest the best vehicles for your needs. What are your requirements?"
            ];
            return $responses[array_rand($responses)];
        }

        // More dynamic general responses
        $generalResponses = [
            "I'm Super AI, your virtual assistant for Wizmoto! I can help you find vehicles, understand pricing, contact sellers, or navigate our platform. What would you like to know?",
            "Hello! I'm here to help you with everything on Wizmoto - from finding vehicles to price analysis and seller contacts. How can I assist you today?",
            "Hi! I'm Super AI, ready to help you with vehicle searches, price insights, seller contacts, and more on Wizmoto. What do you need help with?"
        ];
        
        return $generalResponses[array_rand($generalResponses)];
    }

    /**
     * Extract user question from prompt
     */
    private function extractUserQuestion(string $prompt): string
    {
        if (preg_match('/User question:\s*(.+)/i', $prompt, $matches)) {
            return trim($matches[1]);
        }
        $lines = explode("\n", $prompt);
        return trim(end($lines));
    }

    /**
     * Check if string contains any of the given keywords
     */
    private function containsAny(string $text, array $keywords): bool
    {
        foreach ($keywords as $keyword) {
            if (strpos($text, $keyword) !== false) {
                return true;
            }
        }
        return false;
    }
}
