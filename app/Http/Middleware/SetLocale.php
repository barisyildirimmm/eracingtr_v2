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
        // Desteklenen diller
        $supportedLocales = ['tr', 'en', 'de', 'fr', 'it', 'pt', 'es', 'az'];
        
        // Varsayılan dil Türkçe
        $defaultLocale = 'tr';
        
        // Session'dan dil'i al
        $locale = Session::get('locale');
        
        // Eğer session'da dil yoksa veya geçersiz bir dil varsa, varsayılan Türkçe'yi kullan
        if (empty($locale) || !in_array($locale, $supportedLocales)) {
            $locale = $defaultLocale;
            Session::put('locale', $locale);
        }
        
        // Uygulama dilini ayarla
        App::setLocale($locale);
        
        return $next($request);
    }
}

