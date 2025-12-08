<?php

namespace App\Console\Commands;

use App\Models\Advertisement;
use App\Models\AdvertisementType;
use App\Models\Equipment;
use App\Models\FuelType;
use App\Models\VehicleBody;
use App\Models\VehicleColor;
use App\Services\OpenAiService;
use Illuminate\Console\Command;

class TranslateAutoscout24Ads extends Command
{
    protected $signature = 'translate:autoscout24-ads';
    protected $description = 'Translate Italian values from Autoscout24 imported ads to English using OpenAI';

    public function __construct(
        private readonly OpenAiService $openAiService,
    ) {
        parent::__construct();
    }

    public function handle()
    {
        $autoscoutAds = Advertisement::where('source_url', 'like', '%autoscout24.it%')
            ->orWhere('source_url', 'like', '%autoscout24%')
            ->get();

        if ($autoscoutAds->isEmpty()) {
            return;
        }

        $this->translateFuelTypes($autoscoutAds);
        $this->translateVehicleBodies($autoscoutAds);
        $this->translateEquipment($autoscoutAds);
        $this->translateColors($autoscoutAds);
        $this->translateAdvertisementFields($autoscoutAds);
        $this->translateDescriptions($autoscoutAds);
    }

    private function translateFuelTypes($ads): void
    {
        $fuelTypeIds = $ads->pluck('fuel_type_id')->filter()->unique();
        $fuelTypes = FuelType::whereIn('id', $fuelTypeIds)
            ->whereNotNull('name_it')
            ->where(function ($q) {
                $q->whereNull('name')->orWhereRaw('name = name_it');
            })
            ->get();

        foreach ($fuelTypes as $index => $fuelType) {
            if ($index > 0) usleep(500000);
            $translated = $this->translateText($fuelType->name_it, 'fuel type');
            if ($translated && $translated !== $fuelType->name_it) {
                $fuelType->name = $translated;
                $fuelType->save();
            }
        }
    }

    private function translateVehicleBodies($ads): void
    {
        $bodyIds = $ads->pluck('vehicle_body_id')->filter()->unique();

        $bodies = VehicleBody::whereIn('id', $bodyIds)
            ->whereNotNull('name_it')
            ->where(function ($q) {
                $q->whereNull('name')->orWhereRaw('name = name_it');
            })
            ->get();

        foreach ($bodies as $index => $body) {
            if ($index > 0) usleep(500000);
            $updated = false;
            $translated = $this->translateText($body->name_it, 'vehicle body type');
            if ($translated && $translated !== $body->name_it) {
                $body->name = $translated;
                $updated = true;
            }
            if ($body->advertisement_type_id === null) {
                $adTypeId = $this->getAdvertisementTypeIdForBody($body->name_it ?: $body->name);
                if ($adTypeId) {
                    $body->advertisement_type_id = $adTypeId;
                    $updated = true;
                }
            }
            if ($updated) $body->save();
        }
    }

