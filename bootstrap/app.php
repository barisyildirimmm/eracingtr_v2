<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminDebugMiddleware;
use App\Http\Middleware\SetLocale;
use App\Http\Middleware\MaintenanceMode;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Maintenance mode StartSession'dan sonra çalışmalı (session okunabilmesi için)
        // prependToGroup yerine appendToGroup kullanıyoruz ama priority ile sıralama yapabiliriz
        $middleware->appendToGroup('web', MaintenanceMode::class);
        $middleware->appendToGroup('web', SetLocale::class);
        $middleware->appendToGroup('web', AdminDebugMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
