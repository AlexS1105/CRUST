<?php

namespace App\Listeners;

use App\Events\CharacterCreated;
use App\Settings\CharsheetSettings;

class SetStartTalentPoints
{
    public $settings;

    public function __construct(CharsheetSettings $settings)
    {
        $this->settings = $settings;
    }

    public function handle(CharacterCreated $event)
    {
        $character = $event->character;

        $character->talent_points = $this->settings->talent_points;

        if ($character->should_receive_additional_talent_points) {
            $character->talent_points += $this->settings->additional_talent_points;
        }

        $character->save();
    }
}
