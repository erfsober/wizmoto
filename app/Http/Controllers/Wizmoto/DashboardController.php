<?php

namespace App\Http\Controllers\Wizmoto;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdvertisementRequest;
use App\Events\MessageSent;
use App\Models\Advertisement;
use App\Models\AdvertisementType;
use App\Models\Brand;
use App\Models\Country;
use App\Models\City;
use App\Models\Equipment;
use App\Models\Message;
use App\Models\VehicleColor;
use App\Services\ChatEmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DashboardController extends Controller
{
    public function createAdvertisement()
    {
        $internationalPrefixes = [
            '+1',
            '+30',
            '+31',
            '+32',
            '+33',
            '+34',
            '+351',
            '+352',
            '+353',
            '+354',
            '+355',
            '+356',
            '+358',
            '+359',
            '+36',
            '+370',
            '+371',
            '+372',
            '+373',
            '+375',
            '+376',
            '+377',
            '+378',
            '+379',
            '+380',
            '+381',
            '+382',
            '+385',
            '+386',
            '+387',
            '+389',
            '+39',
            '+40',
            '+41',
            '+420',
            '+421',
            '+423',
            '+43',
            '+44',
            '+45',
            '+46',
            '+47',
            '+48',
            '+49',
            '+52',
            '+55',
            '+7',
            '+90',
        ];
        $provider = Auth::guard('provider')
            ->user();
        $advertisementTypes = AdvertisementType::query()
            ->get();
        $vehicleColors = VehicleColor::query()
            ->get();
        $countries = Country::query()->orderBy('name')->get();

        return view('wizmoto.dashboard.create-advertisement', compact('internationalPrefixes', 'provider', 'advertisementTypes', 'vehicleColors', 'countries'));
    }

    public function storeAdvertisement(StoreAdvertisementRequest $request)
    {
        try {
            $data = $request->validated();
            $data['is_metallic_paint'] = $request->has('is_metallic_paint');
            $data['show_phone'] = $request->has('show_phone');
            $data['price_negotiable'] = $request->has('price_negotiable');
            $data['tax_deductible'] = $request->has('tax_deductible');
            $data['service_history_available'] = $request->has('service_history_available');
            $data['warranty_available'] = $request->has('warranty_available');
            $data['financing_available'] = $request->has('financing_available');
            $data['trade_in_possible'] = $request->has('trade_in_possible');
            $data['available_immediately'] = $request->has('available_immediately');
            
            // Remove images field from data as it's handled by media library
            unset($data['images']);
            
            $advertisement = Advertisement::create($data);
            
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $advertisement->addMedia($file)
                        ->toMediaCollection('covers');
                }
            }
            
            if ($request->has('equipments')) {
                $advertisement->equipments()
                    ->sync($request->equipments);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Advertisement created successfully! Your ad will be visible on the site after admin verification.',
                'data' => $advertisement,
            ], 201);
            
        } catch (\Illuminate\Database\QueryException $e) {
           
            return response()->json([
                'status' => 'error',
                'message' => 'Database error occurred. Please check your data and try again.',
                'error_details' => config('app.debug') ? $e->getMessage() : 'Database error'
            ], 500);
            
        } catch (\Exception $e) {
   
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred. Please try again.',
                'error_details' => config('app.debug') ? $e->getMessage() : 'Server error'
            ], 500);
        }
    }

    public function myAdvertisements(Request $request)
    {
        $provider = Auth::guard('provider')
            ->user();
        $advertisements = Advertisement::query()
            ->where('provider_id', $provider->id);
        // Search
        if ($request->filled('search')) {
            $advertisements->Where('description', 'like', '%' . $request->search . '%');
        }
        // Sorting
        if ($request->sort === 'oldest') {
            $advertisements->orderBy('created_at');
        } else {
            $advertisements->orderByDesc('created_at');
        }
        $advertisements = $advertisements->paginate(10);

        return view('wizmoto.dashboard.my-advertisements', compact('advertisements', 'provider'));
    }

    public function profile()
    {
        $provider = Auth::guard('provider')
            ->user();

        return view('wizmoto.dashboard.profile', compact('provider'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::guard('provider')
            ->user();
        if (!$user) {
            return redirect()
                ->route('provider.auth')
                ->with('error', 'You must be logged in.');
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
        $user->seller_type = $request->input('seller_type', 'private');
        $user->show_info_in_advertisement = $request->has('show_info_in_advertisement');
        $user->save();
        if ($request->hasFile('image')) {
            $user->clearMediaCollection('image') // remove old
                ->addMedia($request->file('image'))
                ->toMediaCollection('image');
        }

        return back()->with('success', 'Profile updated successfully!');
    }

    public function deleteAdvertisement(Request $request)
    {
        // Get the advertisement ID from the request
        $advertisementId = $request->input('id');
        // Find the advertisement
        $advertisement = Auth::guard('provider')
            ->user()
            ->advertisements()
            ->find($advertisementId);
        if (!$advertisement) {
            return response()->json(['error' => 'Advertisement not found'], 404);
        }
        // Delete the advertisement
        $advertisement->delete();

        return response()->json([
            'success' => true,
            'message' => 'Advertisement deleted successfully',
        ]);
    }

    public function editAdvertisement($id)
    {
        $advertisement = Advertisement::query()
            ->with([
                'brand',
                'vehicleModel',
                'vehicleBody',
                'vehicleColor',
                'fuelType',
                'advertisementType',
                'equipments'
            ])
            ->findOrFail($id);
        $internationalPrefixes = [
            '+1',
            '+30',
            '+31',
            '+32',
            '+33',
            '+34',
            '+351',
            '+352',
            '+353',
            '+354',
            '+355',
            '+356',
            '+358',
            '+359',
            '+36',
            '+370',
            '+371',
            '+372',
            '+373',
            '+375',
            '+376',
            '+377',
            '+378',
            '+379',
            '+380',
            '+381',
            '+382',
            '+385',
            '+386',
            '+387',
            '+389',
            '+39',
            '+40',
            '+41',
            '+420',
            '+421',
            '+423',
            '+43',
            '+44',
            '+45',
            '+46',
            '+47',
            '+48',
            '+49',
            '+52',
            '+55',
            '+7',
            '+90',
        ];
        $provider = Auth::guard('provider')
            ->user();
        $advertisementTypes = AdvertisementType::all();
        $vehicleColors = VehicleColor::all();
        $brands = Brand::query()
            ->whereHas('advertisementTypes', function($q) use ($advertisement) {
                $q->where('advertisement_types.id', $advertisement->advertisement_type_id);
            })
            ->get();
        $equipments = Equipment::query()
            ->get();
        $countries = Country::query()->orderBy('name')->get();
        
        return view('wizmoto.dashboard.edit-advertisement', compact('advertisement', 'internationalPrefixes', 'brands', 'provider', 'advertisementTypes', 'vehicleColors', 'equipments', 'countries'));
    }

    public function updateAdvertisement(StoreAdvertisementRequest $request)
    {
        $data = $request->validated();
        $advertisement = Advertisement::findOrFail($request->advertisement_id);
        $data['is_metallic_paint'] = $request->has('is_metallic_paint');
        $data['show_phone'] = $request->has('show_phone');
        $data['price_negotiable'] = $request->has('price_negotiable');
        $data['tax_deductible'] = $request->has('tax_deductible');
        $data['service_history_available'] = $request->has('service_history_available');
        $data['warranty_available'] = $request->has('warranty_available');
        $data['financing_available'] = $request->has('financing_available');
        $data['trade_in_possible'] = $request->has('trade_in_possible');
        $data['available_immediately'] = $request->has('available_immediately');
        
        // Remove images field from data as it's handled by media library
        unset($data['images']);
        
        // Update advertisement
        $advertisement->update($data);
        // Handle new media uploads and map filename->media id
        $newFilesMap = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $media = $advertisement->addMedia($file)
                    ->toMediaCollection('covers');
                $newFilesMap[$file->getClientOriginalName()] = $media->id;
            }
        }
        // Apply ordering if provided

        if ($request->filled('images_order')) {
            $orderedIds = [];

            // Step 2: Build final order from tokens
            foreach (json_decode($request->input('images_order'), true) as $token) {
                if (Str::startsWith($token, 'existing:')) {
                    $orderedIds[] = (int) str_replace('existing:', '', $token);
                } elseif (Str::startsWith($token, 'new:')) {
                    $filename = str_replace('new:', '', $token);
                    if (isset($newFilesMap[$filename])) {
                        $orderedIds[] = $newFilesMap[$filename];
                    }
                }
            }

            // Step 3: Get all current media IDs
            $currentMediaIds = $advertisement->getMedia('covers')->pluck('id')->toArray();

            // Step 4: Delete media that are not in the final order
            $mediaToDelete = array_diff($currentMediaIds, $orderedIds);
            foreach ($mediaToDelete as $mediaId) {
                $media = Media::find($mediaId);
                if ($media) {
                    $media->delete();
                }
            }

            // Step 5: Set the new order
            if (!empty($orderedIds)) {
                Media::setNewOrder($orderedIds);
            }
        }
        // Sync equipments
        if ($request->has('equipments')) {
            $advertisement->equipments()
                ->sync($request->equipments);
        } else {
            $advertisement->equipments()
                ->sync([]); // remove all if none selected
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Advertisement updated successfully.',
            'data' => $advertisement,
        ], 200);
    }

    public function messagesIndex()
    {
        $provider = Auth::guard('provider')->user();

        // Get all conversations for this provider using the new conversation-based approach
        $conversations = \App\Models\Conversation::where('provider_id', $provider->id)
            ->with(['guest', 'provider', 'messages'])
            ->orderBy('updated_at', 'desc')
            ->get();

        // Add avatar URL to provider
        $provider->avatar = $provider->getFirstMediaUrl('image');

        return view('wizmoto.dashboard.messages', compact('provider', 'conversations'));
    }

    public function fetchMessages()
    {
        $provider = Auth::guard('provider')->user();

        // Get all messages for this provider with guests
        $messages = Message::where('provider_id', $provider->id)
            ->with(['guest', 'provider'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'guest_id' => 'required|exists:guests,id',
            'message' => 'required|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::guard('provider')->user();

        $message = Message::create([
            'guest_id' => $request->guest_id,
            'provider_id' => $user->id,
            'sender_type' => 'provider',
            'message' => $request->input('message')
        ]);

        // Broadcast the message
        broadcast(new MessageSent($message));

        // ChatEmailService::sendProviderReplyToGuest($message);

        return ['status' => 'Message Sent!'];
    }

    public function getCities(Request $request)
    {
        $countryId = $request->get('country_id');
        $cities = City::where('country_id', $countryId)->get();
        return response()->json(['cities' => $cities]);
    }
}
