<?php

namespace App\Console\Commands;

use App\Models\Advertisement;
use App\Services\PriceEvaluationService;
use Illuminate\Console\Command;

class RecalculatePriceEvaluations extends Command {
    protected $signature   = 'ads:recalculate-price-evaluations';
    protected $description = 'Recalculate price evaluations for all advertisements';

    public function handle ( PriceEvaluationService $service ) {
        $total = Advertisement::whereNotNull('final_price')->count();
        $this->info("Recalculating price evaluations for {$total} advertisements with improved matching criteria...");
        
        $updated = 0;
        $bar = $this->output->createProgressBar($total);
        $bar->start();
        
        Advertisement::whereNotNull('final_price')
            ->chunk(100, function ($ads) use ($service, &$updated, $bar) {
                foreach ($ads as $ad) {
                    $oldEvaluation = $ad->price_evaluation;
                    $newEvaluation = $service->evaluate($ad);
                    
                    if ($oldEvaluation !== $newEvaluation) {
                        $ad->price_evaluation = $newEvaluation;
                        $ad->saveQuietly(); // Use saveQuietly to avoid triggering the booted() method again
                        $updated++;
                    }
                    $bar->advance();
                }
            });
        
        $bar->finish();
        $this->newLine(2);
        $this->info("✅ Price evaluations recalculated!");
        $this->info("   Updated: {$updated} advertisements");
        $this->info("   Unchanged: " . ($total - $updated) . " advertisements");
    }
}
