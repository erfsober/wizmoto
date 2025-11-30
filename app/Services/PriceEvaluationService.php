<?php

namespace App\Services;
use App\Models\Advertisement;

class PriceEvaluationService {
    public function evaluate ( Advertisement $ad ): string {
        if (!$ad->final_price || !$ad->brand_id || !$ad->vehicle_model_id) {
            return 'ND'; // Missing required data
        }

        $matchingLevel = 'none'; // Track which matching level we used
        $marketPrice = null;

        // Try strict matching first (same brand, model, year, mileage ±20k)
        $marketPrice = $this->calculateMarketPrice($ad, strict: true);
        if ($marketPrice) {
            $matchingLevel = 'strict';
        }
        
        // If strict matching fails, try broader matching (same brand, model, year, any mileage)
        if (!$marketPrice) {
            $marketPrice = $this->calculateMarketPrice($ad, strict: false);
            if ($marketPrice) {
                $matchingLevel = 'relaxed';
            }
        }
        
        // If still no data, try even broader (same brand, model, any year, any mileage)
        if (!$marketPrice && $ad->brand_id && $ad->vehicle_model_id) {
            $marketPrice = $this->calculateMarketPriceByBrandModel($ad);
            if ($marketPrice) {
                $matchingLevel = 'brand_model';
            }
        }
        
        // If still no data, try same brand only (very broad)
        if (!$marketPrice && $ad->brand_id) {
            $marketPrice = $this->calculateMarketPriceByBrand($ad);
            if ($marketPrice) {
                $matchingLevel = 'brand_only';
            }
        }
        
        if ( !$marketPrice ) {
            return 'ND'; // Not enough data even with broad matching
        }
        
        $finalPrice = (float)$ad->final_price;
        $diff = $finalPrice - $marketPrice;
        $percent = ( $diff / $marketPrice ) * 100;
        
        // Adjust thresholds based on matching accuracy
        // For stricter matches, use precise thresholds
        // For broader matches, be more lenient (default to "Good Price")
        
        if ( $percent <= -15 ) {
            return 'Super Price'; // 15%+ cheaper - exceptional deal
        }
        elseif ( $percent <= -8 ) {
            return 'Super Price'; // 8-15% cheaper - great deal
        }
        elseif ( $percent <= -5 ) {
            return 'Great Price'; // 5-8% cheaper
        }
        elseif ( $percent <= -3 ) {
            return 'Great Price'; // 3-5% cheaper
        }
        elseif ( $percent <= 3 ) {
            return 'Good Price'; // within 3% of market - fair price
        }
        elseif ( $percent <= 8 ) {
            return 'Good Price'; // 3-8% above market - still reasonable
        }
        elseif ( $percent <= 15 ) {
            return 'Good Price'; // 8-15% above - slightly above market
        }

        // For very broad matches (brand-only), always default to "Good Price"
        // to avoid penalizing ads when we don't have accurate market data
        if ($matchingLevel === 'brand_only') {
            return 'Good Price';
        }

        // Only return ND if price is way above market (15%+) AND we have accurate matching data
        return 'ND'; // 15%+ above market with accurate data
    }

    /**
     * Calculate market price with strict or relaxed matching
     */
    private function calculateMarketPrice ( Advertisement $ad, bool $strict = true ): ?float {
        $query = Advertisement::query()
                            ->where('brand_id', $ad->brand_id)
                            ->where('vehicle_model_id', $ad->vehicle_model_id)
                            ->whereNotNull('final_price')
                            ->where('id', '!=', $ad->id); // Exclude the current ad
                            
        if ($strict && $ad->registration_year) {
            $query->where('registration_year', $ad->registration_year);
        }
        
        if ($strict && $ad->mileage) {
            $query->whereBetween('mileage', [
                max(0, $ad->mileage - 20000),
                $ad->mileage + 20000,
            ]);
        }
        
        $avg = $query->avg('final_price');
        
        // Lower threshold to allow more evaluations - need at least 2 similar ads
        $count = $query->count();
        if ($count >= 2 && $avg) {
            return (float) $avg;
        }
        
        return null;
    }

    /**
     * Calculate market price by brand and model only (any year, any mileage)
     */
    private function calculateMarketPriceByBrandModel ( Advertisement $ad ): ?float {
        $avg = Advertisement::query()
                            ->where('brand_id', $ad->brand_id)
                            ->where('vehicle_model_id', $ad->vehicle_model_id)
                            ->whereNotNull('final_price')
                            ->where('id', '!=', $ad->id)
                            ->avg('final_price');
        
        $count = Advertisement::query()
                            ->where('brand_id', $ad->brand_id)
                            ->where('vehicle_model_id', $ad->vehicle_model_id)
                            ->whereNotNull('final_price')
                            ->where('id', '!=', $ad->id)
                            ->count();
        
        // Lower threshold to allow more evaluations - need at least 3 ads for brand+model matching
        if ($count >= 3 && $avg) {
            return (float) $avg;
        }
        
        return null;
    }

    /**
     * Calculate market price by brand only (very broad, last resort)
     */
    private function calculateMarketPriceByBrand ( Advertisement $ad ): ?float {
        $avg = Advertisement::query()
                            ->where('brand_id', $ad->brand_id)
                            ->whereNotNull('final_price')
                            ->where('id', '!=', $ad->id)
                            ->avg('final_price');
        
        $count = Advertisement::query()
                            ->where('brand_id', $ad->brand_id)
                            ->whereNotNull('final_price')
                            ->where('id', '!=', $ad->id)
                            ->count();
        
        // Lower threshold - need at least 5 ads for brand-only matching
        if ($count >= 5 && $avg) {
            return (float) $avg;
        }
        
        return null;
    }
}
