<?php

namespace App\Http\Controllers\Wizmoto\Provider\Auth;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class ProviderController extends Controller {
    public function emailVerify ( Request $request , $id , $hash ) {
        $provider = Provider::query()
                            ->findOrFail($id);
        if ( !hash_equals((string)$hash , sha1($provider->getEmailForVerification())) ) {
            abort(403 , 'Invalid verification link.');
        }
        if ( $provider->hasVerifiedEmail() ) {
            return redirect()
                ->route('home')
                ->with('status' , 'Email already verified.');
        }
        $provider->markEmailAsVerified();
        event(new Verified($provider));

        return redirect()
            ->route('home')
            ->with('status' , 'Email verified successfully!');
    }

    public function show ( $id ) {
        $provider = Provider::query()->with(['reviews'])
                            ->where('id' , $id)
                            ->firstOr(function () {
                                return redirect()
                                    ->back()
                                    ->with('status' , 'This  provider doesnt exist!');
                            });
        $advertisements = $provider->advertisements()
                                   ->latest()
                                   ->take(10)->get();

        return view('wizmoto.provider.show' , compact('provider' , 'advertisements'));
    }
}
