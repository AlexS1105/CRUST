<?php

namespace App\Services;

use App\Events\UserAccountCreated;
use App\Events\UserAccountDeleted;

class AccountService
{
    public function createAccount($user, $validated)
    {
        $account = $user->accounts()->create($validated);

        event(new UserAccountCreated($account));
    }

    public function deleteAccount($account)
    {
        event(new UserAccountDeleted($account));

        $account->delete();
    }
}
