<?php

namespace App\Http\Controllers\Wizmoto;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdvertisementRequest;
use App\Models\Advertisement;
use App\Models\AdvertisementType;
use App\Models\Brand;
use App\Models\Equipment;
use App\Models\VehicleColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {
    public function createAdvertisement () {
        $internationalPrefixes = [
            '+1' ,
            '+30' ,
            '+31' ,
            '+32' ,
            '+33' ,
            '+34' ,
            '+351' ,
            '+352' ,
            '+353' ,
            '+354' ,
            '+355' ,
            '+356' ,
            '+358' ,
            '+359' ,
            '+36' ,
            '+370' ,
            '+371' ,
            '+372' ,
            '+373' ,
            '+375' ,
            '+376' ,
            '+377' ,
            '+378' ,
            '+379' ,
            '+380' ,
            '+381' ,
            '+382' ,
            '+385' ,
            '+386' ,
            '+387' ,
            '+389' ,
            '+39' ,
            '+40' ,
            '+41' ,
            '+420' ,
            '+421' ,
            '+423' ,
            '+43' ,
            '+44' ,
            '+45' ,
            '+46' ,
            '+47' ,
            '+48' ,
            '+49' ,
            '+52' ,
            '+55' ,
            '+7' ,
            '+90' ,
        ];
        $provider = Auth::guard('provider')
                        ->user();
        $advertisementTypes = AdvertisementType::query()
                                               ->get();
        $vehicleColors = VehicleColor::query()
                                     ->get();

        return view('wizmoto.dashboard.create-advertisement' , compact('internationalPrefixes' , 'provider' , 'advertisementTypes' , 'vehicleColors'));
    }

    public function storeAdvertisement ( StoreAdvertisementRequest $request ) {
        $data = $request->validated();
        $data[ 'is_metallic_paint' ] = $request->has('is_metallic_paint');
        $data[ 'show_phone' ] = $request->has('show_phone');
        $data[ 'damaged_vehicle' ] = $request->has('damaged_vehicle');
        $data[ 'price_negotiable' ] = $request->has('price_negotiable');
        $data[ 'tax_deductible' ] = $request->has('tax_deductible');
        $data[ 'coupon_documentation' ] = $request->has('coupon_documentation');
        $advertisement = Advertisement::create($data);
        if ( $request->hasFile('images') ) {
            foreach ( $request->file('images') as $file ) {
                $advertisement->addMedia($file)
                              ->toMediaCollection('covers');
            }
        }
        if ( $request->has('equipments') ) {
            $advertisement->equipments()
                          ->sync($request->equipments);
        }

        return response()->json([
                                    'status' => 'success' ,
                                    'message' => 'Advertisement created successfully.' ,
                                    'data' => $advertisement ,
                                ] , 201);
    }

    public function myAdvertisements ( Request $request ) {
        $provider = Auth::guard('provider')
                        ->user();
        $advertisements = Advertisement::query()
                                       ->where('provider_id' , $provider->id);
        // Search
        if ( $request->filled('search') ) {
            $advertisements->Where('description' , 'like' , '%' . $request->search . '%');
        }
        // Sorting
        if ( $request->sort === 'oldest' ) {
            $advertisements->orderBy('created_at');
        }
        else {
            $advertisements->orderByDesc('created_at');
        }
        $advertisements = $advertisements->paginate(10);

        return view('wizmoto.dashboard.my-advertisements' , compact('advertisements' , 'provider'));
    }

    public function profile () {
        $provider = Auth::guard('provider')
                        ->user();

        return view('wizmoto.dashboard.profile' , compact('provider'));
    }

    public function updateProfile ( Request $request ) {
        $user = Auth::guard('provider')
                    ->user();
        if ( !$user ) {
            return redirect()
                ->route('provider.auth')
                ->with('error' , 'You must be logged in.');
        }
        $user->title = $request->input('title');
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->whatsapp = $request->input('whatsapp');
        $user->address = $request->input('address');
        $user->village = $request->input('village');
        $user->zip_code = $request->input('zip_code');
        $user->city = $request->input('city');
        $user->show_info_in_advertisement = $request->has('show_info_in_advertisement');
        $user->save();
        if ( $request->hasFile('image') ) {
            $user->clearMediaCollection('image') // remove old
                 ->addMedia($request->file('image'))
                 ->toMediaCollection('image');
        }

        return back()->with('success' , 'Profile updated successfully!');
    }

    public function deleteAdvertisement ( Request $request ) {
        // Get the advertisement ID from the request
        $advertisementId = $request->input('id');
        // Find the advertisement
        $advertisement = Auth::guard('provider')
                             ->user()
                             ->advertisements()
                             ->find($advertisementId);
        if ( !$advertisement ) {
            return response()->json([ 'error' => 'Advertisement not found' ] , 404);
        }
        // Delete the advertisement
        $advertisement->delete();

        return response()->json([
                                    'success' => true ,
                                    'message' => 'Advertisement deleted successfully' ,
                                ]);
    }

    public function editAdvertisement ( $id ) {
        $advertisement = Advertisement::query()
                                      ->with([
                                                 'brand' ,
                                                 'vehicleModel' ,
                                                 'vehicleBody' ,
                                                 'vehicleColor' ,
                                                 'fuelType' ,
                                                 'advertisementType',
                                                 'equipments'
                                             ])
                                      ->findOrFail($id);
        $internationalPrefixes = [
            '+1' ,
            '+30' ,
            '+31' ,
            '+32' ,
            '+33' ,
            '+34' ,
            '+351' ,
            '+352' ,
            '+353' ,
            '+354' ,
            '+355' ,
            '+356' ,
            '+358' ,
            '+359' ,
            '+36' ,
            '+370' ,
            '+371' ,
            '+372' ,
            '+373' ,
            '+375' ,
            '+376' ,
            '+377' ,
            '+378' ,
            '+379' ,
            '+380' ,
            '+381' ,
            '+382' ,
            '+385' ,
            '+386' ,
            '+387' ,
            '+389' ,
            '+39' ,
            '+40' ,
            '+41' ,
            '+420' ,
            '+421' ,
            '+423' ,
            '+43' ,
            '+44' ,
            '+45' ,
            '+46' ,
            '+47' ,
            '+48' ,
            '+49' ,
            '+52' ,
            '+55' ,
            '+7' ,
            '+90' ,
        ];
        $provider = Auth::guard('provider')
                        ->user();
        $advertisementTypes = AdvertisementType::all();
        $vehicleColors = VehicleColor::all();
        $brands = Brand::query()
                       ->where('advertisement_type_id' , $advertisement->advertisement_type_id)
                       ->get();
        $equipments = Equipment::query()
                               ->get();
        return view('wizmoto.dashboard.edit-advertisement' , compact('advertisement' , 'internationalPrefixes' , 'brands' , 'provider' , 'advertisementTypes' , 'vehicleColors','equipments'));
    }

    public function updateAdvertisement ( StoreAdvertisementRequest $request ) {
        $data = $request->validated();
        $advertisement = Advertisement::findOrFail($request->advertisement_id);
        $data[ 'is_metallic_paint' ] = $request->has('is_metallic_paint');
        $data[ 'show_phone' ] = $request->has('show_phone');
        $data[ 'damaged_vehicle' ] = $request->has('damaged_vehicle');
        $data[ 'price_negotiable' ] = $request->has('price_negotiable');
        $data[ 'tax_deductible' ] = $request->has('tax_deductible');
        $data[ 'coupon_documentation' ] = $request->has('coupon_documentation');
        // Update advertisement
        $advertisement->update($data);
        // Handle new media uploads
        if ( $request->hasFile('images') ) {
            foreach ( $request->file('images') as $file ) {
                $advertisement->addMedia($file)
                              ->toMediaCollection('covers');
            }
        }
        // Sync equipments
        if ( $request->has('equipments') ) {
            $advertisement->equipments()
                          ->sync($request->equipments);
        }
        else {
            $advertisement->equipments()
                          ->sync([]); // remove all if none selected
        }

        return response()->json([
                                    'status' => 'success' ,
                                    'message' => 'Advertisement updated successfully.' ,
                                    'data' => $advertisement ,
                                ] , 200);
    }
}
