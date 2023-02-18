<?php

namespace App\Listeners;

use App\Events\CharacterCreated;
use App\Settings\CharsheetSettings;

class SetStartSkillPoints
{
    public $settings;

    public function __construct(CharsheetSettings $settings)
    {
        $this->settings = $settings;
    }

    public function handle(CharacterCreated $event)
    {
        $character = $event->character;

        $character->skill_points = $this->settings->skill_points;

        if ($character->should_receive_additional_skill_points) {
            $character->skill_points += $this->settings->additional_skill_points;
        }

        $character->save();
    }
}
