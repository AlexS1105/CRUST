<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Character;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class MinecraftAuthController extends Controller
{
    public function __invoke()
    {
        try {
            $login = request('login');
            $password = request('password');
    
            if (isset($login) && isset($password)) {
                $character = Character::with('user')
                    ->where('login', $login)
                    ->first();
    
                if (isset($character)) {
                    $user = $character->user;

                    if (config('services.minecraft.characters_auth')) {
                        throw new Exception(__('minecraft.auth_characters'));
                    }
                } else {
                    $account = Account::with('user')
                        ->where('login', $login)
                        ->first();
    
                    if (isset($account)) {
                        $user = $account->user;
                    }

                    if (config('services.minecraft.characters_auth')) {
                        throw new Exception(__('minecraft.auth_accounts'));
                    }
                }
    
                if (isset($user) && Hash::check($password, $user->password)) {
                    return response("OK:$login", 200)->header('Content-Type', 'text/plain');
                }
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        return response(__('minecraft.auth_failed'), 200)->header('Content-Type', 'text/plain');
    }
}
