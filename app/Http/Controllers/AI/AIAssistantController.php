<?php

namespace App\Http\Controllers\AI;

use App\Http\Controllers\Controller;
use App\Services\AI\AIServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AIAssistantController extends Controller
{
    protected $aiService;

    public function __construct(AIServiceInterface $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * Handle AI assistant chat requests
     */
    public function chat(Request $request): JsonResponse
    {
        try {
            \Log::info('AI Assistant request received', [
                'message' => $request->input('message'),
                'headers' => $request->headers->all()
            ]);

            $request->validate([
                'message' => 'required|string|max:500'
            ]);

            $message = $request->input('message');
            
            // Get context about the current page/session
            $context = $this->getContext($request);
            
            // Create a more specific prompt for the assistant
            $prompt = $this->createPrompt($message, $context);
            
            $response = $this->aiService->generateResponse($prompt);
            
            \Log::info('AI Assistant response generated', [
                'response' => $response
            ]);
            
            // If AI service fails, provide fallback responses
            if (!$response || empty(trim($response))) {
                $response = $this->getFallbackResponse($message);
            }
            
            return response()->json([
                'response' => $response,
                'success' => true
            ]);
            
        } catch (\Exception $e) {
            \Log::error('AI Assistant Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'response' => $this->getFallbackResponse($request->input('message', '')),
                'success' => false
            ]);
        }
    }

    /**
     * Get context about the current page/session
     */
    private function getContext(Request $request): array
    {
        $context = [
            'platform' => 'Wizmoto',
            'current_url' => $request->header('referer'),
            'user_agent' => $request->userAgent(),
        ];

        // Add page-specific context
        $referer = $request->header('referer');
        if ($referer) {
            if (strpos($referer, '/inventory') !== false) {
                $context['page'] = 'vehicle_listing';
                $context['description'] = 'User is browsing vehicle listings';
            } elseif (strpos($referer, '/advertisements/') !== false) {
                $context['page'] = 'vehicle_detail';
                $context['description'] = 'User is viewing a specific vehicle';
            } elseif (strpos($referer, '/dashboard') !== false) {
                $context['page'] = 'dashboard';
                $context['description'] = 'User is in their dashboard';
            } else {
                $context['page'] = 'homepage';
                $context['description'] = 'User is on the homepage';
            }
        }

        return $context;
    }

    /**
     * Create a specific prompt for the AI assistant
     */
    private function createPrompt(string $message, array $context): string
    {
        $systemPrompt = "You are Super AI, a helpful virtual assistant for Wizmoto, a vehicle marketplace platform. ";
        $systemPrompt .= "You help users find vehicles, answer questions about the platform, and provide assistance. ";
        $systemPrompt .= "Be friendly, helpful, and concise. Keep responses under 200 words. ";
        $systemPrompt .= "If you don't know something specific about Wizmoto, suggest they contact support or browse the platform.\n\n";
        
        $contextInfo = "Current context: " . ($context['description'] ?? 'Unknown page') . "\n";
        $contextInfo .= "Platform: " . $context['platform'] . "\n\n";
        
        $userMessage = "User question: " . $message;
        
        return $systemPrompt . $contextInfo . $userMessage;
    }

    /**
     * Provide fallback responses when AI service is unavailable
     */
    private function getFallbackResponse(string $message): string
    {
        $message = strtolower(trim($message));
        
        // Common question patterns and responses
        $responses = [
            'vehicle' => "I can help you find vehicles! Use our search filters to narrow down by brand, model, price, and more. You can also browse our inventory list to see all available vehicles.",
            'price' => "Our price evaluation system shows you if a vehicle is priced competitively. Look for 'Top offer', 'Good price', 'Fair price' badges next to vehicle prices.",
            'contact' => "To contact a seller, click on any vehicle listing and use the contact form or call the seller directly. Their contact information is displayed on the vehicle page.",
            'sell' => "To sell your vehicle, create an account and go to your dashboard. Click 'Add Vehicle' to list your vehicle with photos and details.",
            'help' => "I'm here to help! You can ask me about finding vehicles, understanding prices, contacting sellers, or selling your own vehicle. What would you like to know?",
            'search' => "Use our advanced search filters to find the perfect vehicle. Filter by brand, model, price range, year, mileage, fuel type, and more!",
            'filter' => "Our filters help you narrow down vehicle options. Try filtering by price range, brand, model, year, or use our price evaluation filter to find great deals.",
            'account' => "Create an account to save your searches, contact sellers, and list your own vehicles. It's free and takes just a few minutes!",
        ];
        
        // Check for keywords in the message
        foreach ($responses as $keyword => $response) {
            if (strpos($message, $keyword) !== false) {
                return $response;
            }
        }
        
        // Default response
        return "I'm here to help you with Wizmoto! You can ask me about finding vehicles, understanding our price evaluation system, contacting sellers, or selling your own vehicle. What would you like to know?";
    }
}
