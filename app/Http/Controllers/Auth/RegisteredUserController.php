<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\DiscordService;
use App\Providers\RouteServiceProvider;
use App\Rules\DiscordTag;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use NotificationChannels\Discord\Discord;

class RegisteredUserController extends Controller
{
    private $discordService;

    public function __construct(DiscordService $discordService)
    {
        $this->discordService = $discordService;
    }

    public function create(Request $request)
    {
        try
        {
            $userData = $this->discordService->getUserData($request->input('code'));

            return view('auth.register', [
                'discord_data' => $userData
            ]);
        } catch (Exception $e)
        {
            return view('auth.login')->with('error', $request->input('error_description', 'Unknown Discord authorization error'));
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'discord_tag' => ['required', new DiscordTag, 'unique:users'],
            'discord_id' => ['required', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'age_confirmation' => ['accepted'],
            'rules_confirmation' => ['accepted']
        ]);

        $discordId = $request->discord_id;
        $channelId = app(Discord::class)->getPrivateChannel($discordId);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'discord_tag' => $request->discord_tag,
            'discord_id' => $discordId,
            'discord_private_channel_id' => $channelId,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
