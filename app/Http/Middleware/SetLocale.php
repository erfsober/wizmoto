<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Available locales
        $locales = ['en', 'it'];
        
        // Get locale from route parameter (e.g., /it/home)
        $locale = $request->route('locale');
        
        // If not in route, check session
        if (!$locale) {
            $locale = Session::get('locale');
        }
        
        // If not in session, check browser preference
        if (!$locale) {
            $locale = $request->getPreferredLanguage($locales);
        }
        
        // Fallback to default
        if (!in_array($locale, $locales)) {
            $locale = config('app.locale', 'en');
        }
        
        // Set locale
        App::setLocale($locale);
        Session::put('locale', $locale);
        
        return $next($request);
    }
}

