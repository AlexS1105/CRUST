<?php

namespace App\Listeners;

use App\Events\CharacterCreated;
use App\Settings\CharsheetSettings;

class SetStartEstitence
{
    public $settings;

    public function __construct(CharsheetSettings $settings)
    {
        $this->settings = $settings;
    }

    public function handle(CharacterCreated $event)
    {
        $character = $event->character;

        $character->estitence = $this->settings->default_estitence;

        if ($character->should_receive_additional_estitence) {
            $character->estitence += $this->settings->additional_estitence;
        }

        $character->save();
    }
}