    private function getAdvertisementTypeIdForBody(string $bodyName): ?int
    {
        $bodyNameLower = mb_strtolower(trim($bodyName));
        
        // Load advertisement types once
        static $adTypes = null;
        if ($adTypes === null) {
            $adTypes = [
                'Motor Scooter' => AdvertisementType::where('title', 'Motor Scooter')->first()?->id,
                'Motorcycle' => AdvertisementType::where('title', 'Motorcycle')->first()?->id,
                'Scooter' => AdvertisementType::where('title', 'Scooter')->first()?->id,
                'Bike' => AdvertisementType::where('title', 'Bike')->first()?->id,
            ];
        }

        // Motor Scooter category
        if (str_contains($bodyNameLower, 'motor scooter') || 
            str_contains($bodyNameLower, 'motorscooter') ||
            str_contains($bodyNameLower, 'maxi scooter') ||
            str_contains($bodyNameLower, 'maxiscooter')) {
            return $adTypes['Motor Scooter'];
        }

        // Scooter category
        if (str_contains($bodyNameLower, 'scooter') && !str_contains($bodyNameLower, 'motor')) {
            return $adTypes['Scooter'];
        }

        // Bike category (mopeds, bicycles, e-bikes)
        if (str_contains($bodyNameLower, 'ciclomotori') ||
            str_contains($bodyNameLower, 'moped') ||
            str_contains($bodyNameLower, 'bike') ||
            str_contains($bodyNameLower, 'bicicletta') ||
            str_contains($bodyNameLower, 'e-bike') ||
            str_contains($bodyNameLower, 'ebike') ||
            str_contains($bodyNameLower, 'electric bike')) {
            return $adTypes['Bike'];
        }

        // Motorcycle category (everything else - enduro, naked, sport, touring, etc.)
        if (str_contains($bodyNameLower, 'enduro') ||
            str_contains($bodyNameLower, 'naked') ||
            str_contains($bodyNameLower, 'sport') ||
            str_contains($bodyNameLower, 'touring') ||
            str_contains($bodyNameLower, 'cruiser') ||
            str_contains($bodyNameLower, 'custom') ||
            str_contains($bodyNameLower, 'adventure') ||
            str_contains($bodyNameLower, 'superbike') ||
            str_contains($bodyNameLower, 'supersport') ||
            str_contains($bodyNameLower, 'crossover') ||
            str_contains($bodyNameLower, 'motard') ||
            str_contains($bodyNameLower, 'trial') ||
            str_contains($bodyNameLower, 'chopper') ||
            str_contains($bodyNameLower, 'bobber') ||
            str_contains($bodyNameLower, 'cafe racer') ||
            str_contains($bodyNameLower, 'scrambler') ||
            str_contains($bodyNameLower, 'classic') ||
            str_contains($bodyNameLower, 'vintage') ||
            str_contains($bodyNameLower, 'racing') ||
            str_contains($bodyNameLower, 'street') ||
            str_contains($bodyNameLower, 'off-road') ||
            str_contains($bodyNameLower, 'dual sport') ||
            str_contains($bodyNameLower, 'motocicletta') ||
            str_contains($bodyNameLower, 'motoveicolo') ||
            str_contains($bodyNameLower, 'motorcycle')) {
            return $adTypes['Motorcycle'];
        }

        // Default to Motorcycle if unclear
        return $adTypes['Motorcycle'];
    }

    private function translateEquipment($ads): void
    {
        $equipmentIds = [];
        foreach ($ads as $ad) {
            $equipmentIds = array_merge($equipmentIds, $ad->equipments()->pluck('equipment_id')->toArray());
        }
        $equipmentIds = array_unique($equipmentIds);

        if (empty($equipmentIds)) return;

        $equipments = Equipment::whereIn('id', $equipmentIds)
            ->whereNotNull('name_it')
            ->where(function ($q) {
                $q->whereNull('name')->orWhereRaw('name = name_it');
            })
            ->get();

        // Get advertisement type IDs from ads that use this equipment
        $equipmentToAdTypeMap = [];
        foreach ($ads as $ad) {
            foreach ($ad->equipments()->pluck('equipment_id')->toArray() as $equipmentId) {
                if ($ad->advertisement_type_id) {
                    if (!isset($equipmentToAdTypeMap[$equipmentId])) {
                        $equipmentToAdTypeMap[$equipmentId] = [];
                    }
                    $equipmentToAdTypeMap[$equipmentId][] = $ad->advertisement_type_id;
                }
            }
        }

        foreach ($equipments as $index => $equipment) {
            if ($index > 0) usleep(500000);
            $updated = false;
            $translated = $this->translateText($equipment->name_it, 'motorcycle equipment');
            if ($translated && $translated !== $equipment->name_it) {
                $equipment->name = $translated;
                $updated = true;
            }
            if ($equipment->advertisement_type_id === null && isset($equipmentToAdTypeMap[$equipment->id])) {
                // Use the most common advertisement_type_id from ads that use this equipment
                $counts = array_count_values($equipmentToAdTypeMap[$equipment->id]);
                $equipment->advertisement_type_id = array_search(max($counts), $counts);
                $updated = true;
            }
            if ($updated) $equipment->save();
        }
    }

    private function translateColors($ads): void
    {
        $colorIds = $ads->pluck('color_id')->filter()->unique();
        $colors = VehicleColor::whereIn('id', $colorIds)
            ->whereNotNull('name_it')
            ->where(function ($q) {
                $q->whereNull('name')->orWhereRaw('name = name_it');
            })
            ->get();

        foreach ($colors as $index => $color) {
            if ($index > 0) usleep(500000);
            $translated = $this->translateText($color->name_it, 'vehicle color');
            if ($translated && $translated !== $color->name_it) {
                $color->name = $translated;
                $color->save();
            }
        }
    }

