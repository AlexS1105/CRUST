<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\DiscordService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordResetLinkController extends Controller
{
    private $discordService;

    public function __construct(DiscordService $discordService)
    {
        $this->discordService = $discordService;
    }
    
    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    public function sent(Request $request)
    {
        try
        {
            $userData = $this->discordService->getUserData($request->code, config('services.discord.redirecturi.reset'));

            $status = Password::sendResetLink([
                'discord_id' => $userData['id']
            ], function($user, $token) {
                session()->put('token', $token);
            });

            return $status == Password::RESET_LINK_SENT
                    ? redirect()->route('password.reset', [
                        'discord_id' => $userData['id']
                    ])
                    : redirect()->route('password.request')->withInput($request->only('login'))
                            ->withErrors(['login' => __($status)]);
        } catch (Exception $e)
        {
            return redirect()->route('password.request')->withErrors([
                'discord' => $request->input('error_description', __('auth.discord_error'))
            ]);
        }
    }
}
