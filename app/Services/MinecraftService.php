<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Character;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MinecraftService
{
    public function auth($request)
    {
        try {
            $login = $request->login;
            $password = $request->password;
            $this->checkUser($login, $password);

            return $this->launcherResponse("OK:{$login}");
        } catch (Exception $e) {
            return $this->launcherResponse(
                empty($e->getMessage()) ?
                    __('minecraft.auth.failed') : $e->getMessage()
            );
        }
    }

    private function checkUser($login, $password)
    {
        if (! isset($login) || ! isset($password)) {
            throw new Exception(__('minecraft.auth.credentials'));
        }

        $character = Character::firstWhere(DB::raw('BINARY `login`'), $login);

        if (isset($character) && $character->registered) {
            $user = $character->user;

            if (! config('services.minecraft.characters_auth')) {
                throw new Exception(__('minecraft.auth.characters'));
            }
        } else {
            $account = Account::firstWhere(DB::raw('BINARY `login`'), $login);

            if (isset($account)) {
                $user = $account->user;

                if (! config('services.minecraft.accounts_auth')) {
                    throw new Exception(__('minecraft.auth.accounts'));
                }
            }
        }

        if (isset($user)) {
            if (Hash::check($password, $user->password) && $user->isBanned) {
                throw new Exception($user->ban->message);
            }
        } else {
            throw new Exception();
        }
    }

    private function launcherResponse($message)
    {
        return response($message, 200)->header('Content-Type', 'text/plain');
    }
}