    private function translateAdvertisementFields($ads): void
    {
        $quickTranslations = [
            'motor_change' => ['Automatico' => 'Automatic', 'Manuale' => 'Manual', 'Semi-automatico' => 'Semi-automatic'],
            'vehicle_category' => ['Usato' => 'Used', 'Nuovo' => 'New', 'Epoca' => 'Era', 'Classico' => 'Classic'],
        ];

        foreach ($ads as $index => $ad) {
            if ($index > 0) usleep(500000);
            $updated = false;

            if ($ad->motor_change && $this->isItalianText($ad->motor_change)) {
                $translated = $quickTranslations['motor_change'][$ad->motor_change] ?? $this->translateText($ad->motor_change, 'transmission type');
                if ($translated && $translated !== $ad->motor_change) {
                    $ad->motor_change = $translated;
                    $updated = true;
                }
            }

            if ($ad->vehicle_category && $this->isItalianText($ad->vehicle_category)) {
                $translated = $quickTranslations['vehicle_category'][$ad->vehicle_category] ?? $this->translateText($ad->vehicle_category, 'vehicle condition');
                if ($translated && $translated !== $ad->vehicle_category) {
                    $ad->vehicle_category = $translated;
                    $updated = true;
                }
            }

            if ($ad->emissions_class && $this->isItalianText($ad->emissions_class)) {
                $translated = $this->translateText($ad->emissions_class, 'emissions class');
                if ($translated && $translated !== $ad->emissions_class) {
                    $ad->emissions_class = $translated;
                    $updated = true;
                }
            }

            if ($updated) $ad->save();
        }
    }

    private function translateDescriptions($ads): void
    {
        foreach ($ads as $index => $ad) {
            if ($index > 0) usleep(1000000); // 1 second delay for longer text
            
            if ($ad->description && $this->isItalianText($ad->description)) {
                $translated = $this->translateDescription($ad->description);
                if ($translated && $translated !== $ad->description) {
                    $ad->description = $translated;
                    $ad->save();
                }
            }
        }
    }

    private function translateDescription(string $italianText): ?string
    {
        try {
            $prompt = "Translate the following Italian vehicle advertisement description to English. Keep the same tone and format. Return ONLY the English translation, nothing else.\n\nItalian description: {$italianText}";

            try {
                $translated = $this->openAiService->setTemperature(0.3)->generateResponseWithoutProcess($prompt);
            } catch (\Exception $e) {
                if (str_contains($e->getMessage(), 'temperature') || str_contains($e->getMessage(), 'unsupported')) {
                    $translated = $this->openAiService->setTemperature(1.0)->generateResponseWithoutProcess($prompt);
                } else {
                    throw $e;
                }
            }

            $translated = trim($translated);
            return $translated ?: null;
        } catch (\Exception $e) {
            return null;
        }
    }

    private function isItalianText(string $text): bool
    {
        $text = trim($text);
        if (empty($text)) return false;

        $italianPatterns = [
            'automatico', 'manuale', 'semi-automatico', 'usato', 'nuovo', 'epoca', 'classico',
            'euro', 'benzina', 'diesel', 'elettrica', 'ibrida',
            'nero', 'bianco', 'rosso', 'blu', 'verde', 'giallo',
            'grigio', 'argento', 'oro', 'marrone', 'arancione',
            'scooter', 'enduro', 'naked', 'sport', 'touring',
            'ciclomotori', 'motocicletta', 'motoveicolo'
        ];

        $lowerText = mb_strtolower($text);
        foreach ($italianPatterns as $pattern) {
            if (str_contains($lowerText, $pattern)) return true;
        }

        $italianEndings = ['o', 'a', 'i', 'e'];
        $lastChar = mb_substr($lowerText, -1);
        if (in_array($lastChar, $italianEndings) && strlen($text) > 3) {
            $knownItalianValues = ['automatico', 'manuale', 'semi-automatico', 'usato', 'nuovo', 'epoca'];
            if (in_array($lowerText, $knownItalianValues)) return true;
        }

        return false;
    }

    private function translateText(string $italianText, string $context = ''): ?string
    {
        try {
            $prompt = "Translate the following Italian {$context} term to English. Return ONLY the English translation, nothing else. If it's already in English or a brand name, return it as-is.\n\nItalian term: {$italianText}";

            try {
                $translated = $this->openAiService->setTemperature(0.3)->generateResponseWithoutProcess($prompt);
            } catch (\Exception $e) {
                if (str_contains($e->getMessage(), 'temperature') || str_contains($e->getMessage(), 'unsupported')) {
                    $translated = $this->openAiService->setTemperature(1.0)->generateResponseWithoutProcess($prompt);
                } else {
                    throw $e;
                }
            }

            $translated = trim(trim(trim($translated), '"\''));
            return $translated ?: null;
        } catch (\Exception $e) {
            return null;
        }
    }
}
