<?php

namespace App\Services;
use App\Models\Advertisement;

class PriceEvaluationService {
    public function evaluate ( Advertisement $ad ): string {
        if (!$ad->final_price || !$ad->brand_id || !$ad->vehicle_model_id) {
            return 'ND'; // Missing required data
        }

        // Try strict matching first (same brand, model, year, mileage ±20k)
        $marketPrice = $this->calculateMarketPrice($ad, strict: true);
        
        // If strict matching fails, try broader matching (same brand, model, year, any mileage)
        if (!$marketPrice) {
            $marketPrice = $this->calculateMarketPrice($ad, strict: false);
        }
        
        // If still no data, try even broader (same brand, model, any year, any mileage)
        if (!$marketPrice && $ad->brand_id && $ad->vehicle_model_id) {
            $marketPrice = $this->calculateMarketPriceByBrandModel($ad);
        }
        
        // If still no data, try same brand only (very broad)
        if (!$marketPrice && $ad->brand_id) {
            $marketPrice = $this->calculateMarketPriceByBrand($ad);
        }
        
        if ( !$marketPrice ) {
            return 'ND'; // Not enough data even with broad matching
        }
        
        $finalPrice = (float)$ad->final_price;
        $diff = $finalPrice - $marketPrice;
        $percent = ( $diff / $marketPrice ) * 100;
        
        if ( $percent <= -10 ) {
            return 'Super Price'; // 10%+ cheaper
        }
        elseif ( $percent <= -5 ) {
            return 'Great Price'; // 5–10% cheaper
        }
        elseif ( abs($percent) <= 5 ) {
            return 'Good Price'; // around market
        }

        return 'ND'; // too high or rare
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
        
        // Only return if we have at least 3 similar ads for a reliable average
        $count = $query->count();
        if ($count >= 3 && $avg) {
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
        
        // Need at least 5 ads for broad matching to be reliable
        if ($count >= 5 && $avg) {
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
        
        // Need at least 10 ads for brand-only matching to be reliable
        if ($count >= 10 && $avg) {
            return (float) $avg;
        }
        
        return null;
    }
}
