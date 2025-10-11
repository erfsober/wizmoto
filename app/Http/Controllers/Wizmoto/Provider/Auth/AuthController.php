<?php

namespace App\Http\Controllers\Wizmoto\Provider\Auth;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showAuthForm()
    {
        return view('wizmoto.provider.auth.auth');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        
        if (Auth::guard('provider')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('home'))
                ->with('toast_success', 'Welcome back! You have successfully logged in.');
        }

        // Check if user exists with this email
        $userExists = Provider::where('email', $request->email)->exists();
        
        if (!$userExists) {
            return back()
                ->with('toast_error', 'No account found with this email address.')
                ->with('suggest_register', true)
                ->onlyInput('email');
        }

        return back()
            ->with('toast_error', 'Incorrect password. Please check your password and try again.')
            ->onlyInput('email');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:providers,email',
            'password' => 'required|string|min:6',
            'privacy_policy' => 'accepted',
        ]);
        
        $provider = Provider::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        // $provider->sendEmailVerificationNotification();
        Auth::guard('provider')->login($provider);

        return redirect()->route('home')
            ->with('toast_success', 'Registration successful! Welcome to Wizmoto.');
    }

    public function logout(Request $request)
    {
        Auth::guard('provider')
            ->logout();
        $request->session()
            ->invalidate();
        $request->session()
            ->regenerateToken();

        return redirect()->route('provider.auth');
    }

    public function showForgotPasswordForm()
    {
        return view('wizmoto.provider.auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        
        $status = Password::broker('providers')->sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT 
            ? back()->with('toast_success', 'Password reset link has been sent to your email!')
            : back()->with('toast_error', 'We could not find an account with that email address.');
    }

    public function showResetForm($token)
    {
        return view('wizmoto.provider.auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
        
        $status = Password::broker('providers')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'), 
            function ($user) use ($request) {
                $user->forceFill(['password' => bcrypt($request->password)])->save();
            }
        );

        return $status === Password::PASSWORD_RESET 
            ? redirect()->route('provider.auth')->with('toast_success', 'Your password has been reset successfully!')
            : back()->with('toast_error', 'Failed to reset password. Please try again or request a new reset link.');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if provider exists
            $provider = Provider::where('google_id', $googleUser->id)
                ->orWhere('email', $googleUser->email)
                ->first();

            if ($provider) {
                // Update Google ID if needed
                if (!$provider->google_id) {
                    $provider->update([
                        'google_id' => $googleUser->id,
                        'oauth_provider' => 'google',
                        'email_verified_at' => now(),
                    ]);
                }
            } else {
                // Create new provider
                $provider = Provider::create([
                    'username' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'oauth_provider' => 'google',
                    'email_verified_at' => now(),
                    'password' => Hash::make(Str::random(24)), // Random password
                ]);
            }

            Auth::guard('provider')->login($provider);

            return redirect()->route('provider.dashboard')->with('success', 'Successfully logged in with Google!');
        } catch (\Exception $e) {
            return redirect()->route('provider.auth')->with('error', 'Google authentication failed. Please try again.');
        }
    }

    // Apple OAuth
    public function redirectToApple()
    {
        return Socialite::driver('apple')->redirect();
    }

    public function handleAppleCallback()
    {
        try {
            $appleUser = Socialite::driver('apple')->user();

            // Check if provider exists
            $provider = Provider::where('apple_id', $appleUser->id)
                ->orWhere('email', $appleUser->email)
                ->first();

            if ($provider) {
                // Update Apple ID if needed
                if (!$provider->apple_id) {
                    $provider->update([
                        'apple_id' => $appleUser->id,
                        'oauth_provider' => 'apple',
                        'email_verified_at' => now(),
                    ]);
                }
            } else {
                // Create new provider
                $provider = Provider::create([
                    'name' => $appleUser->name ?? 'Apple User',
                    'email' => $appleUser->email,
                    'apple_id' => $appleUser->id,
                    'oauth_provider' => 'apple',
                    'email_verified_at' => now(),
                    'password' => Hash::make(Str::random(24)), // Random password
                ]);
            }

            Auth::guard('provider')->login($provider);

            return redirect()->route('provider.dashboard')->with('success', 'Successfully logged in with Apple ID!');
        } catch (\Exception $e) {
            return redirect()->route('provider.auth')->with('error', 'Apple authentication failed. Please try again.');
        }
    }
}
