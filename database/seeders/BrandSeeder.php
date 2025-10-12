<?php

namespace Database\Seeders;

use App\Models\AdvertisementType;
use App\Models\Brand;
use Illuminate\Database\Seeder;

/**
 * Brand Seeder
 * 
 * Creates unique brands and associates them with multiple advertisement types
 * Each brand exists only ONCE in the database, but can be linked to multiple categories
 * 
 * Example: "Yamaha" is one brand, but it's available for:
 * - Motorcycles
 * - Motor Scooters
 * - Scooters
 * 
 * To add a new brand:
 * 1. Find the brand in the getBrandsData() method
 * 2. Add the category to its 'categories' array
 * 3. Run: php artisan db:seed --class=BrandSeeder
 */
class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Brand::truncate();
        $brandsData = $this->getBrandsData();

        foreach ($brandsData as $brandName => $categories) {
            // Create or update the brand (only once!)
            $brand = Brand::firstOrCreate(['name' => $brandName]);

            // Get all advertisement types for this brand
            $advertisementTypeIds = [];
            foreach ($categories as $categoryName) {
                $advertisementType = AdvertisementType::where('title', $categoryName)->first();
                
                if ($advertisementType) {
                    $advertisementTypeIds[] = $advertisementType->id;
                } else {
                    $this->command->warn("Advertisement type '{$categoryName}' not found for brand '{$brandName}'");
                }
            }

            // Sync the advertisement types (adds new, keeps existing, removes old)
            if (!empty($advertisementTypeIds)) {
                $brand->advertisementTypes()->sync($advertisementTypeIds);
            }
        }

        $totalBrands = count($brandsData);
        $this->command->info("✓ Seeded {$totalBrands} unique brands with category associations");
    }

    /**
     * Get all brands with their associated advertisement types
     * 
     * Format: 'Brand Name' => ['Category 1', 'Category 2', ...]
     * 
     * @return array<string, array<string>>
     */
    private function getBrandsData(): array
    {
        return [
            // ============================================
            // BRANDS THAT APPEAR IN MULTIPLE CATEGORIES
            // ============================================
            
            'Yamaha' => ['Motorcycle', 'Motor Scooter', 'Scooter'],
            'Honda' => ['Motorcycle', 'Motor Scooter', 'Scooter'],
            'Suzuki' => ['Motorcycle', 'Motor Scooter', 'Scooter'],
            'Kawasaki' => ['Motorcycle'],
            'BMW' => ['Motorcycle', 'Motor Scooter'],
            'Aprilia' => ['Motorcycle', 'Motor Scooter', 'Scooter'],
            'Piaggio' => ['Motor Scooter', 'Scooter'],
            'Vespa' => ['Motor Scooter', 'Scooter'],
            'Kymco' => ['Motorcycle', 'Motor Scooter', 'Scooter'],
            'SYM' => ['Motor Scooter', 'Scooter'],
            'KTM' => ['Motorcycle', 'Bike'],
            'Peugeot' => ['Motor Scooter', 'Scooter'],
            'Gilera' => ['Motor Scooter', 'Scooter'],
            'MBK' => ['Motor Scooter', 'Scooter'],
            'Malaguti' => ['Motor Scooter', 'Scooter'],
            'Benelli' => ['Motorcycle', 'Motor Scooter'],

            // ============================================
            // MOTORCYCLE BRANDS
            // ============================================
            
            'Bimota' => ['Motorcycle'],
            'Buell' => ['Motorcycle'],
            'Cagiva' => ['Motorcycle'],
            'Can-Am' => ['Motorcycle'],
            'CF Moto' => ['Motorcycle'],
            'Ducati' => ['Motorcycle'],
            'Energica' => ['Motorcycle'],
            'Harley-Davidson' => ['Motorcycle'],
            'Husqvarna' => ['Motorcycle'],
            'Hyosung' => ['Motorcycle'],
            'Indian Motorcycle' => ['Motorcycle'],
            'Moto Guzzi' => ['Motorcycle'],
            'MV Agusta' => ['Motorcycle'],
            'Norton' => ['Motorcycle'],
            'Royal Enfield' => ['Motorcycle'],
            'SWM' => ['Motorcycle'],
            'Triumph' => ['Motorcycle'],
            'Victory' => ['Motorcycle'],
            'Zero Motorcycles' => ['Motorcycle'],

            // ============================================
            // MOTOR SCOOTER BRANDS (125cc+)
            // ============================================
            
            'NIU' => ['Motor Scooter', 'Scooter'],

            // ============================================
            // SCOOTER BRANDS (Small scooters)
            // ============================================
            
            'Baotian' => ['Scooter'],
            'Benzhou' => ['Scooter'],
            'CPI' => ['Scooter'],
            'Derbi' => ['Scooter'],
            'Generic' => ['Scooter'],
            'Italjet' => ['Scooter'],
            'Keeway' => ['Scooter'],
            'Longjia' => ['Scooter'],
            'Rieju' => ['Scooter'],
            'Sachs' => ['Scooter'],
            'TGB' => ['Scooter'],
            'Zhongyu' => ['Scooter'],

            // ============================================
            // BICYCLE BRANDS
            // ============================================
            
            'Ancheer' => ['Bike'],
            'Bianchi' => ['Bike'],
            'BMC' => ['Bike'],
            'Bulls' => ['Bike'],
            'Cannondale' => ['Bike'],
            'Canyon' => ['Bike'],
            'Carrera' => ['Bike'],
            'Cervelo' => ['Bike'],
            'Cinelli' => ['Bike'],
            'Colnago' => ['Bike'],
            'Cube' => ['Bike'],
            'Diamondback' => ['Bike'],
            'Electra' => ['Bike'],
            'Focus' => ['Bike'],
            'Fuji' => ['Bike'],
            'Gazelle' => ['Bike'],
            'Ghost' => ['Bike'],
            'Giant' => ['Bike'],
            'GT' => ['Bike'],
            'Haibike' => ['Bike'],
            'Kalkhoff' => ['Bike'],
            'Lapierre' => ['Bike'],
            'Merida' => ['Bike'],
            'Mongoose' => ['Bike'],
            'Mondraker' => ['Bike'],
            'Orbea' => ['Bike'],
            'Pinarello' => ['Bike'],
            'Raleigh' => ['Bike'],
            'Ridley' => ['Bike'],
            'Rose' => ['Bike'],
            'Santa Cruz' => ['Bike'],
            'Schwinn' => ['Bike'],
            'Scott' => ['Bike'],
            'Specialized' => ['Bike'],
            'Trek' => ['Bike'],
            'Vitus' => ['Bike'],
            'Wilier' => ['Bike'],
            'Yeti' => ['Bike'],

            // ============================================
            // OTHER (Available for all categories)
            // ============================================
            
            'Other' => ['Motorcycle', 'Motor Scooter', 'Scooter', 'Bike'],

            // ============================================
            // ADD NEW BRANDS BELOW (Keep alphabetical order)
            // Format: 'Brand Name' => ['Category1', 'Category2'],
            // ============================================
            
        ];
    }
}
