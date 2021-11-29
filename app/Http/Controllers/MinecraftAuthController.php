<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Support\Facades\Hash;

class MinecraftAuthController extends Controller
{
    public function __invoke()
    {
        $login = request('login');
        $password = request('password');

        if (isset($login) && isset($password)) {
            $character = Character::with('user')
                ->where('login', $login)
                ->first();

            if (isset($character)) {
                $user = $character->user;

                if (Hash::check($password, $user->password)) {
                    return "OK:$login";
                }
            }
        }

        return __('minecraft.auth_failed');
    }
}
