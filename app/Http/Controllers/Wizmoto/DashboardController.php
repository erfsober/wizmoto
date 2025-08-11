<?php

namespace App\Http\Controllers\Wizmoto;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\category;
use Illuminate\Http\Request;

class DashboardController extends Controller {
    public function createAdvertisement ( ) {
        $category=category::query()->where('name','scooter')->first();
        $brands = Brand::where('category_id', $category->id)->get();

        return view('wizmoto.dashboard.create-advertisement',compact('brands'));
    }

    public function storeAdvertisement(Request $request){
        dd($request->all());

    }
}
