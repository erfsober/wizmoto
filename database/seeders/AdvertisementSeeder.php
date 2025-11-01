<?php

namespace Database\Seeders;

use App\Models\Advertisement;
use App\Models\AdvertisementType;
use App\Models\Brand;
use App\Models\Equipment;
use App\Models\FuelType;
use App\Models\Provider;
use App\Models\VehicleBody;
use App\Models\VehicleColor;
use App\Models\VehicleModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdvertisementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * This seeder creates realistic advertisements for local development.
     * Run with: php artisan db:seed --class=AdvertisementSeeder
     */
    public function run(): void
    {
        // Get all necessary models
        $providers = Provider::all();
        $advertisementTypes = AdvertisementType::all();
        $brands = Brand::all();
        $fuelTypes = FuelType::all();
        $vehicleBodies = VehicleBody::all();
        $vehicleColors = VehicleColor::all();
        $equipments = Equipment::all();

        // Check if we have required data
        if ($providers->isEmpty()) {
            $this->command->warn('No providers found. Creating a test provider...');
            $providers = collect([$this->createTestProvider()]);
        }

        if ($brands->isEmpty()) {
            $this->command->error('No brands found. Please run BrandSeeder first.');
            return;
        }

        if ($advertisementTypes->isEmpty()) {
            $this->command->error('No advertisement types found. Please run AdvertisementTypeSeeder first.');
            return;
        }

        $this->command->info('Creating advertisements...');

        // Create 50 advertisements
        for ($i = 0; $i < 50; $i++) {
            $advertisement = $this->createAdvertisement([
                'providers' => $providers,
                'advertisementTypes' => $advertisementTypes,
                'brands' => $brands,
                'fuelTypes' => $fuelTypes,
                'vehicleBodies' => $vehicleBodies,
                'vehicleColors' => $vehicleColors,
                'equipments' => $equipments,
            ]);

            $this->command->info("Created advertisement #{$advertisement->id}: {$advertisement->brand?->localized_name} {$advertisement->vehicleModel?->localized_name}");
        }

        $this->command->info('✓ Created 50 advertisements successfully!');
    }

    /**
     * Create a single advertisement with realistic data
     */
    private function createAdvertisement(array $data): Advertisement
    {
        $provider = $data['providers']->random();
        $advertisementType = $data['advertisementTypes']->random();
        $brand = $data['brands']->random();
        
        // Get vehicle models for this brand
        $vehicleModels = VehicleModel::where('brand_id', $brand->id)->get();
        if ($vehicleModels->isEmpty()) {
            // If no models for this brand, create one
            $vehicleModel = VehicleModel::first();
        } else {
            $vehicleModel = $vehicleModels->random();
        }

        $fuelType = $data['fuelTypes']->random();
        $vehicleBody = $data['vehicleBodies']->random();
        $vehicleColor = $data['vehicleColors']->random();

        // Generate realistic year (between 2015 and 2024)
        $registrationYear = rand(2015, 2024);
        $registrationMonth = rand(1, 12);

        // Generate realistic mileage based on year
        $yearsOld = 2024 - $registrationYear;
        $baseMileage = $yearsOld * rand(5000, 15000);
        $mileage = max(0, $baseMileage + rand(-5000, 5000));

        // Generate realistic price based on year and mileage
        $basePrice = rand(3000, 25000);
        $priceAdjustment = ($yearsOld * -500) + (($mileage / 1000) * -50);
        $finalPrice = max(1000, $basePrice + $priceAdjustment);

        // Motor specifications
        $motorPowers = [25, 35, 48, 65, 75, 95, 110, 125, 150, 180];
        $motorPowerKw = $motorPowers[array_rand($motorPowers)];
        $motorPowerCv = (int)($motorPowerKw * 1.36); // Convert kW to CV

        $transmissions = ['Manual', 'Automatic', 'Semi-automatic'];
        $motorChange = $transmissions[array_rand($transmissions)];

        $cylinders = [1, 2, 3, 4];
        $motorCylinders = $cylinders[array_rand($cylinders)];

        $displacements = [125, 250, 300, 400, 500, 600, 700, 800, 900, 1000, 1100, 1200];
        $motorDisplacement = $displacements[array_rand($displacements)];

        // Create advertisement
        $advertisement = Advertisement::create([
            'provider_id' => $provider->id,
            'advertisement_type_id' => $advertisementType->id,
            'brand_id' => $brand->id,
            'vehicle_model_id' => $vehicleModel?->id,
            'version_model' => $this->generateVersionModel(),
            'vehicle_body_id' => $vehicleBody->id,
            'color_id' => $vehicleColor->id,
            'is_metallic_paint' => rand(0, 1) === 1,
            'is_verified' => true, // Set to true so advertisements show on home page
            'vehicle_category' => $advertisementType->localized_title,
            'mileage' => $mileage,
            'registration_month' => str_pad($registrationMonth, 2, '0', STR_PAD_LEFT),
            'registration_year' => (string)$registrationYear,
            'previous_owners' => rand(0, 3),
            'next_review_year' => (string)($registrationYear + rand(1, 3)),
            'next_review_month' => str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT),
            'last_service_year' => (string)($registrationYear + rand(0, $yearsOld)),
            'last_service_month' => str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT),
            'motor_change' => $motorChange,
            'motor_power_kw' => $motorPowerKw,
            'motor_power_cv' => $motorPowerCv,
            'motor_marches' => rand(4, 6),
            'motor_cylinders' => $motorCylinders,
            'motor_displacement' => $motorDisplacement,
            'motor_empty_weight' => rand(150, 250),
            'fuel_type_id' => $fuelType->id,
            'combined_fuel_consumption' => rand(30, 70) / 10, // 3.0 to 7.0 L/100km
            'co2_emissions' => rand(80, 180),
            'emissions_class' => $this->getRandomEmissionClass(),
            'description' => $this->generateDescription($brand, $vehicleModel, $registrationYear),
            'price_negotiable' => rand(0, 1) === 1,
            'tax_deductible' => rand(0, 1) === 1,
            'final_price' => $finalPrice,
            'zip_code' => $this->generateZipCode(),
            'city' => $this->generateCity(),
            'international_prefix' => '+39',
            'prefix' => '0' . rand(2, 9),
            'telephone' => rand(1000000, 9999999),
            'show_phone' => rand(0, 1) === 1,
        ]);

        // Attach random equipment (3-8 items)
        $equipmentCount = rand(3, 8);
        $randomEquipments = $data['equipments']->random(min($equipmentCount, $data['equipments']->count()));
        $advertisement->equipments()->attach($randomEquipments->pluck('id')->toArray());

        // Save the advertisement first to ensure it's persisted
        $advertisement->save();
        
        // Add images to the advertisement
        $this->addImagesToAdvertisement($advertisement);
        
        // Refresh to ensure media is loaded and conversions are generated
        $advertisement->refresh();
        $advertisement->load('media');

        return $advertisement;
    }

    /**
     * Create a test provider if none exists
     */
    private function createTestProvider(): Provider
    {
        return Provider::create([
            'title' => 'Mr',
            'first_name' => 'Test',
            'last_name' => 'Provider',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'phone' => '1234567890',
            'whatsapp' => '1234567890',
            'seller_type' => 'private',
            'address' => 'Test Street 123',
            'village' => 'Italy',
            'zip_code' => '00100',
            'city' => 'Rome',
        ]);
    }

    /**
     * Generate a realistic version/model name
     */
    private function generateVersionModel(): string
    {
        $versions = [
            'Standard', 'Deluxe', 'Sport', 'Touring', 'Adventure', 
            'Urban', 'Classic', 'Pro', 'Limited', 'Edition',
            'Custom', 'Special', 'Premium', 'Elite'
        ];
        
        return $versions[array_rand($versions)];
    }

    /**
     * Generate a realistic description
     */
    private function generateDescription($brand, $vehicleModel, int $year): string
    {
        $adjectives = ['excellent', 'well-maintained', 'pristine', 'beautiful', 'stunning', 'meticulously cared for'];
        $conditions = ['like new', 'in perfect condition', 'never dropped', 'garage kept', 'first owner'];
        
        $adjective = $adjectives[array_rand($adjectives)];
        $condition = $conditions[array_rand($conditions)];
        
        $brandName = $brand?->localized_name ?? 'Vehicle';
        $modelName = $vehicleModel?->localized_name ?? 'Model';
        
        return "{$adjective} {$brandName} {$modelName} {$year}, {$condition}. 
Regular service history, all documents in order. 
Ready for immediate delivery. Contact for more information and viewing.";
    }

    /**
     * Get random emission class
     */
    private function getRandomEmissionClass(): string
    {
        $classes = ['Euro 4', 'Euro 5', 'Euro 6'];
        return $classes[array_rand($classes)];
    }

    /**
     * Generate a realistic Italian zip code
     */
    private function generateZipCode(): string
    {
        $zipCodes = [
            '00100', '20100', '30100', '40100', '50100',
            '10100', '16100', '20121', '50122', '00118',
            '20123', '40121', '50123', '10121', '16121'
        ];
        
        return $zipCodes[array_rand($zipCodes)];
    }

    /**
     * Generate a realistic Italian city
     */
    private function generateCity(): string
    {
        $cities = [
            'Rome', 'Milan', 'Naples', 'Turin', 'Palermo',
            'Genoa', 'Bologna', 'Florence', 'Bari', 'Catania',
            'Venice', 'Verona', 'Messina', 'Padua', 'Trieste'
        ];
        
        return $cities[array_rand($cities)];
    }

    /**
     * Add placeholder images to advertisement
     */
    private function addImagesToAdvertisement(Advertisement $advertisement): void
    {
        // Create a simple placeholder image programmatically
        $imageCount = rand(2, 4);
        
        for ($i = 1; $i <= $imageCount; $i++) {
            try {
                $this->createAndAddPlaceholderImage($advertisement, $i);
            } catch (\Exception $e) {
                $this->command->warn("Could not add image {$i} to advertisement #{$advertisement->id}: " . $e->getMessage());
            }
        }
    }

    /**
     * Create a simple placeholder image using GD library
     */
    private function createAndAddPlaceholderImage(Advertisement $advertisement, int $number): void
    {
        // Create image dimensions
        $width = 800;
        $height = 600;
        
        // Create image resource
        $image = imagecreatetruecolor($width, $height);
        
        // Define colors
        $backgroundColor = imagecolorallocate($image, 64, 95, 242); // #405FF2
        $textColor = imagecolorallocate($image, 255, 255, 255); // White
        $borderColor = imagecolorallocate($image, 255, 255, 255); // White border
        
        // Fill background
        imagefilledrectangle($image, 0, 0, $width, $height, $backgroundColor);
        
        // Add border
        imagerectangle($image, 0, 0, $width - 1, $height - 1, $borderColor);
        
        // Add text
        $text = "Motorcycle " . $number;
        $fontSize = 5; // Use built-in font (1-5)
        $textX = ($width - imagefontwidth($fontSize) * strlen($text)) / 2;
        $textY = ($height - imagefontheight($fontSize)) / 2;
        
        imagestring($image, $fontSize, $textX, $textY, $text, $textColor);
        
        // Save to temporary file
        $tempPath = sys_get_temp_dir() . '/ad_image_' . $advertisement->id . '_' . $number . '_' . time() . '.jpg';
        imagejpeg($image, $tempPath, 90);
        imagedestroy($image);
        
        // Add to media library and perform conversions immediately
        $media = $advertisement->addMedia($tempPath)
            ->usingName("Placeholder Image {$number}")
            ->toMediaCollection('covers');
        
        // Force immediate conversion generation (not queued)
        try {
            // Access the URL which triggers conversion generation
            $media->getUrl('card');
            $media->getUrl('preview');
            $media->getUrl('vehicle-card');
        } catch (\Exception $e) {
            // Conversions might be queued, that's okay
            $this->command->warn("Conversion generation for image {$number} might be queued: " . $e->getMessage());
        }
        
        // Clean up temp file after a short delay to ensure it's copied
        // Note: Spatie copies the file, so we can delete the temp file
        if (file_exists($tempPath)) {
            // Small delay to ensure file is copied
            usleep(100000); // 0.1 second
            @unlink($tempPath);
        }
    }
}

