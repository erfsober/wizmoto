<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate {
    public function handle ( Request $request , Closure $next ) {
        // Check if user is authenticated
        if ( !Auth::guard('provider')
                   ->check() ) {
            if ( !$request->expectsJson() ) {
                return redirect()->route('provider.auth'); // redirect to login
            }

            return response()->json([ 'message' => 'Unauthenticated.' ] , 401);
        }

        // Pass the request further
        return $next($request);
    }
}
