<?php

namespace App\Http\Controllers\Wizmoto;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;

class AdvertisementController extends Controller {
    public function show ( $id ) {

        return view('wizmoto.advertisements.show');
    }
}
