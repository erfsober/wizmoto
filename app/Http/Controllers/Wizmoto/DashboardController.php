<?php

namespace App\Http\Controllers\Wizmoto;

use App\Http\Controllers\Controller;

class DashboardController extends Controller {
    public function createAdvertisement ( ) {

        return view('wizmoto.dashboard.create-advertisement');
    }
}
