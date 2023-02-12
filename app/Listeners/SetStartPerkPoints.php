<?php

namespace App\Listeners;

use App\Events\CharacterCreated;
use App\Settings\CharsheetSettings;

class SetStartPerkPoints
{
    public $settings;

    public function __construct(CharsheetSettings $settings)
    {
        $this->settings = $settings;
    }

    public function handle(CharacterCreated $event)
    {
        $character = $event->character;

        $character->perk_points = $this->settings->perk_points;

        if ($character->should_receive_additional_perk_points) {
            $character->perk_points += $this->settings->additional_perk_points;
        }

        $character->save();
    }
}
