<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ServiceProviderMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->role !== 'service_provider') {
            abort(403);
        }

        return $next($request);
    }
}
