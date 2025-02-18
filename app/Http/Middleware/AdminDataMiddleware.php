<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;

class AdminDataMiddleware
{
    public function handle($request, Closure $next)
    {
        if (auth()->guard('admin')->check()) {
            $admin = auth()->guard('admin')->user();
            View::share('admin', $admin);
        }

        return $next($request);
    }
}
