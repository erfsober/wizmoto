<?php

namespace App\Http\Controllers\Wizmoto;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;

class HomeController extends Controller {
    public function index () {
        $newAdvertisements = Advertisement::query()
                                          ->latest()
                                          ->limit(12)
                                          ->get();
        $usedAdvertisements = Advertisement::query()
                                          ->where('vehicle_category' , 'Used')
                                          ->latest()
                                          ->limit(12)
                                          ->get();

        return view('wizmoto.home.index' , compact('newAdvertisements','usedAdvertisements'));
    }
    public function inventoryList () {
        $advertisements = Advertisement::query()->get();

        return view('wizmoto.home.inventory-list' , compact('advertisements'));
    }
}
