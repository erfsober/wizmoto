<?php

namespace App\Console\Commands;

use App\Models\Advertisement;
use App\Services\GeocodingService;
use Illuminate\Console\Command;

class GeocodeAdvertisements extends Command
{
    protected $signature = 'advertisements:geocode {--limit=20 : Number of advertisements to process per batch} {--force : Force geocoding even if coordinates exist} {--scheduled : Run in scheduled mode (less verbose output)} {--status : Show geocoding status only}';
    protected $description = 'Geocode advertisements that are missing latitude/longitude coordinates';

    public function handle()
    {
        $limit = (int) $this->option('limit');
        $force = $this->option('force');
        $scheduled = $this->option('scheduled');
        $statusOnly = $this->option('status');
        
        // Show status only
        if ($statusOnly) {
            $this->showStatus();
            return;
        }
        
        $query = Advertisement::query();
        
        if (!$force) {
            $query->where(function ($q) {
                $q->whereNull('latitude')
                  ->orWhereNull('longitude');
            });
        }
        
        $total = $query->count();
        
        if ($total === 0) {
            if (!$scheduled) {
                $this->info('No advertisements need geocoding.');
            }
            return;
        }
        
        if (!$scheduled) {
            $this->info("Found {$total} advertisements to geocode.");
        }
        
        $geocodingService = app(GeocodingService::class);
        $processed = 0;
        $successful = 0;
        $failed = 0;
        
        $query->chunk($limit, function ($advertisements) use ($geocodingService, &$processed, &$successful, &$failed, $scheduled) {
            foreach ($advertisements as $advertisement) {
                $processed++;
                
                if (!$scheduled) {
                    $this->line("Processing advertisement #{$advertisement->id} - {$advertisement->city}, {$advertisement->zip_code}");
                }
                
                try {
                    $coordinates = $geocodingService->geocode(
                        $advertisement->city,
                        $advertisement->zip_code,
                        $advertisement->international_prefix
                    );
                    
                    if ($coordinates) {
                        $advertisement->update([
                            'latitude' => $coordinates['latitude'],
                            'longitude' => $coordinates['longitude'],
                        ]);
                        
                        $successful++;
                        if (!$scheduled) {
                            $this->info("  ✓ Geocoded: {$coordinates['latitude']}, {$coordinates['longitude']} (source: {$coordinates['source']})");
                        }
                    } else {
                        $failed++;
                        if (!$scheduled) {
                            $this->error("  ✗ Failed to geocode");
                        }
                    }
                } catch (\Exception $e) {
                    $failed++;
                    if (!$scheduled) {
                        $this->error("  ✗ Error: {$e->getMessage()}");
                    }
                }
                
                // Add a small delay to avoid rate limiting
                usleep(100000); // 0.1 second delay
            }
        });
        
        if (!$scheduled) {
            $this->newLine();
            $this->info("Geocoding completed!");
            $this->info("Processed: {$processed}");
            $this->info("Successful: {$successful}");
            $this->info("Failed: {$failed}");
        } else {
            // Log for scheduled runs
            \Log::info("Scheduled geocoding completed", [
                'processed' => $processed,
                'successful' => $successful,
                'failed' => $failed
            ]);
        }
    }

    /**
     * Show geocoding status
     */
    private function showStatus()
    {
        $total = Advertisement::count();
        $withCoordinates = Advertisement::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->count();
        $withoutCoordinates = $total - $withCoordinates;
        $percentage = $total > 0 ? round(($withCoordinates / $total) * 100, 2) : 0;

        $this->info("Advertisement Geocoding Status");
        $this->info("==============================");
        $this->info("Total Advertisements: {$total}");
        $this->info("With Coordinates: {$withCoordinates}");
        $this->info("Without Coordinates: {$withoutCoordinates}");
        $this->info("Completion: {$percentage}%");

        if ($withoutCoordinates > 0) {
            $this->warn("There are {$withoutCoordinates} advertisements that need geocoding.");
            $this->info("Run: php artisan advertisements:geocode");
        } else {
            $this->info("All advertisements have been geocoded!");
        }

        // Show some examples of missing coordinates
        if ($withoutCoordinates > 0) {
            $this->newLine();
            $this->info("Examples of advertisements without coordinates:");
            
            $examples = Advertisement::whereNull('latitude')
                ->orWhereNull('longitude')
                ->limit(5)
                ->get(['id', 'city', 'zip_code', 'international_prefix']);
            
            foreach ($examples as $ad) {
                $this->line("  #{$ad->id}: {$ad->city}, {$ad->zip_code} ({$ad->international_prefix})");
            }
        }
    }
}
