<?php

namespace App\Http\Middleware;

use App\Jobs\Discord\VerifyUser;
use Closure;
use Illuminate\Http\Request;

class EnsureDiscordVerified
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        if (auth()->check() && ! $user->verified) {
            VerifyUser::dispatch($user);

            if (! $user->verified) {
                return redirect()->route('discord.verify');
            }
        }

        return $next($request);
    }
}
