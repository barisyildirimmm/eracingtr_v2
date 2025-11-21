<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class MaintenanceMode
{
    /**
     * Handle an incoming request.
     * 
     * Maintenance mode açıksa tüm istekleri maintenance sayfasına yönlendirir
     * Sadece register route'una izin verir (kayıt devam etsin)
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Locale ayarını yap (maintenance sayfası için gerekli)
        $this->setLocale();
        
        // Maintenance mode kontrolü
        $maintenanceMode = env('MAINTENANCE_MODE', false);
        $openingDateString = env('MAINTENANCE_OPENING_DATETIME');
        $openingDate = null;
        
        if (!empty($openingDateString)) {
            try {
                $openingDate = Carbon::parse($openingDateString, config('app.timezone'));
            } catch (\Exception $exception) {
                $openingDate = null;
            }
        }
        
        // Boolean string kontrolü (env'den gelen değer string olabilir)
        if ($maintenanceMode === 'true' || $maintenanceMode === true || $maintenanceMode === '1' || $maintenanceMode === 1) {
            
            if ($openingDate instanceof Carbon) {
                if (Carbon::now()->greaterThanOrEqualTo($openingDate)) {
                    return $next($request);
                }
            }
            
            // Admin giriş yapmışsa tüm sayfaları görebilir
            // Session kontrolü - Önce Request üzerinden, sonra Session facade ile kontrol et
            // Session başlatılmamışsa başlat
            if (!$request->hasSession()) {
                $request->setLaravelSession(
                    app('session.store')
                );
            }
            
            $adminInfo = $request->session()->get('adminInfo');
            if ($adminInfo) {
                return $next($request);
            }
            
            // İzin verilen route'lar (kayıt işlemleri devam etsin)
            $allowedRoutes = [
                'DregisterPost',      // Kayıt POST
                'DverifyMailGet',     // Email doğrulama
                'change.locale',      // Dil değiştirme
                'AloginGet',          // Admin giriş sayfası
                'AloginPost',         // Admin giriş POST
            ];
            
            // İzin verilen path pattern'leri
            $allowedPatterns = [
                'register',           // Register route'u
                'verify-email',       // Email doğrulama linki
                'admin-giris',        // Admin giriş sayfası
                'loginPostA',         // Admin giriş POST
            ];
            
            $routeName = $request->route()?->getName();
            $path = $request->path();
            
            // Admin panel route'larına izin ver (admin prefix'i ile başlayan)
            if (str_starts_with($path, 'admin/')) {
                return $next($request);
            }
            
            // İzin verilen route'ları kontrol et
            $isAllowed = false;
            
            // Route name kontrolü
            if ($routeName && in_array($routeName, $allowedRoutes)) {
                $isAllowed = true;
            }
            
            // Path pattern kontrolü (route name yoksa veya eşleşmediyse)
            if (!$isAllowed) {
                foreach ($allowedPatterns as $pattern) {
                    if (str_contains($path, $pattern)) {
                        $isAllowed = true;
                        break;
                    }
                }
            }
            
            // İzin verilmeyen route'lar için maintenance sayfasına yönlendir
            if (!$isAllowed) {
                // AJAX istekleri için JSON response
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'error' => 'Site şu anda bakım modunda. Lütfen daha sonra tekrar deneyin.',
                        'maintenance' => true
                    ], 503);
                }
                
                // Normal istekler için maintenance view'ını göster
                return response()->view('maintenance', [
                    'openingDate' => $openingDate?->toIso8601String(),
                ], 503);
            }
        }
        
        return $next($request);
    }
    
    /**
     * Locale ayarını yapar (SetLocale middleware'i gibi)
     */
    private function setLocale(): void
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
    }
}

