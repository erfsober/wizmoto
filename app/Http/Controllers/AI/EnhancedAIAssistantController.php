<?php

namespace App\Http\Controllers\AI;

use App\Http\Controllers\Controller;
use App\Services\AI\AIServiceInterface;
use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EnhancedAIAssistantController extends Controller
{
    protected $aiService;

    public function __construct(AIServiceInterface $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * Handle AI assistant chat requests with enhanced features
     */
    public function chat(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'message' => 'required|string|max:500',
                'context' => 'sometimes|array'
            ]);

            $message = $request->input('message');
            $context = $request->input('context', []);
            
            // Get enhanced context about the current page/session
            $enhancedContext = $this->getEnhancedContext($request, $context);
            
            // Create a more specific prompt for the assistant
            $prompt = $this->createEnhancedPrompt($message, $enhancedContext);
            
            $response = $this->aiService->generateResponse($prompt);
            
            // If AI service fails, provide enhanced fallback responses
            if (!$response || empty(trim($response))) {
                $response = $this->getEnhancedFallbackResponse($message, $enhancedContext);
            }
            
            return response()->json([
                'response' => $response,
                'success' => true,
                'context' => $enhancedContext
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Enhanced AI Assistant Error: ' . $e->getMessage());
            
            return response()->json([
                'response' => $this->getEnhancedFallbackResponse($request->input('message', ''), []),
                'success' => false
            ]);
        }
    }

    /**
     * Get vehicle recommendations based on user preferences
     */
    public function getRecommendations(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'preferences' => 'required|array',
                'preferences.budget' => 'sometimes|numeric',
                'preferences.brand' => 'sometimes|string',
                'preferences.fuel_type' => 'sometimes|string',
                'preferences.body_type' => 'sometimes|string',
            ]);

            $preferences = $request->input('preferences');
            
            // Build query based on preferences
            $query = Advertisement::query()->where('status', 'active');
            
            if (isset($preferences['budget'])) {
                $query->where('final_price', '<=', $preferences['budget']);
            }
            
            if (isset($preferences['brand'])) {
                $query->whereHas('brand', function($q) use ($preferences) {
                    $q->where('name', 'like', '%' . $preferences['brand'] . '%');
                });
            }
            
            if (isset($preferences['fuel_type'])) {
                $query->whereHas('fuelType', function($q) use ($preferences) {
                    $q->where('name', 'like', '%' . $preferences['fuel_type'] . '%');
                });
            }
            
            $vehicles = $query->with(['brand', 'vehicleModel', 'fuelType', 'vehicleBody'])
                             ->limit(5)
                             ->get();
            
            // Generate AI-powered recommendation text
            $prompt = "Based on these vehicle preferences: " . json_encode($preferences) . 
                     " and these matching vehicles: " . $vehicles->toJson() . 
                     " provide a personalized recommendation explaining why these vehicles are good matches.";
            
            $recommendation = $this->aiService->generateResponse($prompt);
            
            return response()->json([
                'vehicles' => $vehicles,
                'recommendation' => $recommendation ?: $this->getDefaultRecommendation($vehicles, $preferences),
                'success' => true
            ]);
            
        } catch (\Exception $e) {
            \Log::error('AI Recommendations Error: ' . $e->getMessage());
            
            return response()->json([
                'vehicles' => [],
                'recommendation' => 'Sorry, I couldn\'t generate recommendations right now. Please try again later.',
                'success' => false
            ]);
        }
    }

    /**
     * Get AI-powered price analysis
     */
    public function getPriceAnalysis(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'vehicle_id' => 'required|exists:advertisements,id'
            ]);

            $vehicle = Advertisement::with(['brand', 'vehicleModel', 'fuelType'])
                                  ->find($request->input('vehicle_id'));
            
            if (!$vehicle) {
                return response()->json([
                    'analysis' => 'Vehicle not found.',
                    'success' => false
                ]);
            }

            // Get similar vehicles for comparison
            $similarVehicles = Advertisement::where('brand_id', $vehicle->brand_id)
                                          ->where('vehicle_model_id', $vehicle->vehicle_model_id)
                                          ->where('id', '!=', $vehicle->id)
                                          ->where('status', 'active')
                                          ->limit(10)
                                          ->get();

            // Generate AI price analysis
            $prompt = "Analyze the price of this vehicle: " . $vehicle->toJson() . 
                     " compared to similar vehicles: " . $similarVehicles->toJson() . 
                     " Provide insights about whether this is a good deal, market trends, and pricing recommendations.";
            
            $analysis = $this->aiService->generateResponse($prompt);
            
            return response()->json([
                'vehicle' => $vehicle,
                'similar_vehicles' => $similarVehicles,
                'analysis' => $analysis ?: $this->getDefaultPriceAnalysis($vehicle, $similarVehicles),
                'success' => true
            ]);
            
        } catch (\Exception $e) {
            \Log::error('AI Price Analysis Error: ' . $e->getMessage());
            
            return response()->json([
                'analysis' => 'Sorry, I couldn\'t analyze the price right now. Please try again later.',
                'success' => false
            ]);
        }
    }

    /**
     * Get enhanced context about the current page/session
     */
    private function getEnhancedContext(Request $request, array $additionalContext = []): array
    {
        $context = [
            'platform' => 'Wizmoto',
            'current_url' => $request->header('referer'),
            'user_agent' => $request->userAgent(),
            'timestamp' => now()->toISOString(),
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
                // Extract vehicle ID if possible
                if (preg_match('/\/advertisements\/(\d+)/', $referer, $matches)) {
                    $context['vehicle_id'] = $matches[1];
                }
            } elseif (strpos($referer, '/dashboard') !== false) {
                $context['page'] = 'dashboard';
                $context['description'] = 'User is in their dashboard';
            } else {
                $context['page'] = 'homepage';
                $context['description'] = 'User is on the homepage';
            }
        }

        // Add page data from frontend if available
        if (isset($additionalContext['page_data'])) {
            $context['page_data'] = $additionalContext['page_data'];
            
            // If we have vehicle info, try to get more details from database
            if (!empty($additionalContext['page_data']['vehicle_info']) && isset($context['vehicle_id'])) {
                try {
                    $advertisement = \App\Models\Advertisement::with(['brand', 'vehicleModel', 'fuelType', 'vehicleBody'])
                        ->find($context['vehicle_id']);
                    
                    if ($advertisement) {
                        $context['vehicle_details'] = [
                            'id' => $advertisement->id,
                            'title' => $advertisement->title,
                            'price' => $advertisement->final_price,
                            'year' => $advertisement->year,
                            'mileage' => $advertisement->mileage,
                            'brand' => $advertisement->brand?->name,
                            'model' => $advertisement->vehicleModel?->name,
                            'fuel_type' => $advertisement->fuelType?->name,
                            'body_type' => $advertisement->vehicleBody?->name,
                            'location' => $advertisement->location,
                            'description' => $advertisement->description,
                            'price_evaluation' => $advertisement->price_evaluation
                        ];
                    }
                } catch (\Exception $e) {
                    \Log::warning('Could not fetch vehicle details for AI context: ' . $e->getMessage());
                }
            }
        }

        // Merge additional context
        $context = array_merge($context, $additionalContext);

        return $context;
    }

    /**
     * Create enhanced prompt for AI
     */
    private function createEnhancedPrompt(string $message, array $context): string
    {
        $systemPrompt = "You are Super AI, an advanced virtual assistant for Wizmoto, a vehicle marketplace platform. ";
        $systemPrompt .= "You have access to real-time vehicle data and can provide intelligent recommendations, price analysis, and market insights. ";
        $systemPrompt .= "Be friendly, helpful, and provide specific, actionable advice. Keep responses under 200 words.\n\n";
        
        $contextInfo = "Current context: " . ($context['description'] ?? 'Unknown page') . "\n";
        $contextInfo .= "Platform: " . $context['platform'] . "\n";
        
        // Add vehicle details if available
        if (isset($context['vehicle_details'])) {
            $vehicle = $context['vehicle_details'];
            $contextInfo .= "Current Vehicle Details:\n";
            $contextInfo .= "- Title: " . $vehicle['title'] . "\n";
            $contextInfo .= "- Price: €" . $vehicle['price'] . "\n";
            $contextInfo .= "- Year: " . $vehicle['year'] . "\n";
            $contextInfo .= "- Mileage: " . $vehicle['mileage'] . " km\n";
            $contextInfo .= "- Brand: " . $vehicle['brand'] . "\n";
            $contextInfo .= "- Model: " . $vehicle['model'] . "\n";
            $contextInfo .= "- Fuel Type: " . $vehicle['fuel_type'] . "\n";
            $contextInfo .= "- Body Type: " . $vehicle['body_type'] . "\n";
            $contextInfo .= "- Location: " . $vehicle['location'] . "\n";
            $contextInfo .= "- Price Evaluation: " . $vehicle['price_evaluation'] . "\n";
            $contextInfo .= "- Description: " . substr($vehicle['description'], 0, 200) . "...\n\n";
        }
        
        if (isset($context['vehicle_id'])) {
            $contextInfo .= "User is viewing vehicle ID: " . $context['vehicle_id'] . "\n";
        }
        
        // Add filter information if on inventory page
        if (isset($context['page_data']['filters']) && !empty($context['page_data']['filters'])) {
            $contextInfo .= "Active Filters: " . json_encode($context['page_data']['filters']) . "\n";
        }
        
        $contextInfo .= "\n";
        
        $userMessage = "User question: " . $message;
        
        return $systemPrompt . $contextInfo . $userMessage;
    }

    /**
     * Enhanced fallback responses
     */
    private function getEnhancedFallbackResponse(string $message, array $context): string
    {
        $question = strtolower(trim($message));
        
        // Enhanced responses with more specific information
        $responses = [
            'recommend' => "I can provide personalized vehicle recommendations! Tell me your budget, preferred brand, fuel type, or other preferences, and I'll suggest vehicles that match your needs perfectly.",
            
            'price' => "I can analyze vehicle prices and market trends! Our intelligent price evaluation system shows 'Top offer' for vehicles 10%+ below market, 'Good price' for competitive pricing, and 'Fair price' for market value.",
            
            'compare' => "I can help you compare vehicles! Use our comparison tools to evaluate specifications, prices, and features side by side. I can also provide insights about which vehicle might be better for your needs.",
            
            'market' => "I have access to real-time market data! I can tell you about current trends, popular vehicles, price movements, and what's selling well in your area.",
            
            'finance' => "I can help with financing information! Many sellers offer payment plans, and I can guide you through financing options, loan calculations, and payment strategies.",
        ];
        
        // Check for keywords
        foreach ($responses as $keyword => $response) {
            if (strpos($question, $keyword) !== false) {
                return $response;
            }
        }
        
        return "I'm Super AI, your advanced virtual assistant for Wizmoto! I can help you find vehicles, analyze prices, get recommendations, compare options, and provide market insights. What would you like to know about our vehicle marketplace?";
    }

    /**
     * Default recommendation when AI fails
     */
    private function getDefaultRecommendation($vehicles, $preferences): string
    {
        if ($vehicles->isEmpty()) {
            return "I couldn't find vehicles matching your preferences. Try adjusting your search criteria or contact our support team for assistance.";
        }
        
        return "I found " . $vehicles->count() . " vehicles that match your preferences. These vehicles offer great value and meet your criteria. Click on any vehicle to see more details and contact the seller.";
    }

    /**
     * Default price analysis when AI fails
     */
    private function getDefaultPriceAnalysis($vehicle, $similarVehicles): string
    {
        $avgPrice = $similarVehicles->avg('final_price');
        $priceDiff = $vehicle->final_price - $avgPrice;
        $percentDiff = $avgPrice > 0 ? ($priceDiff / $avgPrice) * 100 : 0;
        
        if ($percentDiff < -10) {
            return "This vehicle is priced significantly below market average (Top offer!). It's a great deal compared to similar vehicles.";
        } elseif ($percentDiff < 0) {
            return "This vehicle is priced competitively below market average. It's a good deal for this type of vehicle.";
        } elseif ($percentDiff < 10) {
            return "This vehicle is priced around market average. It's a fair price for this type of vehicle.";
        } else {
            return "This vehicle is priced above market average. You might want to negotiate or consider similar vehicles at better prices.";
        }
    }
}


