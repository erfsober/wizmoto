<?php

namespace App\Http\Controllers\Wizmoto\Provider\Auth;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

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
        $provider = Provider::query()
                            ->create([
                                         'username' => $request->username ,
                                         'email' => $request->email ,
                                         'password' => Hash::make($request->password) ,
                                     ]);
        $provider->sendEmailVerificationNotification();
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

    public function showForgotPasswordForm () {
        return view('wizmoto.provider.auth.forgot-password');
    }

    public function sendResetLink ( Request $request ) {
        $request->validate([
                               'email' => 'required|email' ,
                           ]);
        $status = Password::broker('providers')
                          ->sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT ? back()->with('status' , __($status)) : back()->withErrors([ 'email' => __($status) ]);
    }

    public function showResetForm ( $token ) {
        return view('wizmoto.provider.auth.reset-password' , [ 'token' => $token ]);
    }

    public function resetPassword ( Request $request ) {
        $request->validate([
                               'token' => 'required' ,
                               'email' => 'required|email' ,
                               'password' => 'required|min:8|confirmed' ,
                           ]);
        $status = Password::broker('providers')
                          ->reset($request->only('email' , 'password' , 'password_confirmation' , 'token') , function ( $user ) use ( $request ) {
                              $user->forceFill([
                                                   'password' => bcrypt($request->password) ,
                                               ])
                                   ->save();
                          });

        return $status === Password::PASSWORD_RESET ? redirect()
            ->route('provider.auth')
            ->with('status' , __($status)) : back()->withErrors([ 'email' => __($status) ]);
    }
}
