<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\DiscordService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;

class PasswordResetLinkController extends Controller
{
    public function create()
    {
        return view('auth.forgot-password');
    }

    public function sent(DiscordService $discordService, Request $request)
    {
        try {
            $userData = $discordService->getUserData(
                $request->code,
                config('services.discord.redirecturi.reset')
            );

            $status = Password::sendResetLink([
                'discord_id' => $userData['id'],
            ], function ($user, $token) {
                session()->put('token', $token);
            });

            return $status === Password::RESET_LINK_SENT
                ? to_route('password.reset', [
                    'discord_id' => $userData['id'],
                ])
                : to_route('password.request')->withInput($request->only('login'))
                    ->withErrors(['login' => __($status)]);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return to_route('password.request')->withErrors([
                'discord' => $request->input('error_description', __('auth.discord_error')),
            ]);
        }
    }
}
