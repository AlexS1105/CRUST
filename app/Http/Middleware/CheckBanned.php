<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckBanned
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        if (auth()->check() && $user->ban && now()->lessThan($user->ban->expires))
        {
            $ban = $user->ban;
            $by = $ban->by;
            $expires = Carbon::parse($user->ban->expires)->diffForHumans();
            
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('login', [
                'error' => "You are banned by {$by->login}, reason: {$ban->reason}. Ban will expire {$expires}"
            ]);
        }

        return $next($request);
    }
}
