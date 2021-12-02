<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Character;
use Exception;
use Illuminate\Support\Facades\Hash;

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
                } else {
                    $account = Account::with('user')
                        ->where('login', $login)
                        ->first();
    
                    if (isset($account)) {
                        $user = $account->user;
                    }
                }
    
                if (isset($user) && Hash::check($password, $user->password)) {
                    return "OK:$login";
                }
            }
        } catch (Exception $e) {

        }

        return __('minecraft.auth_failed');
    }
}
