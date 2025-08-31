<?php

namespace App\Console\Commands;

use App\Models\Advertisement;
use App\Services\PriceEvaluationService;
use Illuminate\Console\Command;

class RecalculatePriceEvaluations extends Command {
    protected $signature   = 'ads:recalculate-price-evaluations';
    protected $description = 'Recalculate price evaluations for all advertisements';

    public function handle ( PriceEvaluationService $service ) {
        $ads = Advertisement::whereNotNull('final_price')
                            ->get();
        foreach ( $ads as $ad ) {
            $ad->price_evaluation = $service->evaluate($ad);
            $ad->saveQuietly();
            $this->line("Ad #{$ad->id} updated → {$ad->price_evaluation}");
        }
        $this->info('All price evaluations recalculated ✅');
    }
}
