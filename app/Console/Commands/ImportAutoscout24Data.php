<?php

namespace App\Console\Commands;

use App\Services\Autoscout24ScraperService;
use App\Models\Advertisement;
use App\Models\Brand;
use App\Models\VehicleModel;
use App\Models\Provider;
use App\Models\AdvertisementType;
use App\Models\FuelType;
use App\Models\VehicleBody;
use App\Models\VehicleColor;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportAutoscout24Data extends Command
{
    protected $signature = 'import:autoscout24-data {--limit=2 : Number of ads to import} {--dry-run : Show what would be imported without saving}';
    protected $description = 'Import moto bike advertisements from Autoscout24 to the database with proper relationships and images';

    public function handle()
    {
        $limit = (int) $this->option('limit');
        $dryRun = $this->option('dry-run');
        
        $this->info("Starting Autoscout24 data import...");
        $this->info("Limit: {$limit} ads");
        $this->info("Mode: " . ($dryRun ? 'DRY RUN (no data will be saved)' : 'LIVE IMPORT'));
        
        try {
            $scraperService = app(Autoscout24ScraperService::class);
            
            // Scrape ads from Autoscout24
            $ads = $scraperService->scrapeMotoBikes($limit);
            
            if (empty($ads)) {
                $this->warn('No ads found or scraped from Autoscout24');
                return;
            }
            
            $this->info("Found " . count($ads) . " ads to import:");
            
            $importedCount = 0;
            $skippedCount = 0;
            $errorCount = 0;
            
            foreach ($ads as $index => $adData) {
                $this->line("Processing ad #" . ($index + 1) . ": {$adData['title']}");
                
                try {
                    if ($dryRun) {
                        $this->showDryRunData($adData);
                        $importedCount++;
                    } else {
                        $result = $this->importAdvertisement($adData);
                        if ($result['success']) {
                            $this->info("  ✓ Imported successfully (ID: {$result['id']})");
                            $importedCount++;
                        } else {
                            $this->warn("  ⚠ Skipped: {$result['reason']}");
                            $skippedCount++;
                        }
                    }
                } catch (\Exception $e) {
                    $this->error("  ✗ Error: {$e->getMessage()}");
                    $errorCount++;
                    Log::error('Error importing advertisement', [
                        'ad_data' => $adData,
                        'error' => $e->getMessage()
                    ]);
                }
                
                $this->newLine();
            }
            
            $this->info("Import completed!");
            $this->info("Imported: {$importedCount}");
            $this->info("Skipped: {$skippedCount}");
            $this->info("Errors: {$errorCount}");
            
        } catch (\Exception $e) {
            $this->error("Error during import: " . $e->getMessage());
            Log::error('Error during Autoscout24 import', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
    
    /**
     * Show dry run data without importing
     */
    private function showDryRunData($adData)
    {
        $this->line("  Title: " . ($adData['title'] ?? 'N/A'));
        $this->line("  Price: €" . ($adData['final_price'] ?? 'N/A'));
        $this->line("  Brand: " . ($adData['brand'] ?? 'N/A'));
        $this->line("  Model: " . ($adData['model'] ?? 'N/A'));
        $this->line("  Year: " . ($adData['registration_year'] ?? 'N/A'));
        $this->line("  Mileage: " . ($adData['mileage'] ?? 'N/A') . " km");
        $this->line("  Dealer: " . ($adData['dealer_name'] ?? 'N/A'));
        $this->line("  Images: " . count($adData['gallery_images'] ?? []) . " images");
        $this->line("  Service History: " . (($adData['service_history_available'] ?? false) ? 'Yes' : 'No'));
        $this->line("  Warranty: " . (($adData['warranty_available'] ?? false) ? 'Yes' : 'No'));
    }
    
    /**
     * Import advertisement with all relationships
     */
    private function importAdvertisement($adData)
    {
        try {
            // Check if advertisement already exists
            $existingAd = Advertisement::where('source_url', $adData['source_url'])->first();
            
            if ($existingAd) {
                return [
                    'success' => false,
                    'reason' => 'Advertisement already exists'
                ];
            }
            
            // Get or create provider
            $provider = $this->getOrCreateProvider($adData);
            
            // Get or create advertisement type
            $advertisementType = $this->getOrCreateAdvertisementType();
            
            // Get or create brand
            $brand = $this->getOrCreateBrand($adData['brand'] ?? 'Unknown');
            
            // Get or create vehicle model
            $vehicleModel = $this->getOrCreateVehicleModel($adData['model'] ?? 'Unknown', $brand->id);
            
            // Get or create fuel type
            $fuelType = $this->getOrCreateFuelType($adData['fuel_type'] ?? 'gasoline');
            
            // Prepare advertisement data
            $advertisementData = [
                'provider_id' => $provider->id,
                'advertisement_type_id' => $advertisementType->id,
                'brand_id' => $brand->id,
                'vehicle_model_id' => $vehicleModel->id,
                'fuel_type_id' => $fuelType->id,
                'description' => $adData['description'] ?? '',
                'final_price' => $adData['final_price'] ?? 0,
                'registration_year' => $adData['registration_year'] ?? null,
                'mileage' => $adData['mileage'] ?? null,
                'city' => $adData['city'] ?? $adData['dealer_location'] ?? 'Italy',
                'motor_power_kw' => $adData['motor_power_kw'] ?? null,
                'motor_power_cv' => $adData['motor_power_cv'] ?? null,
                'motor_displacement' => $adData['motor_displacement'] ?? null,
                'motor_cylinders' => $adData['motor_cylinders'] ?? null,
                'motor_change' => $adData['motor_change'] ?? 'manual',
                'seat_height_mm' => $adData['seat_height_mm'] ?? null,
                'tank_capacity_liters' => $adData['tank_capacity_liters'] ?? null,
                'motor_empty_weight' => $adData['motor_empty_weight'] ?? null,
                'top_speed_kmh' => $adData['top_speed_kmh'] ?? null,
                'torque_nm' => $adData['torque_nm'] ?? null,
                'drive_type' => $adData['drive_type'] ?? 'chain',
                'previous_owners' => $adData['previous_owners'] ?? null,
                'service_history_available' => $adData['service_history_available'] ?? false,
                'warranty_available' => $adData['warranty_available'] ?? false,
                'financing_available' => $adData['financing_available'] ?? false,
                'trade_in_possible' => $adData['trade_in_possible'] ?? false,
                'available_immediately' => $adData['available_immediately'] ?? true,
                'price_negotiable' => $adData['price_negotiable'] ?? false,
                'seller_type' => $adData['seller_type'] ?? 'private',
                'emissions_class' => $adData['emissions_class'] ?? null,
                'co2_emissions' => $adData['co2_emissions'] ?? null,
                'combined_fuel_consumption' => $adData['combined_fuel_consumption'] ?? null,
                'source_url' => $adData['source_url'] ?? null,
                'is_verified' => true, // Scraper ads are automatically verified
            ];
            
            // Create advertisement
            $advertisement = Advertisement::create($advertisementData);
            
            // Import images (1-5 images)
            $this->importImages($advertisement, $adData);
            
            return [
                'success' => true,
                'id' => $advertisement->id
            ];
            
        } catch (\Exception $e) {
            Log::error('Error importing advertisement', [
                'ad_data' => $adData,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'reason' => $e->getMessage()
            ];
        }
    }
    
    /**
     * Get or create provider
     */
    private function getOrCreateProvider($adData)
    {
        $dealerName = $adData['dealer_name'] ?? 'Autoscout24 Dealer';
        $dealerLocation = $adData['dealer_location'] ?? 'Italy';
        
        // Try to find existing provider by name
        $provider = Provider::where('first_name', 'like', "%{$dealerName}%")
            ->orWhere('last_name', 'like', "%{$dealerName}%")
            ->first();
        
        if (!$provider) {
            $provider = Provider::create([
                'first_name' => $dealerName,
                'last_name' => 'Dealer',
                'email' => Str::slug($dealerName) . '@autoscout24.com',
                'password' => bcrypt('autoscout24dealer'),
                'email_verified_at' => now(),
            ]);
        }
        
        return $provider;
    }
    
    /**
     * Get or create advertisement type
     */
    private function getOrCreateAdvertisementType()
    {
        $type = AdvertisementType::where('title', 'Motorcycle')->first();
        
        if (!$type) {
            $type = AdvertisementType::create([
                'title' => 'Motorcycle',
            ]);
        }
        
        return $type;
    }
    
    /**
     * Get or create brand
     */
    private function getOrCreateBrand($brandName)
    {
        $brand = Brand::where('name', $brandName)->first();
        
        if (!$brand) {
            $brand = Brand::create([
                'name' => $brandName,
            ]);
        }
        
        return $brand;
    }
    
    /**
     * Get or create vehicle model
     */
    private function getOrCreateVehicleModel($modelName, $brandId)
    {
        $model = VehicleModel::where('name', $modelName)
            ->where('brand_id', $brandId)
            ->first();
        
        if (!$model) {
            $model = VehicleModel::create([
                'name' => $modelName,
                'brand_id' => $brandId,
            ]);
        }
        
        return $model;
    }
    
    /**
     * Get or create fuel type
     */
    private function getOrCreateFuelType($fuelTypeName)
    {
        $fuelType = FuelType::where('name', $fuelTypeName)->first();
        
        if (!$fuelType) {
            $fuelType = FuelType::create([
                'name' => $fuelTypeName,
            ]);
        }
        
        return $fuelType;
    }
    
    /**
     * Import images (1-5 images per ad)
     */
    private function importImages($advertisement, $adData)
    {
        $galleryImages = $adData['gallery_images'] ?? [];
        
        if (empty($galleryImages)) {
            // Create a placeholder image if no images available
            $this->createPlaceholderImage($advertisement);
            return;
        }
        
        // Limit to maximum 5 images
        $imagesToImport = array_slice($galleryImages, 0, 5);
        
        foreach ($imagesToImport as $index => $imageData) {
            try {
                $this->importSingleImage($advertisement, $imageData, $index);
            } catch (\Exception $e) {
                Log::warning('Failed to import image', [
                    'advertisement_id' => $advertisement->id,
                    'image_url' => $imageData['url'] ?? 'N/A',
                    'error' => $e->getMessage()
                ]);
            }
        }
        
        // Ensure at least one image is imported
        if ($advertisement->getMedia('covers')->count() === 0) {
            $this->createPlaceholderImage($advertisement);
        }
    }
    
    /**
     * Import a single image
     */
    private function importSingleImage($advertisement, $imageData, $index)
    {
        $imageUrl = $imageData['url'] ?? '';
        $altText = $imageData['alt'] ?? 'Vehicle image';
        
        if (empty($imageUrl)) {
            return;
        }
        
        try {
            // Download image
            $response = Http::timeout(30)->get($imageUrl);
            
            if (!$response->successful()) {
                throw new \Exception("Failed to download image: HTTP {$response->status()}");
            }
            
            // Get file extension
            $extension = $this->getImageExtension($imageUrl, $response->header('content-type'));
            
            // Generate filename
            $filename = 'autoscout24-' . $advertisement->id . '-' . ($index + 1) . '.' . $extension;
            
            // Store image
            $advertisement->addMediaFromString($response->body())
                ->usingFileName($filename)
                ->usingName($altText)
                ->toMediaCollection('covers');
                
        } catch (\Exception $e) {
            Log::warning('Failed to import image', [
                'advertisement_id' => $advertisement->id,
                'image_url' => $imageUrl,
                'error' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * Create placeholder image
     */
    private function createPlaceholderImage($advertisement)
    {
        try {
            // Create a simple placeholder image
            $placeholderSvg = $this->generatePlaceholderSvg($advertisement);
            
            $advertisement->addMediaFromString($placeholderSvg)
                ->usingFileName('placeholder-' . $advertisement->id . '.svg')
                ->usingName('Placeholder image')
                ->toMediaCollection('covers');
                
        } catch (\Exception $e) {
            Log::error('Failed to create placeholder image', [
                'advertisement_id' => $advertisement->id,
                'error' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * Generate placeholder SVG
     */
    private function generatePlaceholderSvg($advertisement)
    {
        $title = $advertisement->title ?? 'Motorcycle';
        $brand = $advertisement->brand->name ?? 'Unknown';
        $model = $advertisement->vehicleModel->name ?? 'Model';
        
        return '<?xml version="1.0" encoding="UTF-8"?>
<svg width="400" height="300" xmlns="http://www.w3.org/2000/svg">
  <rect width="400" height="300" fill="#f0f0f0"/>
  <rect x="50" y="50" width="300" height="200" fill="#e0e0e0" stroke="#ccc" stroke-width="2"/>
  <text x="200" y="120" text-anchor="middle" font-family="Arial, sans-serif" font-size="18" fill="#666">
    ' . htmlspecialchars($brand) . '
  </text>
  <text x="200" y="150" text-anchor="middle" font-family="Arial, sans-serif" font-size="14" fill="#888">
    ' . htmlspecialchars($model) . '
  </text>
  <text x="200" y="180" text-anchor="middle" font-family="Arial, sans-serif" font-size="12" fill="#999">
    Image not available
  </text>
</svg>';
    }
    
    /**
     * Get image extension from URL or content type
     */
    private function getImageExtension($url, $contentType = null)
    {
        // Try to get extension from URL
        $pathInfo = pathinfo(parse_url($url, PHP_URL_PATH));
        if (isset($pathInfo['extension'])) {
            return strtolower($pathInfo['extension']);
        }
        
        // Try to get extension from content type
        if ($contentType) {
            $mimeToExt = [
                'image/jpeg' => 'jpg',
                'image/jpg' => 'jpg',
                'image/png' => 'png',
                'image/gif' => 'gif',
                'image/webp' => 'webp',
                'image/svg+xml' => 'svg',
            ];
            
            if (isset($mimeToExt[$contentType])) {
                return $mimeToExt[$contentType];
            }
        }
        
        return 'jpg'; // Default
    }
}
