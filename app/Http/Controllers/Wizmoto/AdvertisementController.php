<?php

namespace App\Http\Controllers\Wizmoto;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;

class AdvertisementController extends Controller
{
    public function show($id)
    {
        $advertisement = Advertisement::with([
            'brand',
            'vehicleModel',
            'vehicleBody',
            'vehicleColor',
            'fuelType',
            'advertisementType',
            'equipments',
            'provider'
        ])->findOrFail($id);
       
    

        $relatedAdvertisements = Advertisement::where('id', '!=', $id)
            ->where(function ($query) use ($advertisement) {
                $query->where('brand_id', $advertisement->brand_id)
                    ->orWhere('advertisement_type_id', $advertisement->advertisement_type_id)
                    ->orWhereBetween('final_price', [
                        $advertisement->final_price * 0.7,
                        $advertisement->final_price * 1.3
                    ]);
            })
            ->with(['brand', 'vehicleModel', 'provider'])
            ->latest()
            ->take(6)
            ->get();

        return view('wizmoto.advertisements.show', compact('advertisement', 'relatedAdvertisements'));
    }
}
