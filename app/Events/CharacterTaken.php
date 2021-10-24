<?php

namespace App\Events;

use App\Models\Character;
use Illuminate\Queue\SerializesModels;

class CharacterTaken
{
    use SerializesModels;

    public Character $character;

    public function __construct(Character $character)
    {
        $this->character = $character;
    }
}
