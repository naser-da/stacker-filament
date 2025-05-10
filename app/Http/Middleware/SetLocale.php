<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // Check session first
        if (session()->has('locale')) {
            App::setLocale(session('locale'));
        }
        // Then check cookie
        elseif ($request->hasCookie('locale')) {
            $locale = $request->cookie('locale');
            App::setLocale($locale);
            session()->put('locale', $locale);
        }
        // Finally, check browser's preferred language
        else {
            $locale = $request->getPreferredLanguage(['en', 'ar']);
            App::setLocale($locale);
            session()->put('locale', $locale);
        }

        return $next($request);
    }
} 