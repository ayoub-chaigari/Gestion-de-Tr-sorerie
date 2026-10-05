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
        $locale = Session::get('locale');

        if (!$locale) {
            if (auth()->check()) {
                $locale = auth()->user()->locale;
            } else {
                // Detect browser language
                $browserLocales = $request->getLanguages();
                foreach($browserLocales as $lang) {
                    if (str_starts_with($lang, 'en')) {
                        $locale = 'en';
                        break;
                    }
                    if (str_starts_with($lang, 'fr')) {
                        $locale = 'fr';
                        break;
                    }
                }
            }
        }

        $locale = $locale ?: config('app.locale', 'fr');

        App::setLocale($locale);
        Session::put('locale', $locale);

        return $next($request);
    }
}
