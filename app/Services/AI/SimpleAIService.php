<?php

namespace App\Services\AI;

class SimpleAIService implements AIServiceInterface
{
    /**
     * Generate a response to a given prompt
     */
    public function generateResponse(string $prompt): ?string
    {
        // Extract the user's question from the prompt
        $userQuestion = $this->extractUserQuestion($prompt);
        
        // Generate a contextual response
        return $this->generateContextualResponse($userQuestion, $prompt);
    }

    /**
     * Check if the AI service is available
     */
    public function isAvailable(): bool
    {
        return true; // This service is always available
    }

    /**
     * Extract the user's question from the full prompt
     */
    private function extractUserQuestion(string $prompt): string
    {
        // Look for "User question:" in the prompt
        if (preg_match('/User question:\s*(.+)/i', $prompt, $matches)) {
            return trim($matches[1]);
        }
        
        // Fallback: return the last line of the prompt
        $lines = explode("\n", $prompt);
        return trim(end($lines));
    }

    /**
     * Generate a contextual response based on the question
     */
    private function generateContextualResponse(string $question, string $fullPrompt): string
    {
        $question = strtolower(trim($question));
        
        // Vehicle-related responses
        if ($this->containsAny($question, ['vehicle', 'car', 'motorcycle', 'bike', 'auto', 'find', 'search', 'available'])) {
            return $this->getVehicleResponse($question);
        }
        
        // Price-related responses
        if ($this->containsAny($question, ['price', 'cost', 'expensive', 'cheap', 'evaluation', 'worth', 'value'])) {
            return $this->getPriceResponse($question);
        }
        
        // Contact/seller responses
        if ($this->containsAny($question, ['contact', 'seller', 'dealer', 'call', 'phone', 'email', 'message'])) {
            return $this->getContactResponse($question);
        }
        
        // Selling responses
        if ($this->containsAny($question, ['sell', 'selling', 'list', 'advertise', 'post', 'upload'])) {
            return $this->getSellingResponse($question);
        }
        
        // Filter/search responses
        if ($this->containsAny($question, ['filter', 'search', 'brand', 'model', 'year', 'mileage', 'fuel'])) {
            return $this->getFilterResponse($question);
        }
        
        // Account-related responses
        if ($this->containsAny($question, ['account', 'register', 'login', 'sign up', 'profile', 'dashboard'])) {
            return $this->getAccountResponse($question);
        }
        
        // General help responses
        if ($this->containsAny($question, ['help', 'how', 'what', 'where', 'when', 'why'])) {
            return $this->getHelpResponse($question);
        }
        
        // Default response
        return $this->getDefaultResponse($question);
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

    /**
     * Get vehicle-related response
     */
    private function getVehicleResponse(string $question): string
    {
        $responses = [
            "Great question! Wizmoto has thousands of vehicles available. You can browse our inventory list or use our advanced search filters to find exactly what you're looking for.",
            "I'd be happy to help you find vehicles! Use our search filters to narrow down by brand, model, price range, year, mileage, and more. You can also browse our complete inventory.",
            "We have a wide selection of vehicles on Wizmoto! Try using our filters to find vehicles by brand, model, price, year, or fuel type. What type of vehicle are you looking for?",
            "Finding the perfect vehicle is easy on Wizmoto! Browse our inventory list or use our search filters. You can filter by brand, model, price range, year, mileage, and more."
        ];
        
        return $responses[array_rand($responses)];
    }

    /**
     * Get price-related response
     */
    private function getPriceResponse(string $question): string
    {
        $responses = [
            "Our price evaluation system helps you find great deals! Look for 'Top offer', 'Good price', 'Fair price' badges next to vehicle prices. These show if a vehicle is priced competitively.",
            "Price evaluation on Wizmoto shows you if a vehicle is a good deal. 'Top offer' means it's significantly below market price, 'Good price' means it's competitive, and 'Fair price' means it's around market value.",
            "We help you find the best prices! Our price evaluation system compares each vehicle to market prices. Look for the colored badges next to prices - they'll guide you to great deals.",
            "Understanding vehicle prices is important! Our price evaluation system shows 'Top offer' for vehicles priced significantly below market, 'Good price' for competitive pricing, and 'Fair price' for market value."
        ];
        
        return $responses[array_rand($responses)];
    }

    /**
     * Get contact-related response
     */
    private function getContactResponse(string $question): string
    {
        $responses = [
            "To contact a seller, click on any vehicle listing and scroll down to find their contact information. You can call them directly or use our contact form.",
            "Contacting sellers is easy! Go to any vehicle page and you'll find the seller's phone number and contact form. You can also message them directly through our platform.",
            "You can contact sellers in several ways: call them directly using the phone number on the vehicle page, use our contact form, or send them a message through our platform.",
            "To get in touch with a seller, visit the vehicle listing page where you'll find their contact details. You can call them or use our contact form to send a message."
        ];
        
        return $responses[array_rand($responses)];
    }

    /**
     * Get selling-related response
     */
    private function getSellingResponse(string $question): string
    {
        $responses = [
            "Selling your vehicle on Wizmoto is easy! Create an account, go to your dashboard, and click 'Add Vehicle'. Upload photos and details to list your vehicle.",
            "To sell your vehicle, create a free account and go to your dashboard. Click 'Add Vehicle' to upload photos and details. It's free to list your vehicle!",
            "Ready to sell? Create an account on Wizmoto and go to your dashboard. Click 'Add Vehicle' to upload photos and vehicle details. Listing is completely free!",
            "Selling on Wizmoto is simple and free! Create an account, go to your dashboard, and click 'Add Vehicle' to upload photos and details about your vehicle."
        ];
        
        return $responses[array_rand($responses)];
    }

    /**
     * Get filter-related response
     */
    private function getFilterResponse(string $question): string
    {
        $responses = [
            "Our advanced filters help you find exactly what you want! Filter by brand, model, price range, year, mileage, fuel type, transmission, and more. Try different combinations!",
            "Use our search filters to narrow down your options! You can filter by brand, model, price, year, mileage, fuel type, and even price evaluation to find great deals.",
            "Our filters make finding vehicles easy! Try filtering by brand, model, price range, year, mileage, or use our price evaluation filter to find vehicles with great pricing.",
            "Search smarter with our filters! Filter by brand, model, price range, year, mileage, fuel type, and more. You can even filter by price evaluation to find the best deals."
        ];
        
        return $responses[array_rand($responses)];
    }

    /**
     * Get account-related response
     */
    private function getAccountResponse(string $question): string
    {
        $responses = [
            "Creating an account on Wizmoto is free and takes just a few minutes! With an account, you can save searches, contact sellers, and list your own vehicles.",
            "An account gives you access to many features! Save your searches, contact sellers directly, and list your own vehicles. Registration is completely free.",
            "Sign up for free to unlock all features! Save searches, contact sellers, and list your own vehicles. It only takes a minute to create your account.",
            "Create a free account to get the most out of Wizmoto! Save searches, contact sellers, and list your own vehicles. Registration is quick and easy."
        ];
        
        return $responses[array_rand($responses)];
    }

    /**
     * Get help-related response
     */
    private function getHelpResponse(string $question): string
    {
        $responses = [
            "I'm here to help! You can ask me about finding vehicles, understanding our price evaluation system, contacting sellers, or selling your own vehicle. What would you like to know?",
            "How can I assist you today? I can help with finding vehicles, understanding prices, contacting sellers, selling your vehicle, or navigating our platform. What do you need help with?",
            "I'm your virtual assistant and I'm here to help! Ask me about vehicles, pricing, sellers, or anything about using Wizmoto. What can I help you with?",
            "Need assistance? I can help you find vehicles, understand our features, contact sellers, or sell your own vehicle. What would you like to know about Wizmoto?"
        ];
        
        return $responses[array_rand($responses)];
    }

    /**
     * Get default response
     */
    private function getDefaultResponse(string $question): string
    {
        $responses = [
            "I'm here to help you with Wizmoto! You can ask me about finding vehicles, understanding our price evaluation system, contacting sellers, or selling your own vehicle. What would you like to know?",
            "I'm your virtual assistant for Wizmoto! I can help you find vehicles, understand pricing, contact sellers, or navigate our platform. How can I assist you today?",
            "Welcome to Wizmoto! I'm here to help you find the perfect vehicle, understand our features, or assist with any questions you might have. What can I help you with?",
            "I'm Super AI, your virtual assistant! I can help you with finding vehicles, understanding prices, contacting sellers, or selling your own vehicle. What would you like to know?"
        ];
        
        return $responses[array_rand($responses)];
    }
}
