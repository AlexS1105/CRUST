<?php

namespace App\Http\Controllers;

use App\Services\DiscordService;
use Illuminate\Http\Request;

class DiscordController extends Controller
{
    public function invite()
    {
        return redirect(config('services.discord.invite'));
    }

    public function verify(DiscordService $discordService)
    {
        $user = auth()->user();

        if ($user->verified) {
            return to_route('characters.index');
        }

        $discordService->verifyUser($user);

        return view('discord.index');
    }

    public function unverifyUser(DiscordService $discordService, Request $request)
    {
        $discordService->unverifyUser($request);

        return response('success', 200);
    }
}
