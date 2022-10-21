<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Rules\DiscordTag;
use App\Services\DiscordService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use NotificationChannels\Discord\Discord;

class RegisteredUserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'login' => ['required', 'string', 'max:255', 'unique:users'],
            'discord_tag' => ['required', new DiscordTag(), 'unique:users'],
            'discord_id' => ['required', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'age_confirmation' => ['accepted'],
            'rules_confirmation' => ['accepted'],
        ]);

        $discordId = $request->discord_id;

        $user = User::create([
            'login' => $request->login,
            'discord_tag' => $request->discord_tag,
            'discord_id' => $discordId,
            'discord_private_channel_id' => app(Discord::class)->getPrivateChannel($discordId),
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    public function create(DiscordService $discordService, Request $request)
    {
        return $discordService->auth($request);
    }
}
