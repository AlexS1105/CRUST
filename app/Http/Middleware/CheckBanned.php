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

            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'error' => __('ban.message', [
                    'admin' => $by->login,
                    'tag' => $by->discord_tag,
                    'reason' => $ban->reason,
                    'time' => Carbon::parse($user->ban->expires)->diffForHumans()
                ])
            ]);
        }

        return $next($request);
    }
}
