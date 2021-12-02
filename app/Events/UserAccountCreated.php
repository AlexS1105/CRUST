<?php

namespace App\Events;

use App\Models\Account;
use Illuminate\Queue\SerializesModels;

class UserAccountCreated
{
    use SerializesModels;

    public Account $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }
}
