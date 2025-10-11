<?php

namespace App\Console\Commands;

use App\Services\Autoscout24ScraperService;
use App\Models\Advertisement;
use App\Models\Brand;
use App\Models\VehicleModel;
use App\Models\Provider;
use App\Models\AdvertisementType;
use App\Models\FuelType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ImportAutoscout24WithRealImages extends Command
{
    protected $signature = 'import:autoscout24-images {--limit=2 : Number of ads to import} {--dry-run : Show what would be imported without saving}';
    protected $description = 'Import moto bike advertisements with real downloadable images from various sources';

    public function handle()
    {
        $limit = (int) $this->option('limit');
        $dryRun = $this->option('dry-run');
        
        $this->info("Starting Autoscout24 data import with real images...");
        $this->info("Limit: {$limit} ads");
        $this->info("Mode: " . ($dryRun ? 'DRY RUN (no data will be saved)' : 'LIVE IMPORT'));
        
        try {
            $scraperService = app(Autoscout24ScraperService::class);
            
            // Scrape ads from Autoscout24
            $this->info("Scraping ads from Autoscout24...");
            $ads = $scraperService->scrapeMotoBikes($limit);
            
            $this->info("Scraper returned " . count($ads) . " ads");
            
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
                
                // Debug: Show provider data
                $this->line("  Provider Debug:");
                $this->line("    Dealer Name: " . ($adData['dealer_name'] ?? 'NOT SET'));
                $this->line("    Dealer Phone: " . ($adData['dealer_phone'] ?? 'NOT SET'));
                $this->line("    Dealer Address: " . ($adData['dealer_address'] ?? 'NOT SET'));
                $this->line("    Dealer City: " . ($adData['dealer_city'] ?? 'NOT SET'));
                
                try {
                    if ($dryRun) {
                        $this->showDryRunData($adData);
                        $importedCount++;
                    } else {
                        $result = $this->importAdvertisementWithRealImages($adData);
                        if ($result['success']) {
                            $this->info("  ✓ Imported successfully (ID: {$result['id']}) with {$result['images_count']} images");
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
        $this->line("  Images: " . count($adData['gallery_images'] ?? []) . " images");
        $this->line("  Service History: " . (($adData['service_history_available'] ?? false) ? 'Yes' : 'No'));
        $this->line("  Warranty: " . (($adData['warranty_available'] ?? false) ? 'Yes' : 'No'));
        
        // Provider information
        $this->line("  --- Provider Information ---");
        $this->line("  Dealer Name: " . ($adData['dealer_name'] ?? 'N/A'));
        $this->line("  Email: " . ($adData['dealer_email'] ?? 'N/A'));
        $this->line("  Phone: " . ($adData['dealer_phone'] ?? 'N/A'));
        $this->line("  WhatsApp: " . ($adData['dealer_whatsapp'] ?? 'N/A'));
        $this->line("  Address: " . ($adData['dealer_address'] ?? 'N/A'));
        $this->line("  City: " . ($adData['dealer_city'] ?? 'N/A'));
        $this->line("  ZIP Code: " . ($adData['dealer_zip_code'] ?? 'N/A'));
        $this->line("  Village: " . ($adData['dealer_village'] ?? 'N/A'));
        $this->line("  Username: " . ($adData['dealer_username'] ?? 'N/A'));
        $this->line("  Title: " . ($adData['dealer_title'] ?? 'N/A'));
        $this->line("  Rating: " . ($adData['dealer_rating'] ?? 'N/A'));
        $this->line("  Show Info: " . (($adData['dealer_show_info'] ?? false) ? 'Yes' : 'No'));
    }
    
    /**
     * Import advertisement with real downloadable images
     */
    private function importAdvertisementWithRealImages($adData)
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
            
            // Get or create vehicle body type
            $vehicleBody = $this->getOrCreateVehicleBody($adData['vehicle_body'] ?? 'Naked');
            
            // Get or create vehicle color
            $vehicleColor = $this->getOrCreateVehicleColor($adData['color'] ?? 'Black');
            
            // Prepare advertisement data
            $advertisementData = [
                'provider_id' => $provider->id,
                'advertisement_type_id' => $advertisementType->id,
                'brand_id' => $brand->id,
                'vehicle_model_id' => $vehicleModel->id,
                'fuel_type_id' => $fuelType->id,
                'vehicle_body_id' => $vehicleBody->id,
                'color_id' => $vehicleColor->id,
                'description' => $adData['description'] ?? '',
                'final_price' => $adData['final_price'] ?? 0,
                'registration_year' => $adData['registration_year'] ?? null,
                'registration_month' => $adData['registration_month'] ?? null,
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
                'emissions_class' => $adData['emissions_class'] ?? null,
                'co2_emissions' => $adData['co2_emissions'] ?? null,
                'combined_fuel_consumption' => $adData['combined_fuel_consumption'] ?? null,
                'is_metallic_paint' => $adData['is_metallic_paint'] ?? false,
                'vehicle_category' => $adData['vehicle_category'] ?? 'used',
                'next_review_year' => $adData['next_review_year'] ?? null,
                'next_review_month' => $adData['next_review_month'] ?? null,
                'last_service_year' => $adData['last_service_year'] ?? null,
                'last_service_month' => $adData['last_service_month'] ?? null,
                'source_url' => $adData['source_url'] ?? null,
            ];
            
            // Create advertisement
            $advertisement = Advertisement::create($advertisementData);
            
            // Import provider image if available
            if (isset($adData['dealer_image']) && !empty($adData['dealer_image'])) {
                $this->importProviderImage($provider, $adData['dealer_image']);
            }
            
            // Import real images from scraper
            $imagesCount = $this->importScrapedImages($advertisement, $adData);
            
            return [
                'success' => true,
                'id' => $advertisement->id,
                'images_count' => $imagesCount
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
     * Import real images from scraper
     */
    private function importScrapedImages($advertisement, $adData)
    {
        $imagesImported = 0;
        
        // Use real images from scraper
        $galleryImages = $adData['gallery_images'] ?? [];
        
        foreach ($galleryImages as $index => $imageData) {
            try {
                // Handle both string URLs and array structures
                $imageUrl = is_string($imageData) ? $imageData : ($imageData['url'] ?? null);
                
                if (empty($imageUrl)) {
                    continue;
                }
                
                // Download and attach the image
                $this->importSingleImage($advertisement, $imageUrl, $index);
                $imagesImported++;
                
                // Limit to 5 images max
                if ($imagesImported >= 5) {
                    break;
                }
            } catch (\Exception $e) {
                Log::warning('Failed to import scraped image', [
                    'advertisement_id' => $advertisement->id,
                    'image_data' => $imageData,
                    'error' => $e->getMessage()
                ]);
            }
        }
        
        // If no images were imported, add a placeholder
        if ($imagesImported === 0) {
            $this->addPlaceholderImage($advertisement);
            $imagesImported = 1;
        }
        
        return $imagesImported;
    }
    
    /**
     * Import a single image from URL with conversion
     */
    private function importSingleImage($advertisement, $imageUrl, $index)
    {
        $tempFile = null;
        $convertedFile = null;
        
        try {
            // Download the image
            $imageContent = file_get_contents($imageUrl);
            
            if ($imageContent === false) {
                throw new \Exception("Failed to download image from: {$imageUrl}");
            }
            
            // Create a temporary file for the original image
            $tempFile = tempnam(sys_get_temp_dir(), 'autoscout24_image_');
            file_put_contents($tempFile, $imageContent);
            
            // Convert and optimize the image
            $convertedFile = $this->convertAndOptimizeImage($tempFile, $imageUrl);
            
            // Attach to advertisement using Spatie Media Library
            $advertisement->addMedia($convertedFile)
                ->usingName("Image " . ($index + 1))
                ->usingFileName("autoscout24_image_" . $advertisement->id . "_" . ($index + 1) . ".jpg")
                ->toMediaCollection('covers');
            
        } catch (\Exception $e) {
            Log::warning('Failed to import single image', [
                'advertisement_id' => $advertisement->id,
                'image_url' => $imageUrl,
                'error' => $e->getMessage()
            ]);
            throw $e;
        } finally {
            // Clean up temp files safely
            if ($tempFile && file_exists($tempFile)) {
                unlink($tempFile);
            }
            if ($convertedFile && $convertedFile !== $tempFile && file_exists($convertedFile)) {
                unlink($convertedFile);
            }
        }
    }
    
    /**
     * Convert and optimize image for web use
     */
    private function convertAndOptimizeImage($tempFile, $originalUrl)
    {
        // Get image info
        $imageInfo = getimagesize($tempFile);
        if (!$imageInfo) {
            throw new \Exception("Invalid image file");
        }
        
        $width = $imageInfo[0];
        $height = $imageInfo[1];
        $mimeType = $imageInfo['mime'];
        
        // Create output file
        $outputFile = tempnam(sys_get_temp_dir(), 'autoscout24_converted_');
        $outputFile .= '.jpg';
        
        // Load image based on type
        switch ($mimeType) {
            case 'image/jpeg':
                $sourceImage = imagecreatefromjpeg($tempFile);
                break;
            case 'image/png':
                $sourceImage = imagecreatefrompng($tempFile);
                break;
            case 'image/webp':
                $sourceImage = imagecreatefromwebp($tempFile);
                break;
            case 'image/gif':
                $sourceImage = imagecreatefromgif($tempFile);
                break;
            default:
                throw new \Exception("Unsupported image type: {$mimeType}");
        }
        
        if (!$sourceImage) {
            throw new \Exception("Failed to load image");
        }
        
        // Calculate new dimensions (max 1920x1080 for web optimization)
        $maxWidth = 1920;
        $maxHeight = 1080;
        
        if ($width > $maxWidth || $height > $maxHeight) {
            $ratio = min($maxWidth / $width, $maxHeight / $height);
            $newWidth = (int)($width * $ratio);
            $newHeight = (int)($height * $ratio);
        } else {
            $newWidth = $width;
            $newHeight = $height;
        }
        
        // Create new image with calculated dimensions
        $newImage = imagecreatetruecolor($newWidth, $newHeight);
        
        // Preserve transparency for PNG
        if ($mimeType === 'image/png') {
            imagealphablending($newImage, false);
            imagesavealpha($newImage, true);
            $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
            imagefill($newImage, 0, 0, $transparent);
        }
        
        // Resize image
        imagecopyresampled($newImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        
        // Save as optimized JPEG
        $quality = 85; // Good quality for web
        imagejpeg($newImage, $outputFile, $quality);
        
        // Clean up
        imagedestroy($sourceImage);
        imagedestroy($newImage);
        
        return $outputFile;
    }
    
    /**
     * Add a placeholder image when no real images are available
     */
    private function addPlaceholderImage($advertisement)
    {
        $tempFile = null;
        
        try {
            // Create a simple placeholder image using GD
            $width = 800;
            $height = 600;
            $image = imagecreate($width, $height);
            
            // Set colors
            $bgColor = imagecolorallocate($image, 204, 204, 204); // Light gray background
            $textColor = imagecolorallocate($image, 102, 102, 102); // Dark gray text
            
            // Fill background
            imagefill($image, 0, 0, $bgColor);
            
            // Add text
            $text = "No Image Available";
            $fontSize = 5;
            $textWidth = imagefontwidth($fontSize) * strlen($text);
            $textHeight = imagefontheight($fontSize);
            $x = ($width - $textWidth) / 2;
            $y = ($height - $textHeight) / 2;
            
            imagestring($image, $fontSize, $x, $y, $text, $textColor);
            
            // Save to temporary file
            $tempFile = tempnam(sys_get_temp_dir(), 'placeholder_');
            imagejpeg($image, $tempFile, 85);
            imagedestroy($image);
            
            // Add to advertisement
            $advertisement->addMedia($tempFile)
                ->usingName("Placeholder Image")
                ->usingFileName("placeholder_" . $advertisement->id . ".jpg")
                ->toMediaCollection('covers');
                
        } catch (\Exception $e) {
            Log::warning('Failed to add placeholder image', [
                'advertisement_id' => $advertisement->id,
                'error' => $e->getMessage()
            ]);
        } finally {
            // Clean up temporary file safely
            if ($tempFile && file_exists($tempFile)) {
                unlink($tempFile);
            }
        }
    }
    
    /**
     * Import real downloadable images
     */
    private function importRealImages($advertisement, $adData)
    {
        $imagesImported = 0;
        $brand = $adData['brand'] ?? 'Motorcycle';
        $model = $adData['model'] ?? 'Model';
        
        // Generate real downloadable image URLs from various sources
        $realImageUrls = $this->generateRealDownloadableImages($brand, $model, $advertisement->id);
        
        foreach ($realImageUrls as $index => $imageData) {
            try {
                $this->importSingleRealImage($advertisement, $imageData, $index);
                $imagesImported++;
            } catch (\Exception $e) {
                Log::warning('Failed to import real image', [
                    'advertisement_id' => $advertisement->id,
                    'image_url' => $imageData['url'] ?? 'N/A',
                    'error' => $e->getMessage()
                ]);
            }
        }
        
        return $imagesImported;
    }
    
    /**
     * Generate real downloadable image URLs
     */
    private function generateRealDownloadableImages($brand, $model, $adId)
    {
        $images = [];
        $imageCount = rand(2, 5); // 2-5 images
        
        // Real image sources that actually work
        $imageSources = [
            'https://picsum.photos', // Lorem Picsum - real random images
            'https://source.unsplash.com', // Unsplash - real photos
            'https://via.placeholder.com', // Placeholder with real images
        ];
        
        $imageTypes = [
            'motorcycle' => 'Motorcycle',
            'bike' => 'Bike',
            'vehicle' => 'Vehicle',
            'transport' => 'Transport',
            'sport' => 'Sport'
        ];
        
        for ($i = 1; $i <= $imageCount; $i++) {
            $source = $imageSources[array_rand($imageSources)];
            $imageType = array_keys($imageTypes)[array_rand(array_keys($imageTypes))];
            
            if ($source === 'https://picsum.photos') {
                $url = "{$source}/800/600?random={$adId}{$i}";
            } elseif ($source === 'https://source.unsplash.com') {
                $url = "{$source}/800x600/?{$imageType}";
            } else {
                $url = "{$source}/800x600/0066CC/FFFFFF?text={$brand}+{$model}+{$i}";
            }
            
            $images[] = [
                'url' => $url,
                'alt' => "{$brand} {$model} - Image {$i}",
                'thumbnail' => $url
            ];
        }
        
        return $images;
    }
    
    /**
     * Import a single real image
     */
    private function importSingleRealImage($advertisement, $imageData, $index)
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
            $filename = 'real-image-' . $advertisement->id . '-' . ($index + 1) . '.' . $extension;
            
            // Store image
            $advertisement->addMediaFromString($response->body())
                ->usingFileName($filename)
                ->usingName($altText)
                ->toMediaCollection('covers');
                
        } catch (\Exception $e) {
            Log::warning('Failed to import real image', [
                'advertisement_id' => $advertisement->id,
                'image_url' => $imageUrl,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
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
    
    /**
     * Get or create provider with comprehensive data
     */
    private function getOrCreateProvider($adData)
    {
        $dealerName = $adData['dealer_name'] ?? 'Autoscout24 Dealer';
        $dealerEmail = $adData['dealer_email'] ?? Str::slug($dealerName) . '@autoscout24.com';
        
        // Try to find existing provider by email or name
        $provider = Provider::where('email', $dealerEmail)
            ->orWhere('first_name', 'like', "%{$dealerName}%")
            ->first();
        
        if (!$provider) {
            // Split dealer name into first and last name
            $nameParts = explode(' ', $dealerName);
            $firstName = $nameParts[0] ?? $dealerName;
            $lastName = count($nameParts) > 1 ? implode(' ', array_slice($nameParts, 1)) : 'Dealer';
            
            $provider = Provider::create([
                'username' => $adData['dealer_username'] ?? Str::slug($dealerName),
                'email' => $dealerEmail,
                'title' => $adData['dealer_title'] ?? 'Mr.',
                'first_name' => $firstName,
                'last_name' => $lastName,
                'phone' => $adData['dealer_phone'] ?? '+39 011 1234567',
                'whatsapp' => $adData['dealer_whatsapp'] ?? $adData['dealer_phone'] ?? '+39 011 1234567',
                'address' => $adData['dealer_address'] ?? 'Via Roma 123',
                'village' => $adData['dealer_village'] ?? 'Centro',
                'zip_code' => $adData['dealer_zip_code'] ?? '10100',
                'city' => $adData['dealer_city'] ?? 'Torino',
                'seller_type' => $adData['seller_type'] ?? 'dealer',
                'show_info_in_advertisement' => $adData['dealer_show_info'] ?? true,
                'password' => bcrypt('autoscout24dealer'),
                'email_verified_at' => now(),
            ]);
        } else {
            // Update existing provider with new data if available
            $updateData = [];
            
            if (isset($adData['dealer_phone']) && $adData['dealer_phone']) {
                $updateData['phone'] = $adData['dealer_phone'];
            }
            if (isset($adData['dealer_whatsapp']) && $adData['dealer_whatsapp']) {
                $updateData['whatsapp'] = $adData['dealer_whatsapp'];
            }
            if (isset($adData['dealer_address']) && $adData['dealer_address']) {
                $updateData['address'] = $adData['dealer_address'];
            }
            if (isset($adData['dealer_city']) && $adData['dealer_city']) {
                $updateData['city'] = $adData['dealer_city'];
            }
            if (isset($adData['dealer_zip_code']) && $adData['dealer_zip_code']) {
                $updateData['zip_code'] = $adData['dealer_zip_code'];
            }
            if (isset($adData['seller_type']) && $adData['seller_type']) {
                $updateData['seller_type'] = $adData['seller_type'];
            }
            
            if (!empty($updateData)) {
                $provider->update($updateData);
            }
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
     * Get or create vehicle body type
     */
    private function getOrCreateVehicleBody($name)
    {
        return \App\Models\VehicleBody::firstOrCreate(
            ['name' => $name],
            ['name' => $name]
        );
    }
    
    /**
     * Get or create vehicle color
     */
    private function getOrCreateVehicleColor($name)
    {
        return \App\Models\VehicleColor::firstOrCreate(
            ['name' => $name],
            ['name' => $name]
        );
    }
    
    /**
     * Import provider image
     */
    private function importProviderImage($provider, $imageUrl)
    {
        $tempFile = null;
        $convertedFile = null;
        
        try {
            Log::info('Importing provider image', [
                'provider_id' => $provider->id,
                'image_url' => $imageUrl
            ]);
            
            // Download image content
            $imageContent = file_get_contents($imageUrl);
            if ($imageContent === false) {
                Log::warning('Failed to download provider image', ['url' => $imageUrl]);
                return false;
            }
            
            // Create temporary file
            $tempFile = tempnam(sys_get_temp_dir(), 'provider_image_');
            file_put_contents($tempFile, $imageContent);
            
            // Convert and optimize image
            $convertedFile = $this->convertAndOptimizeImage($tempFile, $imageUrl);
            
            // Add image to provider
            $provider->addMedia($convertedFile)
                ->usingName('Provider Image')
                ->usingFileName('provider_' . $provider->id . '.jpg')
                ->toMediaCollection('image');
            
            Log::info('Successfully imported provider image', [
                'provider_id' => $provider->id
            ]);
            
            return true;
            
        } catch (\Exception $e) {
            Log::error('Failed to import provider image', [
                'provider_id' => $provider->id,
                'image_url' => $imageUrl,
                'error' => $e->getMessage()
            ]);
            
            return false;
        } finally {
            // Clean up temporary files safely
            if ($tempFile && file_exists($tempFile)) {
                unlink($tempFile);
            }
            if ($convertedFile && $convertedFile !== $tempFile && file_exists($convertedFile)) {
                unlink($convertedFile);
            }
        }
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
}
