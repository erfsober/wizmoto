<?php

namespace App\Http\Controllers\Wizmoto;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\AdvertisementType;
use App\Models\BlogPost;
use App\Models\Brand;
use App\Models\Equipment;
use App\Models\FuelType;
use App\Models\VehicleBody;
use App\Models\VehicleColor;
use App\Models\VehicleModel;
use App\Services\GeocodingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index()
    {
        $newAdvertisements = Advertisement::query()
            ->with(['brand', 'vehicleModel', 'equipments'])
            ->latest()
            ->limit(12)
            ->get();

        $brands = Brand::all();
        $vehicleModels = VehicleModel::with('Brand')->select('id', 'name', 'brand_id')->get();
        $advertisementTypes = AdvertisementType::all();
        $fuelTypes = FuelType::all();
        $vehicleBodies = VehicleBody::all();
        $vehicleColors = VehicleColor::query()
            ->get();
        $equipments = Equipment::query()
            ->get();
        $latestPosts = BlogPost::with('blogCategory')
            ->where('published', true)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('wizmoto.home.index', compact('newAdvertisements','latestPosts', 'brands', 'vehicleModels', 'advertisementTypes', 'fuelTypes', 'vehicleBodies', 'vehicleColors', 'equipments'));
    }

    public function inventoryList(Request $request)
    {
        // Get brands based on advertisement type filter
        $brandsQuery = Brand::select('id', 'name', 'advertisement_type_id');
        
        // If filtering by advertisement type, show only relevant brands
        if ($request->filled('advertisement_type')) {
            $brandsQuery->where('advertisement_type_id', $request->advertisement_type);
        }
        
        $brands = $brandsQuery->orderBy('name')->get();
        $vehicleModels = VehicleModel::with('Brand')->select('id', 'name', 'brand_id')->get();
        $advertisementTypes = AdvertisementType::all();
        $fuelTypes = FuelType::all();
        $vehicleBodies = VehicleBody::all();
        $vehicleColors = VehicleColor::query()
            ->get();
        $equipments = Equipment::query()
            ->get();
        $advertisements = Advertisement::query()
            ->with([
                'brand',
                'vehicleModel',
                'vehicleBody',
                'vehicleColor',
                'fuelType',
                'equipments',
            ])
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    $query->where('description', 'like', "%{$request->search}%")
                        ->orWhere('city', 'like', "%{$request->search}%")
                        ->orWhere('zip_code', 'like', "%{$request->search}%")
                        ->orWhereHas('brand', fn($q2) => $q2->where('name', 'like', "%{$request->search}%"))
                        ->orWhereHas('vehicleModel', fn($q2) => $q2->where('name', 'like', "%{$request->search}%"));
                });
            })
            
            // LOCATION FILTERS
            ->when($request->filled('city'), fn($q) => $q->where('city', $request->city))
            ->when($request->filled('zip_code'), fn($q) => $q->where('zip_code', $request->zip_code))
            
            // SEARCH RADIUS FILTER
            ->when($request->filled('search_radius') && ($request->filled('city') || $request->filled('zip_code')), function ($q) use ($request) {
                $validation = $this->validateSearchRadius($request);
                
                if ($validation['valid']) {
                    $searchLocation = $this->getSearchLocationCoordinates($request);
                    
                    if ($searchLocation) {
                        $latitude = $searchLocation['latitude'];
                        $longitude = $searchLocation['longitude'];
                        $radius = $validation['search_radius'];
                        
                        // Only search advertisements that have coordinates
                        $q->whereNotNull('latitude')
                          ->whereNotNull('longitude')
                          ->whereRaw("
                            (6371 * acos(
                                cos(radians(?)) 
                                * cos(radians(latitude)) 
                                * cos(radians(longitude) - radians(?)) 
                                + sin(radians(?)) 
                                * sin(radians(latitude))
                            )) <= ?
                        ", [$latitude, $longitude, $latitude, $radius]);
                    }
                }
            })
            
            // VEHICLE BASIC DATA
            ->when($request->filled('vehicle_category'), fn($q) => $q->whereIn('vehicle_category', (array)$request->vehicle_category))
            ->when($request->filled('vehicle_body_id'), fn($q) => $q->whereIn('vehicle_body_id', (array)$request->vehicle_body_id))
            ->when($request->filled('seller_type'), fn($q) => $q->whereIn('seller_type', (array)$request->seller_type))
            
            // BRAND/MODEL (support multiple vehicle groups)
            ->when($request->filled('brand_id'), function ($q) use ($request) {
                $brandIds = is_array($request->brand_id) ? $request->brand_id : [$request->brand_id];
                $q->whereIn('brand_id', array_filter($brandIds));
            })
            ->when($request->filled('vehicle_model_id'), function ($q) use ($request) {
                $modelIds = is_array($request->vehicle_model_id) ? $request->vehicle_model_id : [$request->vehicle_model_id];
                $q->whereIn('vehicle_model_id', array_filter($modelIds));
            })
            
            // VERSION FILTER
            ->when($request->filled('versions'), function ($q) use ($request) {
                $versions = is_array($request->versions) ? $request->versions : [$request->versions];
                $q->where(function($query) use ($versions) {
                    foreach ($versions as $version) {
                        $query->orWhere('version_model', 'like', "%{$version}%");
                    }
                });
            })
            
            // YEAR RANGE
            ->when($request->filled('registration_year_from'), fn($q) => $q->where(DB::raw('CAST(registration_year AS UNSIGNED)'), '>=', (int)$request->registration_year_from))
            ->when($request->filled('registration_year_to'), fn($q) => $q->where(DB::raw('CAST(registration_year AS UNSIGNED)'), '<=', (int)$request->registration_year_to))
            // Legacy support
            ->when($request->filled('min_year'), fn($q) => $q->where(DB::raw('CAST(registration_year AS UNSIGNED)'), '>=', (int)$request->min_year))
            ->when($request->filled('max_year'), fn($q) => $q->where(DB::raw('CAST(registration_year AS UNSIGNED)'), '<=', (int)$request->max_year))
            
            // MILEAGE RANGE
            ->when($request->filled('mileage_from'), fn($q) => $q->where('mileage', '>=', (int)$request->mileage_from))
            ->when($request->filled('mileage_to'), fn($q) => $q->where('mileage', '<=', (int)$request->mileage_to))
            // Legacy support
            ->when($request->filled('mileage_min'), fn($q) => $q->where('mileage', '>=', (int)$request->mileage_min))
            ->when($request->filled('mileage_max'), fn($q) => $q->where('mileage', '<=', (int)$request->mileage_max))
            
            // POWER RANGES
            ->when($request->filled('power_cv_from'), fn($q) => $q->where('motor_power_cv', '>=', (int)$request->power_cv_from))
            ->when($request->filled('power_cv_to'), fn($q) => $q->where('motor_power_cv', '<=', (int)$request->power_cv_to))
            ->when($request->filled('power_kw_from'), fn($q) => $q->where('motor_power_kw', '>=', (int)$request->power_kw_from))
            ->when($request->filled('power_kw_to'), fn($q) => $q->where('motor_power_kw', '<=', (int)$request->power_kw_to))
            
            // ENGINE SPECIFICATIONS
            ->when($request->filled('motor_displacement_from'), fn($q) => $q->where('motor_displacement', '>=', (int)$request->motor_displacement_from))
            ->when($request->filled('motor_displacement_to'), fn($q) => $q->where('motor_displacement', '<=', (int)$request->motor_displacement_to))
            ->when($request->filled('cylinders'), fn($q) => $q->where('motor_cylinders', $request->cylinders))
            
            // DRIVE TYPE
            ->when($request->filled('drive_type'), fn($q) => $q->whereIn('drive_type', (array)$request->drive_type))
            
            // TECHNICAL SPECIFICATIONS
            ->when($request->filled('tank_capacity_from'), fn($q) => $q->where('tank_capacity_liters', '>=', (float)$request->tank_capacity_from))
            ->when($request->filled('tank_capacity_to'), fn($q) => $q->where('tank_capacity_liters', '<=', (float)$request->tank_capacity_to))
            ->when($request->filled('seat_height_from'), fn($q) => $q->where('seat_height_mm', '>=', (int)$request->seat_height_from))
            ->when($request->filled('seat_height_to'), fn($q) => $q->where('seat_height_mm', '<=', (int)$request->seat_height_to))
            ->when($request->filled('top_speed_from'), fn($q) => $q->where('top_speed_kmh', '>=', (int)$request->top_speed_from))
            ->when($request->filled('top_speed_to'), fn($q) => $q->where('top_speed_kmh', '<=', (int)$request->top_speed_to))
            ->when($request->filled('torque_from'), fn($q) => $q->where('torque_nm', '>=', (int)$request->torque_from))
            ->when($request->filled('torque_to'), fn($q) => $q->where('torque_nm', '<=', (int)$request->torque_to))
            
            // TRANSMISSION
            ->when($request->filled('motor_change'), fn($q) => $q->whereIn('motor_change', (array)$request->motor_change))
            
            // PRICE RANGE
            ->when($request->filled('price_from'), fn($q) => $q->where(DB::raw('CAST(final_price AS DECIMAL(12,2))'), '>=', (float)$request->price_from))
            ->when($request->filled('price_to'), fn($q) => $q->where(DB::raw('CAST(final_price AS DECIMAL(12,2))'), '<=', (float)$request->price_to))
            // Legacy support
            ->when($request->filled('min_price'), fn($q) => $q->where(DB::raw('CAST(final_price AS DECIMAL(12,2))'), '>=', (float)$request->min_price))
            ->when($request->filled('max_price'), fn($q) => $q->where(DB::raw('CAST(final_price AS DECIMAL(12,2))'), '<=', (float)$request->max_price))
            
            // FUEL TYPE
            ->when($request->filled('fuel_type_id'), fn($q) => $q->whereIn('fuel_type_id', (array)$request->fuel_type_id))
            
            // COLORS
            ->when($request->filled('color_ids'), fn($q) => $q->whereIn('color_id', (array)$request->color_ids))
            ->when($request->filled('color_id'), fn($q) => $q->whereIn('color_id', (array)$request->color_id)) // Legacy support
            ->when($request->filled('is_metallic_paint'), fn($q) => $q->where('is_metallic_paint', true))
            
            // EQUIPMENT
            ->when($request->filled('equipments'), function ($q) use ($request) {
                $q->whereHas('equipments', function ($qq) use ($request) {
                    $qq->whereIn('equipment_id', (array)$request->equipments);
                });
            })
            ->when($request->filled('equipment'), function ($q) use ($request) { // Legacy support
                $q->whereHas('equipments', function ($qq) use ($request) {
                    $qq->whereIn('equipment_id', (array)$request->equipment);
                });
            })
            
            // VEHICLE CONDITIONS
            ->when($request->filled('previous_owners'), fn($q) => $q->where('previous_owners', '<=', (int)$request->previous_owners))
            ->when($request->filled('previous_owners_filter'), fn($q) => $q->where('previous_owners', '<=', (int)$request->previous_owners_filter))
            ->when($request->filled('price_negotiable'), fn($q) => $q->where('price_negotiable', true))
            ->when($request->filled('tax_deductible'), fn($q) => $q->where('tax_deductible', true))
            ->when($request->filled('damaged_vehicle'), fn($q) => $q->where('damaged_vehicle', true))
            ->when($request->filled('coupon_documentation'), fn($q) => $q->where('coupon_documentation', true))
            
            // SALES FEATURES
            ->when($request->filled('first_owner'), fn($q) => $q->where('first_owner', true))
            ->when($request->filled('service_history_available'), fn($q) => $q->where('service_history_available', true))
            ->when($request->filled('warranty_available'), fn($q) => $q->where('warranty_available', true))
            ->when($request->filled('financing_available'), fn($q) => $q->where('financing_available', true))
            ->when($request->filled('trade_in_possible'), fn($q) => $q->where('trade_in_possible', true))
            ->when($request->filled('available_immediately'), fn($q) => $q->where('available_immediately', true))
            
            // LOCATION FILTERS
            ->when($request->filled('city'), fn($q) => $q->where('city', 'like', "%{$request->city}%"))
            ->when($request->filled('zip_code'), fn($q) => $q->where('zip_code', 'like', "%{$request->zip_code}%"))
            
            // ONLINE PERIOD
            ->when($request->filled('online_from_period'), function ($q) use ($request) {
                $period = (int)$request->online_from_period;
                $date = now()->subDays($period);
                $q->where('created_at', '>=', $date);
            })
            
            // ENVIRONMENT
            ->when($request->filled('emissions_class'), fn($q) => $q->whereIn('emissions_class', (array)$request->emissions_class))
            ->when($request->filled('co2_emissions_from'), fn($q) => $q->where('co2_emissions', '>=', (int)$request->co2_emissions_from))
            ->when($request->filled('co2_emissions_to'), fn($q) => $q->where('co2_emissions', '<=', (int)$request->co2_emissions_to))
            ->when($request->filled('fuel_consumption_from'), fn($q) => $q->where('combined_fuel_consumption', '>=', (float)$request->fuel_consumption_from))
            ->when($request->filled('fuel_consumption_to'), fn($q) => $q->where('combined_fuel_consumption', '<=', (float)$request->fuel_consumption_to))
            
            // MORE INFORMATION
            ->when($request->filled('online_from'), function ($q) use ($request) {
                $daysAgo = match($request->online_from) {
                    '1_day' => 1,
                    '3_days' => 3,
                    '7_days' => 7,
                    '14_days' => 14,
                    '30_days' => 30,
                    default => null
                };
                if ($daysAgo) {
                    $q->where('created_at', '>=', now()->subDays($daysAgo));
                }
            })
            
            ->latest('id')
            ->paginate(10);

        // Debug logging
        \Log::info('Advertisement type filter applied: ' . ($request->advertisement_type ?? 'none'));
        \Log::info('Total advertisements found: ' . $advertisements->total());

        // If it's an AJAX request for brands only, return just the brands
        if ($request->ajax() && $request->has('get_brands_only')) {
            return response()->json([
                'brands' => $brands->toArray()
            ]);
        }

        // If it's an AJAX request for fuel types only, return just the fuel types
        if ($request->ajax() && $request->has('get_fuel_types_only')) {
            $fuelTypes = collect();
            
            if ($request->filled('advertisement_type')) {
                $fuelTypes = FuelType::where('advertisement_type_id', $request->advertisement_type)
                    ->orderBy('name')
                    ->get();
            } else {
                // If no advertisement type specified, return all fuel types
                $fuelTypes = FuelType::orderBy('name')->get();
            }
            
            return response()->json([
                'fuel_types' => $fuelTypes->toArray()
            ]);
        }

        // If it's an AJAX request, return JSON with HTML and pagination info
        if ($request->ajax()) {
            $html = view('wizmoto.home.partials.vehicle-cards', compact('advertisements'))->render();
            return response()->json([
                'html' => $html,
                'pagination' => [
                    'first_item' => $advertisements->firstItem(),
                    'last_item' => $advertisements->lastItem(),
                    'total' => $advertisements->total(),
                    'current_page' => $advertisements->currentPage(),
                    'per_page' => $advertisements->perPage(),
                    'has_pages' => $advertisements->hasPages()
                ]
            ]);
        }

        return view('wizmoto.home.inventory-list', compact('advertisements', 'brands', 'vehicleModels', 'advertisementTypes', 'fuelTypes', 'vehicleBodies', 'vehicleColors', 'equipments', 'request'));
    }

    /**
     * Validate search radius parameters
     */
    private function validateSearchRadius(Request $request): array
    {
        $validator = Validator::make($request->all(), [
            'search_radius' => 'nullable|numeric|min:1|max:1000',
            'city' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return [
                'valid' => false,
                'errors' => $validator->errors()
            ];
        }

        return [
            'valid' => true,
            'search_radius' => $request->filled('search_radius') ? (float) $request->search_radius : null,
            'city' => $request->filled('city') ? $request->city : null,
            'zip_code' => $request->filled('zip_code') ? $request->zip_code : null,
        ];
    }

    /**
     * Calculate distance between two coordinates using Haversine formula
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2): float
    {
        $earthRadius = 6371; // Earth's radius in kilometers

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat/2) * sin($dLat/2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon/2) * sin($dLon/2);

        $c = 2 * atan2(sqrt($a), sqrt(1-$a));

        return $earthRadius * $c;
    }

    /**
     * Get coordinates for search location (city or postal code)
     */
    private function getSearchLocationCoordinates(Request $request): ?array
    {
        $city = $request->filled('city') ? $request->city : null;
        $zipCode = $request->filled('zip_code') ? $request->zip_code : null;
        
        if (!$city && !$zipCode) {
            return null;
        }

        // Try to find existing advertisement with same city/zip to get coordinates
        $existingAd = Advertisement::query()
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->when($city, fn($q) => $q->where('city', 'like', "%{$city}%"))
            ->when($zipCode, fn($q) => $q->where('zip_code', $zipCode))
            ->first();

        if ($existingAd) {
            return [
                'latitude' => $existingAd->latitude,
                'longitude' => $existingAd->longitude,
                'source' => 'existing_advertisement'
            ];
        }

        // If no existing coordinates found, use geocoding service
        if ($city || $zipCode) {
            $geocodingService = app(GeocodingService::class);
            // If only zip code is provided, use it as the city parameter
            $cityForGeocoding = $city ?: $zipCode;
            return $geocodingService->geocode($cityForGeocoding, $zipCode);
        }
        
        return null;
    }

    /**
     * Get advertisements with distance information for a given location
     */
    public function getAdvertisementsWithDistance($latitude, $longitude, $limit = 10)
    {
        return Advertisement::query()
            ->with([
                'brand',
                'vehicleModel',
                'vehicleBody',
                'vehicleColor',
                'fuelType',
                'equipments',
            ])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->selectRaw("
                *,
                (6371 * acos(
                    cos(radians(?)) 
                    * cos(radians(latitude)) 
                    * cos(radians(longitude) - radians(?)) 
                    + sin(radians(?)) 
                    * sin(radians(latitude))
                )) AS distance
            ", [$latitude, $longitude, $latitude])
            ->orderBy('distance')
            ->limit($limit)
            ->get();
    }

    /**
     * Get advertisements by city/zip code with radius search
     */
    public function getAdvertisementsByLocationWithRadius($city = null, $zipCode = null, $radius = 50, $limit = 10)
    {
        $geocodingService = app(GeocodingService::class);
        $searchLocation = $geocodingService->geocode($city, $zipCode);
        
        if (!$searchLocation) {
            return collect();
        }

        return Advertisement::query()
            ->with([
                'brand',
                'vehicleModel',
                'vehicleBody',
                'vehicleColor',
                'fuelType',
                'equipments',
            ])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->selectRaw("
                *,
                (6371 * acos(
                    cos(radians(?)) 
                    * cos(radians(latitude)) 
                    * cos(radians(longitude) - radians(?)) 
                    + sin(radians(?)) 
                    * sin(radians(latitude))
                )) AS distance
            ", [$searchLocation['latitude'], $searchLocation['longitude'], $searchLocation['latitude']])
            ->having('distance', '<=', $radius)
            ->orderBy('distance')
            ->limit($limit)
            ->get();
    }

    /**
     * Load more equipment items via AJAX
     */
    public function loadMoreEquipment(Request $request)
    {
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 10);
        
        $equipments = Equipment::query()
            ->skip($offset)
            ->take($limit)
            ->get();
        
        $html = '';
        foreach ($equipments as $equipment) {
            $html .= '<label class="equipment-item">
                <input type="checkbox" name="equipments[]" value="' . $equipment->id . '">
                <span class="checkmark"></span>
                ' . $equipment->name . '
            </label>';
        }
        
        return response()->json([
            'html' => $html,
            'hasMore' => $equipments->count() === $limit,
            'nextOffset' => $offset + $limit
        ]);
    }
}
