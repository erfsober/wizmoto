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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $newAdvertisements = Advertisement::query()
            ->latest()
            ->limit(12)
            ->get();

        $brands = Brand::all();
        $vehicleModels = VehicleModel::all();
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
        $brands = Brand::all();
        $vehicleModels = VehicleModel::all();
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
            ->when($request->advertisement_type, function ($query, $type) {
                $query->where('advertisement_type_id', $type);
            })
            
            // LOCATION FILTERS
            ->when($request->filled('city'), fn($q) => $q->where('city', $request->city))
            ->when($request->filled('zip_code'), fn($q) => $q->where('zip_code', $request->zip_code))
            
            // VEHICLE BASIC DATA
            ->when($request->filled('vehicle_category'), fn($q) => $q->whereIn('vehicle_category', (array)$request->vehicle_category))
            ->when($request->filled('vehicle_body_id'), fn($q) => $q->whereIn('vehicle_body_id', (array)$request->vehicle_body_id))
            
            // BRAND/MODEL (support multiple vehicle groups)
            ->when($request->filled('brand_id'), function ($q) use ($request) {
                $brandIds = is_array($request->brand_id) ? $request->brand_id : [$request->brand_id];
                $q->whereIn('brand_id', array_filter($brandIds));
            })
            ->when($request->filled('vehicle_model_id'), function ($q) use ($request) {
                $modelIds = is_array($request->vehicle_model_id) ? $request->vehicle_model_id : [$request->vehicle_model_id];
                $q->whereIn('vehicle_model_id', array_filter($modelIds));
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
            ->when($request->filled('damaged_vehicle'), fn($q) => $q->where('damaged_vehicle', false))
            ->when($request->filled('coupon_documentation'), fn($q) => $q->where('coupon_documentation', true))
            ->when($request->filled('price_negotiable'), fn($q) => $q->where('price_negotiable', true))
            ->when($request->filled('tax_deductible'), fn($q) => $q->where('tax_deductible', true))
            
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

        return view('wizmoto.home.inventory-list', compact('advertisements', 'brands', 'vehicleModels', 'advertisementTypes', 'fuelTypes', 'vehicleBodies', 'vehicleColors', 'equipments'));
    }
}
