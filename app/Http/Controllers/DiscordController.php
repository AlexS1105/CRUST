<?php

namespace App\Http\Controllers;

use App\Services\DiscordService;
use Illuminate\Http\Request;

class DiscordController extends Controller
{
    public function unverifyUser(DiscordService $discordService, Request $request)
    {
        $discordService->unverifyUser($request);

        return response('success', 200);
    }
}
