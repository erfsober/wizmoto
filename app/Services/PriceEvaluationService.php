<?php

namespace App\Services;
use App\Models\Advertisement;

class PriceEvaluationService {
    public function evaluate ( Advertisement $ad ): string {
        $marketPrice = $this->calculateMarketPrice($ad);
        if ( !$marketPrice ) {
            return 'ND'; // Not enough data
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

    private function calculateMarketPrice ( Advertisement $ad ): ?float {
        return Advertisement::query()
                            ->where('brand_id' , $ad->brand_id)
                            ->where('vehicle_model_id' , $ad->vehicle_model_id)
                            ->where('registration_year' , $ad->registration_year)
                            ->whereBetween('mileage' , [
                                max(0 , $ad->mileage - 20000) ,
                                $ad->mileage + 20000 ,
                            ])
                            ->whereNotNull('final_price')
                            ->avg('final_price');
    }
}
