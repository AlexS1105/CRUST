<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserAuthorizedInLauncher
{
    use Dispatchable, SerializesModels;

    public $login;

    public function __construct($login)
    {
        $this->login = $login;
    }
}
