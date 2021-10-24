<?php

namespace App\Events;

use App\Models\Character;
use App\Models\User;
use Illuminate\Queue\SerializesModels;

class CharacterReapproval
{
    use SerializesModels;

    public Character $character;
    public User $user;

    public function __construct(Character $character, User $user)
    {
        $this->character = $character;
        $this->user = $user;
    }
}
