<?php

namespace App\Http\View\Composers;


use App\Models\AdvertisementType;
use App\Models\Brand;
use App\Models\VehicleModel;

use Illuminate\View\View;

class FooterComposer
{
    public function compose(View $view)
    {
        $footerData = [

            // Categories for footer navigation
            'vehicleTypes' => AdvertisementType::all(),
            'popularBrands' => Brand::query()
                                    ->orderBy('created_at', 'desc')
                                    ->take(4)->get(),
            'popularModels' => VehicleModel::query()
                                    ->with('brand')
                                    ->withCount('advertisements')
                                    ->orderBy('advertisements_count', 'desc')
                                    ->take(3)->get(),
            
            // Contact information
            'contactInfo' => [
                'email' => 'info@wizmoto.com',
                'phone' => '+1234567890',
                'address' => 'Your Business Address',
                'workingHours' => 'Mon-Fri: 9AM-6PM'
            ],
            
            // Social media links
            'socialMedia' => [
                'facebook' => 'https://facebook.com/wizmoto',
                'twitter' => 'https://twitter.com/wizmoto',
                'instagram' => 'https://instagram.com/wizmoto',
                'youtube' => 'https://youtube.com/wizmoto'
            ]
        ];

        $view->with($footerData);
    }
}