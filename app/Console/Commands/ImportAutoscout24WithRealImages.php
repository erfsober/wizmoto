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

                // Resolve full gallery images using headless helper (Playwright) plus fallback images.
                $galleryImages = $this->resolveGalleryImagesForAd($ad['url'] ?? $url, $ad['images'] ?? []);

                // Attach up to 5 images to the 'covers' media collection.
                if (! empty($galleryImages)) {
                    $images = array_slice($galleryImages, 0, 5);

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

        // Gears and cylinders based on technical details section.
        $motorMarches    = $meta['motor_marches'] ?? null;
        $motorCylinders  = $meta['motor_cylinders'] ?? null;

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

        // Mileage and registration date based purely on structured Autoscout24 meta.
        $mileage           = $meta['mileage_km'] ?? null;
        $registrationMonth = $meta['reg_month'] ?? null;
        $registrationYear  = $meta['reg_year'] ?? null;

        // Body type based on structured "Carrozzeria" field, if present.
        $vehicleBodyId = null;
        $bodyName      = $meta['body_type'] ?? null; // e.g. "Scooter"
        if (is_string($bodyName) && $bodyName !== '') {
            $vehicleBody = \App\Models\VehicleBody::firstOrCreate(
                ['name_it' => $bodyName],
                ['name' => $bodyName, 'name_en' => $bodyName],
            );
            $vehicleBodyId = $vehicleBody->id;
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

        // Vehicle condition / category: map Autoscout24 "condition" (e.g. "used","new")
        // into your existing vehicle_category values ("Used", "Era", ...).
        $vehicleCategory = null;
        $condition       = $meta['condition'] ?? null;
        if (is_string($condition) && $condition !== '') {
            $cond = mb_strtolower($condition);
            if (str_contains($cond, 'used') || str_contains($cond, 'usato')) {
                $vehicleCategory = 'Used';
            } elseif (str_contains($cond, 'vintage') || str_contains($cond, 'classic') || str_contains($cond, 'epoca')) {
                $vehicleCategory = 'Era';
            }
        }

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
            'motor_marches'             => $motorMarches,
            'motor_cylinders'           => $motorCylinders,
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
        $dealerId      = $meta['dealer_id'] ?? null;
        $dealerName    = $meta['dealer_name'] ?? null;
        $dealerAddress = $meta['dealer_address'] ?? null;
        $dealerPageUrl = $meta['dealer_page_url'] ?? null;
        $cityRaw       = $meta['city'] ?? null;
        $zipRaw        = $meta['zip'] ?? null;
        $contactName   = $meta['contact_name'] ?? null;
        $contactPhone  = $meta['contact_phone'] ?? null;
        $contactEmail  = $meta['contact_email'] ?? null;

        $city = null;
        if (is_string($cityRaw) && $cityRaw !== '') {
            $parts = explode('_', $cityRaw);
            $city = $parts[0] ?? $cityRaw;
        }

        $zipCode = null;
        if (is_string($zipRaw) && $zipRaw !== '') {
            $zipCode = preg_replace('/^[A-Z]{2}/', '', $zipRaw);
        }

        // 1) If you already created this dealer manually in Wizmoto, REUSE it.
        //    We never touch its existing avatar or existing contact details.
        if (is_string($dealerName) && $dealerName !== '') {
            $existing = Provider::query()
                ->where(function ($q) use ($dealerName) {
                    $lower = mb_strtolower($dealerName);
                    $q->whereRaw('LOWER(first_name) = ?', [$lower])
                        ->orWhereRaw('LOWER(title) = ?', [$lower]);
                })
                ->when($city, fn ($q) => $q->where('city', $city))
                ->first();

            if ($existing) {
                // Optionally backfill only missing fields, NEVER overwrite.
                $dirty = false;
                if (! $existing->email && $contactEmail) {
                    $existing->email = $contactEmail;
                    if (! $existing->email_verified_at) {
                        $existing->email_verified_at = now();
                    }
                    $dirty = true;
                }
                if (! $existing->phone && $contactPhone) {
                    $existing->phone = $contactPhone;
                    $dirty = true;
                }
                if (! $existing->zip_code && $zipCode) {
                    $existing->zip_code = $zipCode;
                    $dirty = true;
                }
                if (! $existing->address && $dealerAddress) {
                    $existing->address = $dealerAddress;
                    $dirty = true;
                }
                if (! $existing->show_info_in_advertisement) {
                    $existing->show_info_in_advertisement = true;
                    $dirty = true;
                }
                if ($dirty) {
                    $existing->save();
                }

                return $existing;
            }
        }

        // 2) Otherwise, create/link a dedicated Autoscout24 provider keyed by dealer_id.
        $username = $dealerId ? 'as24-' . $dealerId : null;

        if ($username) {
            // Best-effort: enrich contact details from a headless "Mostra numero" click
            // on the first ad URL for this dealer, if present in the meta.
            $whatsappFromHeadless = null;
            // Prefer dealer page URL for "Mostra numero" if we have it,
            // otherwise fall back to the specific ad URL.
            $contactUrl = null;
            if (is_string($dealerPageUrl) && $dealerPageUrl !== '') {
                $contactUrl = $dealerPageUrl;
            } elseif (! empty($meta['first_ad_url']) && is_string($meta['first_ad_url'])) {
                $contactUrl = $meta['first_ad_url'];
            }

            if ($contactUrl) {
                $contact = $this->resolveRealtimeContactFromHeadless($contactUrl);
                if (is_array($contact)) {
                    $headlessPhone = $contact['phone'] ?? null;
                    $headlessWhatsapp = $contact['whatsapp'] ?? null;

                    // Prefer headless phone over static HTML seller-notes, if present.
                    if ($headlessPhone) {
                        $contactPhone = $headlessPhone;
                    }
                    if ($headlessWhatsapp) {
                        $whatsappFromHeadless = $headlessWhatsapp;
                    }
                }
            }

            $provider = Provider::firstOrCreate(
                ['username' => $username],
                [
                    // Use the real dealer/company name as the provider label.
                    'first_name' => is_string($dealerName) ? trim($dealerName) : null,
                    'last_name'  => null,
                    'email'      => $contactEmail,
                    'email_verified_at' => $contactEmail ? now() : null,
                    'phone'      => $contactPhone,
                    'whatsapp'   => $whatsappFromHeadless,
                    'address'    => $dealerAddress,
                    'village'    => null,
                    'zip_code'   => $zipCode,
                    'city'       => $city,
                    'show_info_in_advertisement' => true,
                    'password'   => null,
                ]
            );

            // If provider existed before without these details, backfill them from real data.
            $dirty = false;
            if (! $provider->email && $contactEmail) {
                $provider->email = $contactEmail;
                if (! $provider->email_verified_at) {
                    $provider->email_verified_at = now();
                }
                $dirty = true;
            }
            if (! $provider->phone && $contactPhone) {
                $provider->phone = $contactPhone;
                $dirty = true;
            }
            if (! $provider->whatsapp && ! empty($whatsappFromHeadless)) {
                $provider->whatsapp = $whatsappFromHeadless;
                $dirty = true;
            }
            if (! $provider->first_name && $dealerName) {
                $provider->first_name = $dealerName;
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
            if (! $provider->address && $dealerAddress) {
                $provider->address = $dealerAddress;
                $dirty = true;
            }
            if (! $provider->show_info_in_advertisement) {
                $provider->show_info_in_advertisement = true;
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
     * Resolve an AdvertisementType based on Autoscout24 body type,
     * using ONLY existing types from your seeder (e.g. "Motor Scooter",
     * "Motorcycle", "Scooter", "Bike").
     */
    private function resolveAdvertisementTypeFromAutoscoutMeta(array $meta): AdvertisementType
    {
        $bodyType = $meta['body_type'] ?? null; // e.g. "Scooter", "Enduro", ...

        // Default for motos if we can't detect anything better.
        $desiredTitle = 'Motorcycle';

        if (is_string($bodyType) && $bodyType !== '') {
            $bt = mb_strtolower($bodyType);

            if (str_contains($bt, 'scooter')) {
                // Prefer your explicit "Scooter" type when Carrozzeria contains "Scooter".
                $desiredTitle = 'Scooter';
            } elseif (str_contains($bt, 'bike')) {
                $desiredTitle = 'Bike';
            } elseif (str_contains($bt, 'motor')) {
                $desiredTitle = 'Motorcycle';
            }
        }

        // Try to find an existing type with this title.
        $type = AdvertisementType::where('title', $desiredTitle)->first();
        if ($type) {
            return $type;
        }

        // Fallback: return the first existing type, so we never break imports.
        $fallback = AdvertisementType::first();
        if ($fallback) {
            return $fallback;
        }

        // Last resort: create one using the desired title.
        return AdvertisementType::create(['title' => $desiredTitle]);
    }

    /**
     * Use the headless gallery helper to retrieve all visible listing-images
     * URLs for the given ad URL. Falls back to the static images scraped by PHP.
     *
     * @param string|null $adUrl
     * @param array<int, string> $fallbackImages
     * @return array<int, string>
     */
    private function resolveGalleryImagesForAd(?string $adUrl, array $fallbackImages): array
    {
        $images = [];

        if ($adUrl) {
            $scriptPath = base_path('scripts/autoscout24-gallery.js');
            if (! file_exists($scriptPath)) {
                $this->warn("Gallery script not found at {$scriptPath}, using fallback images only.");
            } else {
                $command = sprintf(
                    'node %s %s 2>&1',
                    escapeshellarg($scriptPath),
                    escapeshellarg($adUrl),
                );

                $output = shell_exec($command);
                if ($output === null || trim($output) === '') {
                    $this->warn("Gallery script returned empty output for ad URL {$adUrl}, using fallback images.");
                } else {
                    $decoded = json_decode($output, true);
                    if (is_array($decoded)) {
                        $images = array_values(
                            array_filter($decoded, fn ($v) => is_string($v) && trim($v) !== '')
                        );
                    }
                }
            }
        }

        // Merge with fallback static images (e.g. og:image) and de-duplicate.
        foreach ($fallbackImages as $img) {
            if (is_string($img) && trim($img) !== '') {
                $images[] = trim($img);
            }
        }

        $images = array_values(array_unique($images));

        // Final safety filter: keep only images that belong to the same listing id
        // as the first image (to avoid cross-listing thumbnails from recommendations).
        if (! empty($images)) {
            if (preg_match('#listing-images/([^_/]+)_#', $images[0], $m)) {
                $listingId = $m[1];
                $images = array_values(array_filter(
                    $images,
                    fn ($url) => is_string($url) && str_contains($url, "listing-images/{$listingId}_")
                ));
            }
        }

        return $images;
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

    /**
     * Use the headless contact helper to click "Mostra numero" on an ad page
     * and retrieve the real phone / WhatsApp contact, if available.
     *
     * @param string $adUrl
     * @return array{phone: string|null, whatsapp: string|null}|null
     */
    private function resolveRealtimeContactFromHeadless(string $adUrl): ?array
    {
        $scriptPath = base_path('scripts/autoscout24-contact.js');
        if (! file_exists($scriptPath)) {
            $this->warn("Contact script not found at {$scriptPath}, skipping realtime contact import.");
            return null;
        }

        $command = sprintf(
            'node %s %s 2>&1',
            escapeshellarg($scriptPath),
            escapeshellarg($adUrl),
        );

        $output = shell_exec($command);
        if ($output === null || trim($output) === '') {
            $this->warn("Contact script returned empty output for ad URL {$adUrl}.");
            return null;
        }

        $decoded = json_decode($output, true);
        if (! is_array($decoded)) {
            return null;
        }

        $phone = isset($decoded['phone']) && is_string($decoded['phone']) && $decoded['phone'] !== ''
            ? $decoded['phone']
            : null;
        $whatsapp = isset($decoded['whatsapp']) && is_string($decoded['whatsapp']) && $decoded['whatsapp'] !== ''
            ? $decoded['whatsapp']
            : null;

        return [
            'phone' => $phone,
            'whatsapp' => $whatsapp,
        ];
    }
}
