<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Logging
{
    public function handle(Request $request, Closure $next)
    {
        $route = $request->route()->getName();
        $user = auth()->user() !== null ? auth()->user() : null;

        if (isset($user)) {
            Log::channel('daily_routes')->info($route, [
                'user' => $user->login,
                'ip' => $request->ip(),
            ]);
        }

        return $next($request);
    }
}
