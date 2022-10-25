<?php

namespace App\Notifications;

use NotificationChannels\Discord\DiscordMessage;
use Termwind\Enums\Color;

class NewApplicationNotification extends CharacterNotification
{
    protected $registrarNotification = true;
    protected $color = Color::BLUE_500;

    public function toDiscord()
    {
        return DiscordMessage::create(
            '',
            array_merge_recursive($this->getEmbed(), [
                'title' => "Персонаж '{$this->character->name}' подан на проверку",
                'description' => 'Пожалуйста, возьмите на проверку как можно скорее!',
            ])
        );
    }
}
