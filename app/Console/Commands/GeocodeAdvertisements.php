<?php

namespace App\Console\Commands;

use App\Models\Advertisement;
use App\Services\GeocodingService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use PDOException;

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
        
        try {
            // Show status only
            if ($statusOnly) {
            try {
                $this->showStatus();
                return Command::SUCCESS;
            } catch (QueryException | PDOException $e) {
                $errorMsg = 'Database connection error: ' . $e->getMessage();
                Log::error('GeocodeAdvertisements: ' . $errorMsg, [
                    'exception' => get_class($e),
                    'code' => $e->getCode()
                ]);
                $this->error($errorMsg);
                return Command::FAILURE;
            }
            }
            
            $query = Advertisement::query();
            
            if (!$force) {
                $query->where(function ($q) {
                    $q->whereNull('latitude')
                      ->orWhereNull('longitude');
                });
            }
            
            try {
                $total = $query->count();
            } catch (QueryException | PDOException $e) {
                $errorMsg = 'Database connection error: ' . $e->getMessage();
                Log::error('GeocodeAdvertisements: ' . $errorMsg, [
                    'exception' => get_class($e),
                    'code' => $e->getCode()
                ]);
                
                if (!$scheduled) {
                    $this->error($errorMsg);
                }
                return Command::FAILURE;
            }
            
            if ($total === 0) {
                if (!$scheduled) {
                    $this->info('No advertisements need geocoding.');
                }
                return Command::SUCCESS;
            }
            
            if (!$scheduled) {
                $this->info("Found {$total} advertisements to geocode.");
            }
            
            $geocodingService = app(GeocodingService::class);
            $processed = 0;
            $successful = 0;
            $failed = 0;
            
            try {
                $query->chunk($limit, function ($advertisements) use ($geocodingService, &$processed, &$successful, &$failed, $scheduled) {
                    foreach ($advertisements as $advertisement) {
                        $processed++;
                        
                        if (!$scheduled) {
                            $this->line("Processing advertisement #{$advertisement->id} - {$advertisement->city}, {$advertisement->zip_code}");
                        }
                        
                        try {
                            // Don't pass international_prefix as country - it's a phone prefix, not a country
                            // For Autoscout24 ads, default to Italy. For others, let the service determine.
                            $country = null; // Let GeocodingService use its default (Italy)
                            
                            $coordinates = $geocodingService->geocode(
                                $advertisement->city,
                                $advertisement->zip_code,
                                $country
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
                            Log::warning("GeocodeAdvertisements: Failed to geocode advertisement #{$advertisement->id}", [
                                'error' => $e->getMessage(),
                                'advertisement_id' => $advertisement->id
                            ]);
                            
                            if (!$scheduled) {
                                $this->error("  ✗ Error: {$e->getMessage()}");
                            }
                        }
                        
                        // Add a small delay to avoid rate limiting
                        usleep(100000); // 0.1 second delay
                    }
                });
            } catch (QueryException | PDOException $e) {
                $errorMsg = 'Database error during processing: ' . $e->getMessage();
                Log::error('GeocodeAdvertisements: ' . $errorMsg, [
                    'exception' => get_class($e),
                    'code' => $e->getCode()
                ]);
                
                if (!$scheduled) {
                    $this->error($errorMsg);
                }
                return Command::FAILURE;
            }
            
            if (!$scheduled) {
                $this->newLine();
                $this->info("Geocoding completed!");
                $this->info("Processed: {$processed}");
                $this->info("Successful: {$successful}");
                $this->info("Failed: {$failed}");
            } else {
                // Silent in scheduled mode - only log errors
            }
            
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $errorMsg = 'Unexpected error in GeocodeAdvertisements: ' . $e->getMessage();
            Log::error('GeocodeAdvertisements: ' . $errorMsg, [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            if (!$scheduled) {
                $this->error($errorMsg);
            }
            return Command::FAILURE;
        }
    }

    /**
     * Show geocoding status
     */
    private function showStatus(): void
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
