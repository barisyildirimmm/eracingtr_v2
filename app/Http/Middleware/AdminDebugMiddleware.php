<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminDebugMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (session('adminInfo') && session('adminInfo')->id == 1) {
            config(['app.debug' => true]);
        }

        return $next($request);
    }
}