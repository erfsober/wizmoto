<?php

namespace App\Http\Controllers\Wizmoto\Provider\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {
    public function showLoginForm () {
        return view('wizmoto.provider.auth.login');
    }

    public function login ( Request $request ) {
        $credentials = $request->only('email' , 'password');
        if ( Auth::guard('provider')
                 ->attempt($credentials) ) {
            return redirect()->intended('/provider/dashboard');
        }

        return back()->withErrors([ 'email' => 'Invalid credentials' ]);
    }

    public function logout () {
        Auth::guard('provider')
            ->logout();

        return redirect()->route('provider.login');
    }
}

