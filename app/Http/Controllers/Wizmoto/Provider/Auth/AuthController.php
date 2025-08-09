<?php

namespace App\Http\Controllers\Wizmoto\Provider\Auth;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {
    public function showAuthForm () {
        return view('wizmoto.provider.auth.auth');
    }

    public function login ( Request $request ) {
        $credentials = $request->validate([
                                              'email' => 'required|email' ,
                                              'password' => 'required|string' ,
                                          ]);
        if ( Auth::guard('provider')
                 ->attempt($credentials , $request->filled('remember')) ) {
            $request->session()
                    ->regenerate();

            return redirect()->intended(route('home'));
        }

        return back()
            ->withErrors([
                             'login_error' => 'Invalid credentials' ,
                         ])
            ->onlyInput('email');
    }

    public function register ( Request $request ) {
        $request->validate([
                               'username' => 'required|string|max:255' ,
                               'email' => 'required|email|unique:providers,email' ,
                               'password' => 'required|string|min:6' ,
                           ]);
        $provider = Provider::create([
                                         'username' => $request->username ,
                                         'email' => $request->email ,
                                         'password' => Hash::make($request->password) ,
                                     ]);
        Auth::guard('provider')
            ->login($provider);

        return redirect()->route('home');
    }

    public function logout ( Request $request ) {
        Auth::guard('provider')
            ->logout();
        $request->session()
                ->invalidate();
        $request->session()
                ->regenerateToken();

        return redirect()->route('provider.auth');
    }
}
