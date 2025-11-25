<?php

namespace App\Console\Commands;

use App\Models\Advertisement;
use App\Models\AdvertisementType;
use App\Models\Equipment;
use App\Models\Provider;
use App\Services\Autoscout24ScraperService;
use Illuminate\Console\Command;

class ImportAutoscout24WithRealImages extends Command
{
    protected $signature = 'import:autoscout24-images {--limit=1 : Number of ads to scrape}';
    protected $description = 'Scrape ads from Autoscout24 listing page and show basic data in the console';

    public function __construct(
        private readonly Autoscout24ScraperService $scraper,
    ) {
        parent::__construct();
    }

    public function handle()
    {
        $limit = (int) $this->option('limit');

        $this->info('Starting Autoscout24 scraping…');
        $this->info("Limit: {$limit} ad(s)");

        try {
            // Get up to $limit ad URLs from the listings page (via headless scraper / HTML fallback).
            $urls = $this->scraper->scrapePage($limit);

            if (empty($urls)) {
                $this->warn('No listings found on the listings page.');

                return;
            }

            $this->info('Scraping and importing single ads…');

            $count = 0;

            foreach ($urls as $url) {
                $ad = $this->scraper->scrapeAd($url);

                if ($ad === null) {
                    $this->warn("Failed to scrape ad at URL: {$url}");

                    continue;
                }

                // Skip if this Autoscout24 ad was already imported.
                if (isset($ad['url']) && Advertisement::where('source_url', $ad['url'])->exists()) {
                    $this->warn("Already imported, skipping: {$ad['url']}");
                    continue;
                }

                // Resolve or create a provider for this ad based on real Autoscout24 meta.
                $provider = $this->resolveProviderFromAutoscoutMeta($ad['meta'] ?? []);

                // Attach a real dealer logo image to the provider (once), using headless scraper.
                $this->maybeAttachProviderLogo($provider, $ad['url'] ?? $url);

                // Resolve or create an advertisement type from Autoscout24 meta (e.g. dealer/private).
                $advertisementType = $this->resolveAdvertisementTypeFromAutoscoutMeta($ad['meta'] ?? []);

                // Create a new Advertisement record from scraped data.
                $advertisement = $this->createAdvertisementFromAutoscout($ad, $provider, $advertisementType);

                // Attach up to 5 images to the 'covers' media collection.
                if (! empty($ad['images']) && is_array($ad['images'])) {
                    $images = array_slice($ad['images'], 0, 5);

                    foreach ($images as $imageUrl) {
                        try {
                            $advertisement
                                ->addMediaFromUrl($imageUrl)
                                ->toMediaCollection('covers');
                        } catch (\Throwable $e) {
                            $this->warn("Failed to attach image for ad {$advertisement->id}: {$e->getMessage()}");
                        }
                    }
                }

                // Attach real equipment features based on Autoscout24 equipment section.
                if (! empty($ad['equipment']) && is_array($ad['equipment'])) {
                    $equipmentIds = [];
                    foreach ($ad['equipment'] as $label) {
                        $label = trim((string) $label);
                        if ($label === '') {
                            continue;
                        }

                        $equipment = Equipment::firstOrCreate(
                            ['name_it' => $label],
                            ['name' => $label, 'name_en' => $label],
                        );

                        $equipmentIds[] = $equipment->id;
                    }

                    if (! empty($equipmentIds)) {
                        $advertisement->equipments()->syncWithoutDetaching($equipmentIds);
                    }
                }

                $count++;

                $this->line('');
                $this->line("Imported Ad #{$count} → Advertisement ID {$advertisement->id}");
                $this->line('  Title: ' . ($ad['title'] ?? 'N/A'));
                $this->line('  Price: ' . ($ad['price'] ?? 'N/A'));
                $this->line('  URL:   ' . $ad['url']);
            }

            $this->info('');
            $this->info("Finished. Imported {$count} ad(s).");
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }

    /**
     * Create a minimal Advertisement record from Autoscout24 scraped data.
     */
    private function createAdvertisementFromAutoscout(array $data, Provider $provider, AdvertisementType $type): Advertisement
    {
        $title       = $data['title'] ?? null;
        $priceString = $data['price'] ?? null;
        $description = $data['description'] ?? null;
        $sourceUrl   = $data['url'] ?? null;

        // Parse numeric final_price from a string like "€ 4.290" or "€ 9.990,-".
        $finalPrice = null;
        if (is_string($priceString) && $priceString !== '') {
            $normalized = preg_replace('/[^\d]/', '', $priceString);
            if ($normalized !== '') {
                $finalPrice = (float) $normalized;
            }
        }

        $meta    = $data['meta'] ?? [];
        $cityRaw = $meta['city'] ?? null; // e.g. "Alessandria_AL"
        $zipRaw  = $meta['zip'] ?? null;  // e.g. "IT15121"

        $city = null;
        if (is_string($cityRaw) && $cityRaw !== '') {
            // Split "Alessandria_AL" → "Alessandria"
            $parts = explode('_', $cityRaw);
            $city = $parts[0] ?? $cityRaw;
        }

        $zipCode = null;
        if (is_string($zipRaw) && $zipRaw !== '') {
            // Strip potential country prefix like "IT15121".
            $zipCode = preg_replace('/^[A-Z]{2}/', '', $zipRaw);
        }

        // Brand and model mapping based on real Autoscout24 meta.
        $brandId        = null;
        $vehicleModelId = null;

        $brandName = $meta['brand'] ?? null;
        $modelName = $meta['model'] ?? null;

        if (is_string($brandName) && $brandName !== '') {
            $brand = \App\Models\Brand::firstOrCreate(
                ['name' => $brandName],
                ['name_en' => $brandName, 'name_it' => $brandName],
            );
            $brandId = $brand->id;

            if (is_string($modelName) && $modelName !== '') {
                $vehicleModel = \App\Models\VehicleModel::firstOrCreate(
                    ['name' => $modelName, 'brand_id' => $brand->id],
                    ['name_en' => $modelName, 'name_it' => $modelName],
                );
                $vehicleModelId = $vehicleModel->id;
            }
        }

        // Fuel type mapping based on real Autoscout24 fuel codes.
        $fuelTypeId = null;
        $fuelCode   = $meta['fuel_code'] ?? null; // e.g. 'B', 'D', 'E', 'H'
        if (is_string($fuelCode) && $fuelCode !== '') {
            $fuelNameIt = match ($fuelCode) {
                'B' => 'Benzina',
                'D' => 'Diesel',
                'E' => 'Elettrica',
                'H' => 'Ibrida',
                default => null,
            };

            if ($fuelNameIt !== null) {
                $fuelType = \App\Models\FuelType::firstOrCreate(
                    ['name_it' => $fuelNameIt],
                    ['name' => $fuelNameIt, 'name_en' => $fuelNameIt],
                );
                $fuelTypeId = $fuelType->id;
            }
        }

        // Power (kW / CV) based on real Autoscout24 meta.
        $powerKw = $meta['power_kw'] ?? null;
        $powerCv = $meta['power_cv'] ?? null;

        // Displacement based on real Autoscout24 meta (from "Cilindrata" field).
        $motorDisplacement = $meta['displacement_cc'] ?? null;

        // Gearbox description from real Autoscout24 gear code.
        $motorChange = null;
        $gearCode    = $meta['gear_code'] ?? null;
        if (is_string($gearCode) && $gearCode !== '') {
            $motorChange = match ($gearCode) {
                'M' => 'Manuale',
                'A' => 'Automatico',
                'S' => 'Semi-automatico',
                default => null,
            };
        }

        // Try to derive mileage, registration date and body type from description text
        // OR from detailed seller notes, preferring seller notes when available.
        // which often looks like:
        // "Chopper/Cruiser | € 4.290 | 14.418 km | 07/2020 | Benzina - ..."
        $mileage            = null;
        $registrationMonth  = null;
        $registrationYear   = null;
        $vehicleBodyId      = null;

        $specSource = $data['seller_notes'] ?? $description;

        if (is_string($specSource) && $specSource !== '') {
            // Mileage: "... 14.418 km ..."
            if (preg_match('/([0-9][0-9\.\s]*)\s*km/i', $specSource, $m)) {
                $mileageStr = preg_replace('/[^\d]/', '', $m[1]);
                if ($mileageStr !== '') {
                    $mileage = (int) $mileageStr;
                }
            }

            // Registration date: "... 07/2020 ..."
            if (preg_match('/\b(\d{2})\/(\d{4})\b/', $specSource, $m)) {
                $registrationMonth = $m[1];
                $registrationYear  = $m[2];
            }

            // Body type: text between ":" and first "|" after title,
            // e.g. "... Torino - To: Chopper/Cruiser | € 4.290 | ..."
            if (preg_match('/:\s*([^|]+)\|/', $description ?? '', $m)) {
                $bodyName = trim($m[1]);
                if ($bodyName !== '') {
                    $vehicleBody = \App\Models\VehicleBody::firstOrCreate(
                        ['name_it' => $bodyName],
                        ['name' => $bodyName, 'name_en' => $bodyName],
                    );
                    $vehicleBodyId = $vehicleBody->id;
                }
            }
        }

        // Color mapping based on the real color section text.
        $colorId = null;
        $colorName = $data['color'] ?? null; // e.g. "BLUE MARLIN"
        if (is_string($colorName) && $colorName !== '') {
            $vehicleColor = \App\Models\VehicleColor::firstOrCreate(
                ['name_it' => $colorName],
                ['name' => $colorName, 'name_en' => $colorName],
            );
            $colorId = $vehicleColor->id;
        }

        // Since this scraper is for "lst-moto", we know the vehicle category is Moto.
        $vehicleCategory = 'Moto';

        return Advertisement::create([
            'provider_id'               => $provider->id,
            'advertisement_type_id'     => $type->id,
            'brand_id'                  => $brandId,
            'vehicle_model_id'          => $vehicleModelId,
            'version_model'             => $title,
            'vehicle_body_id'           => $vehicleBodyId,
            'color_id'                  => $colorId,
            'is_metallic_paint'         => false,
            'vehicle_category'          => $vehicleCategory,
            'mileage'                   => $mileage,
            'registration_month'        => $registrationMonth,
            'registration_year'         => $registrationYear,
            'previous_owners'           => null,
            'next_review_year'          => null,
            'next_review_month'         => null,
            'last_service_year'         => null,
            'last_service_month'        => null,
            'motor_change'              => $motorChange,
            'motor_power_kw'            => $powerKw,
            'motor_power_cv'            => $powerCv,
            'motor_marches'             => null,
            'motor_cylinders'           => null,
            'motor_displacement'        => $motorDisplacement,
            'motor_empty_weight'        => null,
            'fuel_type_id'              => $fuelTypeId,
            'combined_fuel_consumption' => null,
            'co2_emissions'             => null,
            'emissions_class'           => null,
            'description'               => $description,
            'source_url'                => $sourceUrl,
            'price_negotiable'          => false,
            'tax_deductible'            => false,
            'final_price'               => $finalPrice,
            'zip_code'                  => $zipCode,
            'city'                      => $city,
            'international_prefix'      => null,
            'prefix'                    => null,
            'telephone'                 => null,
            'show_phone'                => false,
            'drive_type'                => null,
            'tank_capacity_liters'      => null,
            'seat_height_mm'            => null,
            'top_speed_kmh'             => null,
            'torque_nm'                 => null,
            'financing_available'       => false,
            'trade_in_possible'         => false,
            'service_history_available' => false,
            'warranty_available'        => false,
            'available_immediately'     => true,
            'is_verified'               => true,
        ]);
    }

    /**
     * Resolve or create a Provider record from Autoscout24 meta data.
     *
     * We use the real Autoscout24 dealer ID and city/zip so each external dealer
     * gets its own Provider in our system, based only on real data.
     */
    private function resolveProviderFromAutoscoutMeta(array $meta): Provider
    {
        $dealerId = $meta['dealer_id'] ?? null;
        $cityRaw  = $meta['city'] ?? null;
        $zipRaw   = $meta['zip'] ?? null;
        $contactName  = $meta['contact_name'] ?? null;
        $contactPhone = $meta['contact_phone'] ?? null;
        $contactEmail = $meta['contact_email'] ?? null;

        // Fallback key if dealer_id is missing.
        $username = $dealerId ? 'as24-' . $dealerId : null;

        $city = null;
        if (is_string($cityRaw) && $cityRaw !== '') {
            $parts = explode('_', $cityRaw);
            $city = $parts[0] ?? $cityRaw;
        }

        $zipCode = null;
        if (is_string($zipRaw) && $zipRaw !== '') {
            $zipCode = preg_replace('/^[A-Z]{2}/', '', $zipRaw);
        }

        if ($username) {
            $provider = Provider::firstOrCreate(
                ['username' => $username],
                [
                    // Name/location/phone/email are based on real Autoscout24 meta and seller notes.
                    'first_name' => is_string($contactName) ? trim($contactName) : null,
                    'last_name'  => null,
                    'email'      => $contactEmail,
                    'phone'      => $contactPhone,
                    'whatsapp'   => null,
                    'address'    => null,
                    'village'    => null,
                    'zip_code'   => $zipCode,
                    'city'       => $city,
                    'password'   => null,
                ]
            );

            // If provider existed before without contact details, fill them now.
            $dirty = false;
            if (! $provider->email && $contactEmail) {
                $provider->email = $contactEmail;
                $dirty = true;
            }
            if (! $provider->phone && $contactPhone) {
                $provider->phone = $contactPhone;
                $dirty = true;
            }
            if (! $provider->first_name && $contactName) {
                $provider->first_name = $contactName;
                $dirty = true;
            }
            if (! $provider->city && $city) {
                $provider->city = $city;
                $dirty = true;
            }
            if (! $provider->zip_code && $zipCode) {
                $provider->zip_code = $zipCode;
                $dirty = true;
            }
            if ($dirty) {
                $provider->save();
            }

            return $provider;
        }

        // If we truly have no meta, just fall back to the first provider (must be real, configured by you).
        $fallback = Provider::first();
        if ($fallback) {
            return $fallback;
        }

        // As a last resort, create a very generic provider without made-up personal data.
        return Provider::create([
            'username' => 'as24-generic',
            'first_name' => null,
            'last_name'  => null,
            'email'      => null,
            'phone'      => null,
            'whatsapp'   => null,
            'address'    => null,
            'village'    => null,
            'zip_code'   => null,
            'city'       => null,
            'password'   => null,
        ]);
    }

    /**
     * Resolve or create AdvertisementType from Autoscout24 meta.
     *
     * For now we only distinguish dealer vs private based on real "ad" meta.
     */
    private function resolveAdvertisementTypeFromAutoscoutMeta(array $meta): AdvertisementType
    {
        $sellerType = $meta['seller_type'] ?? null; // 'dealer' or 'private'

        $baseTitle = match ($sellerType) {
            'dealer'  => 'Dealer listing',
            'private' => 'Private listing',
            default   => 'Autoscout24 listing',
        };

        return AdvertisementType::firstOrCreate(
            ['title' => $baseTitle],
            [
                'title_en' => $baseTitle,
                'title_it' => $baseTitle,
            ]
        );
    }

    /**
     * If the given provider does not yet have an image, try to fetch a real
     * dealer logo from the Autoscout24 ad page using the headless helper script.
     */
    private function maybeAttachProviderLogo(Provider $provider, ?string $adUrl): void
    {
        if ($provider->hasMedia('image')) {
            return;
        }

        if (! $adUrl) {
            return;
        }

        $scriptPath = base_path('scripts/autoscout24-dealer-logo.js');
        if (! file_exists($scriptPath)) {
            $this->warn("Dealer logo script not found at {$scriptPath}, skipping provider logo import.");
            return;
        }

        $command = sprintf(
            'node %s %s 2>&1',
            escapeshellarg($scriptPath),
            escapeshellarg($adUrl),
        );

        $output = shell_exec($command);
        if ($output === null || trim($output) === '') {
            $this->warn("Dealer logo script returned empty output for provider {$provider->id}.");
            return;
        }

        $decoded = json_decode($output, true);
        if (! is_array($decoded) || ! isset($decoded['logoUrl']) || ! is_string($decoded['logoUrl']) || $decoded['logoUrl'] === '') {
            // Best-effort only; don't treat as error.
            return;
        }

        try {
            $provider
                ->addMediaFromUrl($decoded['logoUrl'])
                ->toMediaCollection('image');

            $this->line("  Attached dealer logo for provider {$provider->id}");
        } catch (\Throwable $e) {
            $this->warn("Failed to attach dealer logo for provider {$provider->id}: {$e->getMessage()}");
        }
    }
}
